<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\asset;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('sage/app.js', asset('scripts/app.js')->uri(), ['jquery'], null, true);

    // localize script
    $script_args = [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'isLoggedIn' => is_user_logged_in(),
        'themeUrl' => get_template_directory_uri(),
        'siteUrl' => get_option('home'),
        'restNonce' => wp_create_nonce('wp_rest'),
        'vendorUrl' => '',
        'vendorListingUrl' => '',
        'shopUrl' => '',
    ];

    if (function_exists('dokan_get_option')) {
        // dokan store URL
        $store_slug = dokan_get_option('custom_store_url', 'dokan_general', 'store');
        if (!empty($store_slug)) {
            $store_url = home_url() . '/' . $store_slug;
            $script_args['vendorUrl'] = $store_url;
        }

        // dokan store listing url
        $store_listing_page_id = dokan_get_option('store_listing', 'dokan_pages');
        if (!empty($store_listing_page_id)) {
            $script_args['vendorListingUrl'] = get_permalink($store_listing_page_id);
        }
    }

    // woocommerce shop URL
    if (function_exists('wc_get_page_id')) {
        $page_id = wc_get_page_id('shop');
        $script_args['shopUrl'] = get_permalink($page_id);
    }

    wp_localize_script('sage/app.js', 'bidstitchSettings', $script_args);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_style('sage/app.css', asset('styles/app.css')->uri(), false, null);
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script('sage/editor.js', asset('scripts/editor.js')->uri(), [], null, true);

    wp_enqueue_style('sage/editor.css', asset('styles/editor.css')->uri(), false, null);
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls'
    ]);

    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'header_navigation' => __('Header Navigation', 'sage'),
        'footer_navigation' => __('Footer Navigation', 'sage'),
        'myaccount_navigation' => __('My Account Navigation', 'sage')
    ]);

    /**
     * Register the editor color palette.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
     */
    add_theme_support('editor-color-palette', []);

    /**
     * Register the editor color gradient presets.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
     */
    add_theme_support('editor-gradient-presets', []);

    /**
     * Register the editor font sizes.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
     */
    add_theme_support('editor-font-sizes', []);

    /**
     * Register relative length units in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#support-custom-units
     */
    add_theme_support('custom-units');

    /**
     * Enable support for custom line heights in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-custom-line-heights
     */
    add_theme_support('custom-line-height');

    /**
     * Enable support for custom block spacing control in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#spacing-control
     */
    add_theme_support('custom-spacing');

    /**
     * Disable custom colors in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
     */
    add_theme_support('disable-custom-colors');

    /**
     * Disable custom color gradients in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
     */
    add_theme_support('disable-custom-gradients');

    /**
     * Disable custom font sizes in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
     */
    add_theme_support('disable-custom-font-sizes');

    /**
     * Disable the default block patterns.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable wide alignment support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
     */
    add_theme_support('align-wide');

    /**
     * Enable responsive embed support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style'
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name' => __('Header', 'sage'),
        'id' => 'sidebar-header'
    ] + $config);

    register_sidebar([
        'name' => __('Shop sidebar', 'sage'),
        'id' => 'shop-sidebar'
    ] + $config);

    $configFooter = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="font-semibold text-gray-300">',
        'after_title' => '</h3>'
    ];
    register_sidebar([
        'name' => __('Footer 1', 'sage'),
        'id' => 'sidebar-footer-1'
    ] + $configFooter);
    register_sidebar([
        'name' => __('Footer 2', 'sage'),
        'id' => 'sidebar-footer-2'
    ] + $configFooter);
    register_sidebar([
        'name' => __('Footer 3', 'sage'),
        'id' => 'sidebar-footer-3'
    ] + $configFooter);
});
