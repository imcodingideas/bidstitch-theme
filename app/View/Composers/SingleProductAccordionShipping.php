<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SingleProductAccordionShipping extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.single-product-accordion-shipping'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'zones' => $this->zones(),
        ];
    }
    public function zones()
    {
        $data_store = \WC_Data_Store::load('shipping-zone');
        $raw_zones = $data_store->get_zones();
        $zones = [];
        $author_product_id = get_the_author_meta('ID');
        $seller_id = $author_product_id;

        foreach ($raw_zones as $raw_zone) {
            $zone = new \WC_Shipping_Zone($raw_zone);
            $enabled_methods = $zone->get_shipping_methods(true);
            $methods_id = wp_list_pluck($enabled_methods, 'id');

            if (!$zone) {
                continue;
            }

            // Prepare locations.
            $locations = [];

            foreach ($zone->get_zone_locations() as $location) {
                if ('postcode' !== $location->type) {
                    $locations[] = $location->type . ':' . $location->code;
                }
            }

            if (
                in_array('dokan_vendor_shipping', $methods_id) &&
                !empty($locations)
            ) {
                $zones[$zone->get_id()] = $zone->get_data();
                $zones[$zone->get_id()]['zone_id'] = $zone->get_id();
                $zones[$zone->get_id()][
                    'formatted_zone_location'
                ] = $zone->get_formatted_location();
                $zones[$zone->get_id()][
                    'shipping_methods'
                ] = $this->get_shipping_methods1($zone->get_id(), $seller_id);
            }
        }

        // Everywhere zone if has method called vendor shipping
        $overall_zone = new \WC_Shipping_Zone(0);
        $enabled_methods = $overall_zone->get_shipping_methods(true);
        $methods_id = wp_list_pluck($enabled_methods, 'id');

        if (in_array('dokan_vendor_shipping', $methods_id)) {
            $zones[$overall_zone->get_id()] = $overall_zone->get_data();
            $zones[$overall_zone->get_id()][
                'zone_id'
            ] = $overall_zone->get_id();
            $zones[$overall_zone->get_id()][
                'formatted_zone_location'
            ] = $overall_zone->get_formatted_location();
            $zones[$overall_zone->get_id()][
                'shipping_methods'
            ] = $this->get_shipping_methods1(
                $overall_zone->get_id(),
                $seller_id
            );
        }
        return $zones;
    }
    public function get_shipping_methods1($zone_id, $seller_id)
    {
        $results = $this->dokan_zone_methods($zone_id, $seller_id);
        $method = [];

        foreach ($results as $key => $result) {
            $default_settings = [
                'title' => $this->get_method_label1($result->method_id),
                'description' => __(
                    'Lets you charge a rate for shipping',
                    'dokan'
                ),
                'cost' => '0',
                'tax_status' => 'none',
            ];

            $method_id = $result->method_id . ':' . $result->instance_id;
            $settings = !empty($result->settings)
                ? maybe_unserialize($result->settings)
                : [];
            $settings = wp_parse_args($settings, $default_settings);

            $method[$method_id]['instance_id'] = $result->instance_id;
            $method[$method_id]['id'] = $result->method_id;
            $method[$method_id]['enabled'] = $result->is_enabled ? 'yes' : 'no';
            $method[$method_id]['title'] = $settings['title'];
            $method[$method_id]['settings'] = array_map(
                'stripslashes_deep',
                maybe_unserialize($settings)
            );
        }

        return $method;
    }
    public function dokan_zone_methods($zone_id, $seller_id)
    {
        global $wpdb;
        $dokan_zone_methods = false;
        if (
            false ===
            ($dokan_zone_methods = get_transient(
                "dokan_zone_methods_{$zone_id}_{$seller_id}"
            ))
        ) {
            $sql = "SELECT method_id, instance_id, settings, is_enabled FROM {$wpdb->prefix}dokan_shipping_zone_methods WHERE `zone_id`={$zone_id} AND `seller_id`={$seller_id}";
            $dokan_zone_methods = $wpdb->get_results($sql);

            /* MINUTE_IN_SECONDS  = 60 (seconds) */
            /* HOUR_IN_SECONDS    = 60 * MINUTE_IN_SECONDS */
            /* DAY_IN_SECONDS     = 24 * HOUR_IN_SECONDS */
            /* WEEK_IN_SECONDS    = 7 * DAY_IN_SECONDS */
            /* MONTH_IN_SECONDS   = 30 * DAY_IN_SECONDS */
            /* YEAR_IN_SECONDS    = 365 * DAY_IN_SECONDS */
            set_transient(
                "dokan_zone_methods_{$zone_id}_{$seller_id}",
                $dokan_zone_methods,
                MINUTE_IN_SECONDS
            );
        }
        return $dokan_zone_methods;
    }
    public function get_method_label1($method_id)
    {
        if ('flat_rate' == $method_id) {
            return __('Flat Rate', 'dokan');
        } elseif ('local_pickup' == $method_id) {
            return __('Local Pickup', 'dokan');
        } elseif ('free_shipping' == $method_id) {
            return __('Free Shipping', 'dokan');
        } else {
            return __('Custom Shipping', 'dokan');
        }
    }
}
