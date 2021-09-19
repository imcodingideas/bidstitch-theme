<?php
namespace App;

use WC_Countries;
use WP_REST_Response;
use WP_REST_Server;
use WeDevs\Dokan\Vendor\SetupWizard;

class OnboardingSetupWizard extends SetupWizard {
    /** @var string Onboarding URL slug */
    protected $slug = 'seller-setup';

    public function __construct() {
        add_filter('woocommerce_registration_redirect', array($this, 'filter_woocommerce_registration_redirect'), 11, 1);
        add_action('init', array($this, 'setup_wizard'), 99);
        add_action('rest_api_init', [$this, 'register_reset_routes'], 11);
    }

    // Define the woocommerce_registration_redirect callback
    public function filter_woocommerce_registration_redirect($var) {
        $url  = $var;
        $user = wp_get_current_user();

        if (in_array('seller', $user->roles)) {

            $url = dokan_get_navigation_url();

            if ('off' == dokan_get_option('disable_welcome_wizard', 'dokan_selling', 'off')) {
                $url = apply_filters('dokan_seller_setup_wizard_url', site_url('?page=' . $this->slug));
            }
        }

        return $url;
    }

    // Show setup wizard
    public function setup_wizard() {
        if (empty($_GET['page'])) return;

        // Redirect if previous setup wizard
        if ($_GET['page'] === 'dokan-seller-setup') {
            wp_safe_redirect(site_url('?page=' . $this->slug));
            exit();
        }
        
        if ($_GET['page'] !== $this->slug) return;

        if (!is_user_logged_in()) return;

        $this->store_id = dokan_get_current_user_id();
        $this->store_info = dokan_get_store_info($this->store_id);

        $steps = [
            'introduction' => [
                'name' => __('Introduction', 'sage'),
                'description' => '',
                'view' => [$this, 'dokan_setup_introduction'],
                'handler' => '',
            ],
            'store' => [
                'name' => __('Store Settings', 'sage'),
                'description' => __('Basic details of your store', 'sage'),
                'view' => [$this, 'dokan_setup_store'],
                'handler' => [$this, 'dokan_setup_store_save'],
            ],
            'payment' => [
                'name' => __('Payment Settings', 'sage'),
                'description' =>__('Payment method of your store', 'sage'),
                'view' => [$this, 'dokan_setup_payment'],
                'handler' => [$this, 'dokan_setup_payment_save'],
            ],
            'next_steps' => [
                'name' => __('Complete', 'sage'),
                'description' => __('Start selling on your store', 'sage'),
                'view' => [$this, 'dokan_setup_ready'],
                'handler' => '',
            ],
        ];

        $this->steps = apply_filters('dokan_seller_wizard_steps', $steps);
        $this->step = isset($_GET['step']) ? sanitize_key($_GET['step']) : current(array_keys($this->steps));

        if (!empty($_POST['save_step']) && isset($this->steps[$this->step]['handler'])) {
            call_user_func($this->steps[$this->step]['handler']);
        }

        ob_start();
        $this->setup_wizard_header();
        $this->setup_wizard_steps();
        $this->setup_wizard_content();
        $this->setup_wizard_footer();
        exit;
    }

    // Setup wizard header
    public function setup_wizard_header() {
        get_header();
    }

    // Setup wizard footer
    public function setup_wizard_footer() {
        get_footer();
    }

    // Setup wizard content
    public function setup_wizard_content() {
        if (empty($this->steps[$this->step]['view'])) {
            wp_safe_redirect(esc_url_raw(add_query_arg('step', 'introduction')));
            exit;
        }

        $current_step = $this->get_current_step();

        $view_args = [
            'content' => $current_step['view'],
            'title' => $current_step['name'],
        ];

        echo \Roots\view('dokan.onboarding.wrapper', $view_args)->render();
    }

    // Progress steps
    public function setup_wizard_steps() {
        echo \Roots\view('dokan.onboarding.steps', ['steps' => $this->get_user_steps()])->render();
    }

    // Introduction step
    public function dokan_setup_introduction() {
        $view_args = [
            'next_step_link' => $this->get_next_step_link(),
            'dashboard_link' => dokan_get_navigation_url(),
        ];

        echo \Roots\view('dokan.onboarding.welcome', $view_args)->render();
    }

    // Setup store step
    public function dokan_setup_store() {
        $store_info  = $this->store_info;

        $country_obj = new WC_Countries();
        
        $view_args = [
            'address_street1' => isset($store_info['address']['street_1']) ? $store_info['address']['street_1'] : '',
            'address_street2' => isset($store_info['address']['street_2']) ? $store_info['address']['street_2'] : '',
            'address_city' => isset($store_info['address']['city']) ? $store_info['address']['city'] : '',
            'address_zip' => isset($store_info['address']['zip']) ? $store_info['address']['zip'] : '',
            'address_country' => isset($store_info['address']['country']) ? $store_info['address']['country'] : '',
            'address_state' => isset($store_info['address']['state']) ? $store_info['address']['state'] : '',
            'countries' => $country_obj->countries,
            'next_step_link' => $this->get_next_step_link(),
        ];

        echo \Roots\view('dokan.onboarding.setup-store', $view_args)->render();
    }

    // Store payment step
    public function dokan_setup_payment() {
        $view_args = [
            'methods' => $this->get_withdraw_methods(),
            'store_info' => $this->store_info,
        ];

        echo \Roots\view('dokan.onboarding.setup-payment', $view_args)->render();
    }

    // Success step
    public function dokan_setup_ready() {
        $view_args = [
            'dashboard_link' => dokan_get_navigation_url(),
        ];

        echo \Roots\view('dokan.onboarding.setup-ready', $view_args)->render();
    }

    // Register REST API routes
    public function register_reset_routes() {
        register_rest_route('onboarding/v1', '/states', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_state_by_country'],
                'permission_callback' => function() {
                    if (!is_user_logged_in()) return false;
                    if (!dokan_is_seller_enabled(get_current_user_id())) return false;
                
                    return true;
                }
            ]
        ]);
    }
    
    // Fetch state by country
    function get_state_by_country($request) {
        $countries = new WC_Countries();

        $params = $request->get_query_params();

        if (!isset($params['country'])) {
            return new WP_REST_Response([
                'error' => 'Provide a country code',
            ], 400);
        }

        $is_country = $countries->country_exists($params['country']);

        if (!$is_country) {
            return new WP_REST_Response([
                'error' => 'Country not found',
            ], 404);
        }

        return new WP_REST_Response([
            'data' => $countries->get_states($params['country']),
        ], 200);
    }

    // Get dokan payment withdraw methods
    public function get_withdraw_methods() {
        $methods = dokan_withdraw_get_active_methods();

        $payload = [];

        foreach ($methods as $method_key) {
            $method = dokan_withdraw_get_method($method_key);

            if (isset($method['callback']) && is_callable($method['callback'])) {
                $payload[] = $method;
            }
        }

        return $payload;
    }

    // Get current step data
    public function get_current_step() {
        return $this->steps[$this->step];
    }

    // Get all steps
    public function get_user_steps() {
        $raw_steps = $this->steps;
        array_shift($raw_steps);

        $ouput_steps = [];

        foreach($raw_steps as $step_key => $step) {
            $payload = (object) [
                'name' => $step['name'],
                'description' => $step['description'],
                'complete' => array_search($this->step, array_keys($this->steps), true) > array_search($step_key, array_keys($this->steps), true),
                'current' => $step_key === $this->step,
            ];

            $ouput_steps[] = $payload;
        }

        return $ouput_steps;
    }
}