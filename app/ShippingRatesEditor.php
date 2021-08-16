<?php
namespace App;

class ShippingRatesEditor
{
    private $domElement = "<div id='shipping-rates-editor'></div>";
    function init()
    {
        $this->addFilters();
        $this->addShortcodes();
        $this->enqueueAssets();
        // for development
        if (defined('WP_DEBUG') && true === WP_DEBUG) {
            $this->disableCorsForTesting();
        }
    }
    function disableCorsForTesting()
    {
        add_action('init', function () {
            header('Access-Control-Allow-Headers: *');
            header('Access-Control-Allow-Origin: *');
        });
    }

    function addFilters()
    {
        // replace dom element
        add_filter('dokan_shipping_zones_editor', function () {
            return $this->domElement;
        });
        // remove script
        add_filter('dokan_shipping_zones_editor_scripts', function ($scripts) {
            unset($scripts['dokan-pro-vue-frontend-shipping']);
            return $scripts;
        });
    }
    function addShortcodes()
    {
        add_shortcode('bidstitchtools_shipping_rates_editor', function () {
            return $this->domElement;
        });
    }
    function enqueueAssets()
    {
        // 100 is sage/app.js
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts'], 101);
    }
    function enqueueScripts()
    {
        // localize script
        wp_localize_script('sage/app.js', 'bidstitchtools_settings', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dokan_reviews'),
        ]);
    }
}
