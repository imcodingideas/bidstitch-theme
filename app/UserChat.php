<?php
namespace App;

use WP_REST_Response;
use WP_REST_Server;

class UserChat {
    /**
     * Hold the app_id
     *
     * @var string
    */
    private $app_id;

    /**
     * Hold the app_secret
     *
     * @var string
    */
    private $app_secret;

    function __construct() {
        $this->app_id = defined('TALKJS_APP_ID') ? TALKJS_APP_ID : null;
        $this->app_secret = defined('TALKJS_APP_SECRET') ? TALKJS_APP_SECRET : null;
    }

    function init() {
        // init rest routes
        add_action('rest_api_init', [$this, 'register_reset_routes'], 22);

        // render inbox page
        add_filter('dokan_get_dashboard_nav', [$this, 'dokan_add_inbox_menu'], 22, 1);
        add_filter('dokan_query_var_filter', [$this, 'dokan_add_endpoint'], 22, 1);
        add_action('dokan_load_custom_template', [$this, 'dokan_load_inbox_template'], 22);
        add_action('dokan_after_store_tabs', [$this, 'dokan_render_live_chat_button'], 22);

        // flush rewrite rules with woocommerce
        add_action('woocommerce_flush_rewrite_rules', [$this, 'flush_rewrite_rules'], 22);
    }

    function dokan_add_inbox_menu($urls) {
        if (dokan_is_seller_enabled(get_current_user_id())) {
            $urls['inbox'] = [
                'title' => __('Inbox', 'sage'),
                'icon' => '',
                'url' => dokan_get_navigation_url('inbox'),
                'pos' => 195,
                'permission' => 'dokan_view_inbox_menu',
            ];
        }

        return $urls;
    }

    function dokan_add_endpoint($query_var) {
        $query_var['inbox'] = 'inbox';

        return $query_var;
    }

    function dokan_load_inbox_template($query_vars) {
        if (!isset($query_vars['inbox'])) {
            return;
        }

        echo \Roots\view('dokan.user-chat.inbox')->render();
    }

    function flush_rewrite_rules() {
        add_filter('dokan_query_var_filter', [$this, 'dokan_add_endpoint']);
        dokan()->rewrite->register_rule();

        flush_rewrite_rules();
    }

    function register_reset_routes() {
        register_rest_route('chat/v1', '/session', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'create_session'],
                'permission_callback' => function() {
                    if (!is_user_logged_in()) return false;

                    return true;
                }
            ]
        ]);
    }
    
    function create_session($request) {
        $current_user_id = get_current_user_id();
        $receiver_data = $this->get_receiver_data($current_user_id, false);

        $payload = [
            'appId' => $this->app_id,
            'me' => $receiver_data,
            'signature' => hash_hmac('sha256', strval($current_user_id), $this->app_secret),
        ];

        return new WP_REST_Response([
            'data' => $payload,
        ], 200);
    }

    static function get_receiver_data($receiver_id = '', $encode = true) {
        if (empty($receiver_id)) return false;

        if (!is_user_logged_in()) return false;

        $receiver_user = get_user_by('ID', $receiver_id);
        if (empty($receiver_user)) return false;

        $payload = [
            'id' => $receiver_user->ID,
            'name' => $receiver_user->display_name,
            'photoUrl' => esc_url(get_avatar_url($receiver_user->ID)),
        ];

        if ($encode == false) return $payload;

        return json_encode($payload);
    }

    function dokan_render_live_chat_button($vendor_id) {
        if (empty($vendor_id)) return;

        $view_args = [
            'receiver_user_id' => $vendor_id,
        ];

        echo \Roots\view('dokan.user-chat.store-tabs', $view_args)->render();
    }
}