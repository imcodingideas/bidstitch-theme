<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Acorn application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

\Roots\bootloader();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect([
    'helpers',
    'setup',
    'filters',
    'admin',
    'woocommerce',
    'woocommerce-performance-improvements',
    'woocommerce-products-filter',
    'woocommerce-simple-auctions',
    'yith-woocommerce-wishlist',
    'acf',
    'dokan',
    'dokan-custom-functions',
    'dokan-nav-menu',
    'onboarding-setup-wizard',
    'clean-dashboard',
    'offers-for-woocommerce',
    'offers-for-woocommerce-form',
    'offers-for-woocommerce-form-ajax',
    'offers-for-woocommerce-dokan',
    'offers-for-woocommerce-notifications',
    'offers-for-woocommerce-notifications-ajax',
    'offers-for-woocommerce-notifications-page',
    'shipping-rates-editor',
    'new-product-form',
    'elasticpress',
    'user-chat',
    'comments',
    'media-uploader'
])->each(function ($file) {
    if (!locate_template($file = "app/{$file}.php", true, true)) {
        wp_die(
            /* translators: %s is replaced with the relative file path */
            sprintf(
                __('Error locating <code>%s</code> for inclusion.', 'sage'),
                $file
            )
        );
    }
});

/*
|--------------------------------------------------------------------------
| Enable Sage Theme Support
|--------------------------------------------------------------------------
|
| Once our theme files are registered and available for use, we are almost
| ready to boot our application. But first, we need to signal to Acorn
| that we will need to initialize the necessary service providers built in
| for Sage when booting.
|
*/

add_theme_support('sage');
