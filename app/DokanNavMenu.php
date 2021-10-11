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

	/**
	 * Set vendor store url
	 */
    public function set_vendor_store_url($items) {
        if (is_admin()) return $items;

        foreach($items as $key => $item) {
            if ($item->url != $this->store_url) continue;

            $items[$key]->url = dokan_get_store_url(get_current_user_id());
        }

        return $items;
    }

	/**
	 * Output the links
	 */
	public function nav_menu_links() {
        $endpoints = $this->get_dokan_nav_endpoints();
        if (empty($endpoints)) return;

		?>
		<div id="posttype-dokan-endpoints" class="posttypediv">
			<div id="tabs-panel-dokan-endpoints" class="tabs-panel tabs-panel-active">
				<ul id="dokan-endpoints-checklist" class="categorychecklist form-no-clear">
					<?php
					$i = -1;
					foreach ($endpoints as $key => $value) :
                        $title = $value['title'];
                        $url = $value['url'];

                        // set view store endpoint url to dokan store url
                        if ($key == 'view-store') {
                            $url = $this->store_url;
                        }

						?>
						<li>
							<label class="menu-item-title">
								<input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-object-id]" value="<?php echo esc_attr($i); ?>" /> <?php echo esc_html($title); ?>
							</label>
                            <input type="hidden" class="menu-item-xfn" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-xfn]" value="">
                            <input type="hidden" class="menu-item-attr-title" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-attr-title]" value="">
                            <input type="hidden" class="menu-item-target" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-target]" value="">
                            <input type="hidden" class="menu-item-parent-id" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-parent-id]" value="0">
                            <input type="hidden" class="menu-item-db-id" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-db-id]" value="0">
							<input type="hidden" class="menu-item-type" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-type]" value="custom">
							<input type="hidden" class="menu-item-title" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-title]" value="<?php echo esc_attr($title); ?>" />
							<input type="hidden" class="menu-item-url" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-url]" value="<?php echo esc_url($url); ?>" />
							<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo esc_attr($i); ?>][menu-item-classes]"/>
						</li>
						<?php
						$i--;
					endforeach;
					?>
				</ul>
			</div>
			<p class="button-controls">
				<span class="list-controls">
					<a href="<?php echo esc_url(admin_url('nav-menus.php?page-tab=all&selectall=1#posttype-dokan-endpoints')); ?>" class="select-all"><?php esc_html_e('Select all', 'sage'); ?></a>
				</span>
				<span class="add-to-menu">
					<button type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to menu', 'sage'); ?>" name="add-post-type-menu-item" id="submit-posttype-dokan-endpoints"><?php esc_html_e('Add to menu', 'sage'); ?></button>
					<span class="spinner"></span>
				</span>
			</p>
		</div>
		<?php
	}
}