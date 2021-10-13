<?php

namespace App;

class DokanNavMenu {
    public $store_url = '#dokan-store-url';

    public function init() {
        add_action('admin_init', [$this, 'add_nav_menu_meta_boxes']);
        add_filter('wp_get_nav_menu_items', [$this, 'set_vendor_store_url']);
    }

	/**
	 * Add custom nav meta box
	 *
	 * Adapted from http://www.johnmorrisonline.com/how-to-add-a-fully-functional-custom-meta-box-to-wordpress-navigation-menus/.
	 */
	public function add_nav_menu_meta_boxes() {
		add_meta_box('dokan_endpoints_nav_link', __('Dokan endpoints', 'sage'), [$this, 'nav_menu_links'], 'nav-menus', 'side', 'low');
	}

	/**
	 * Get dokan nav endpoitns
	 */
    public function get_dokan_nav_endpoints() {
        // get items from dokan menu
        // since dokan_get_dashboard_nav function is not available in admin, use filter
		$endpoints = apply_filters('dokan_get_dashboard_nav', []);
        if (empty($endpoints)) return [];

        $payload = [];

        // add unique key to each endpoint
        foreach($endpoints as $endpoint) {
            $key = sanitize_title($endpoint['title']);

            $payload[$key] = $endpoint;
        }

        return $payload;
    }

	public function get_vendor_store_url() {
		$myaccount_url = dokan_get_page_url('myaccount', 'woocommerce');
		$migrate_url = $myaccount_url . 'account-migration';

		// if is logged out, direct to login page
		if (!is_user_logged_in()) return $myaccount_url;

		$user_id = get_current_user_id();
		
		// if is not seller, direct to account upgrade
		if (!dokan_is_user_seller($user_id)) return $migrate_url;

		return dokan_get_store_url($user_id);
	}

	/**
	 * Set vendor store url
	 */
    public function set_vendor_store_url($items) {
        if (is_admin()) return $items;

        foreach($items as $key => $item) {
            if ($item->url != $this->store_url) continue;

            $items[$key]->url = $this->get_vendor_store_url();
        }

        return $items;
    }

	/**
	 * Output the links
	 */
	public function nav_menu_links() {
		$view_args = [
			'endpoints' => $this->get_dokan_nav_endpoints(),
			'store_url' => $this->store_url,
		];

		echo \Roots\view('dokan.admin.nav-menu', $view_args)->render();
	}
}