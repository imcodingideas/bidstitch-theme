<?php

/*
 * helper functions for the form
 * check: resources/views/dokan/new-product-form.blade.php
 *
 */

// ajax endpoint: subcategories

function get_a_child_category()
{
    $category_slug = $_POST['category_slug'];

    $terms_html = [];
    $taxonomy = 'product_cat';
    // Get the product category (parent) WP_Term object
    $parent = get_term_by('slug', $category_slug, $taxonomy);
    // Get an array of the subcategories IDs (children IDs)
    $children_ids = get_term_children($parent->term_id, $taxonomy);

    $order = 'asc';
    if ($parent->term_id == 93 || $parent->term_id == 94) {
        $order = 'desc';
    }
    if (!empty($children_ids)) {
        // Loop through each children IDs
        $product_categories = get_terms([
            'taxonomy' => 'product_cat',
            'include' => $children_ids,
            'hide_empty' => false,
            'meta_key' => 'order',
            // 'meta_compare'  => 'NUMERIC',
            'orderby' => 'meta_value_num',
            'order' => $order,
        ]);
        foreach ($product_categories as $key => $term) {
            // $term = get_term( $children_id, $taxonomy ); // WP_Term object
            $terms_html[$key]['id'] = $term->term_id;
            $terms_html[$key]['slug'] = $term->slug;
            $terms_html[$key]['name'] = $term->name;
            $terms_html[$key]['order'] = get_field(
                'order',
                $term->taxonomy . '_' . $term->term_id
            );
        }
    } else {
        $terms_html = [];
    }

    wp_send_json($terms_html);

    die();
}

// ajax endpoint: sizes
add_action('wp_ajax_get_a_child_category', 'get_a_child_category');
add_action('wp_ajax_nopriv_get_a_child_category', 'get_a_child_category');

// get a child category by parent category slug
function get_tag_size_by_category()
{
    $category_slug = $_POST['category_slug'];

    $terms_html = [];
    $taxonomy = 'product_size';

    $parent = get_term_by('slug', $category_slug, $taxonomy);
    $children_ids = get_term_children($parent->term_id, $taxonomy);

    // Loop through each children IDs
    foreach ($children_ids as $children_id) {
        $term = get_term($children_id, $taxonomy); // WP_Term object

        $terms_html[$children_id]['id'] = $children_id;
        $terms_html[$children_id]['slug'] = $term->slug;
        $terms_html[$children_id]['name'] = $term->name;
    }

    wp_send_json($terms_html);

    die();
}

add_action('wp_ajax_get_tag_size_by_category', 'get_tag_size_by_category');
add_action(
    'wp_ajax_nopriv_get_tag_size_by_category',
    'get_tag_size_by_category'
);

/* add extra fields when form saved */
add_action('dokan_add_new_auction_product', 'saveproductdata', 10, 2);
add_action('dokan_new_product_added', 'saveproductdata', 10, 2);
add_action('dokan_product_updated', 'saveproductdata', 10, 2);
function saveproductdata($product_id, $postdata)
{
    if (!dokan_is_user_seller(get_current_user_id())) {
        return;
    }
    if (!empty($postdata['tees_tip'])) {
        update_post_meta($product_id, 'tees_tip', $postdata['tees_tip']);
    }
    if (!empty($postdata['tees_length'])) {
        update_post_meta($product_id, 'tees_length', $postdata['tees_length']);
    }
    if (!empty($postdata['tees_tag_type'])) {
        update_post_meta(
            $product_id,
            'tees_tag_type',
            $postdata['tees_tag_type']
        );
    }
    if (!empty($postdata['tees_stitching'])) {
        update_post_meta(
            $product_id,
            'tees_stitching',
            $postdata['tees_stitching']
        );
    }
    if (!empty($postdata['product_size'])) {
        wp_set_post_terms(
            $product_id,
            $postdata['product_size'],
            'product_size'
        );
    }

    if (!empty($postdata['product_color'])) {
        wp_set_post_terms(
            $product_id,
            $postdata['product_color'],
            'product_color'
        );
    }
    if (!empty($postdata['product_condition'])) {
        wp_set_post_terms(
            $product_id,
            $postdata['product_condition'],
            'product_condition'
        );
    }

    // category and subcategory
    if (!empty($postdata['product_cat']) && !empty($postdata['product_cat_sub'])) {
        $categories = [
                $postdata['product_cat'],
                $postdata['product_cat_sub']
            ];

        wp_set_post_terms(
            $product_id,
            $categories,
            'product_cat'
        );
    }

    // Allow admins to save as merch
    if (get_current_user_id() == 1 && isset($postdata['add_to_merch']) && $postdata['add_to_merch'] === 'yes') {
        wp_set_object_terms($product_id, 'merch', 'product_cat', true);
    } else {
        wp_remove_object_terms($product_id, 'merch', 'product_cat');
    }
}

// Set default stock for new buy it now listings
add_action('dokan_new_product_added', 'save_stock_data', 10, 2);
add_action('dokan_add_new_auction_product', 'save_stock_data', 10, 2);
function save_stock_data($product_id, $postdata) {
    if (
        !isset($postdata['_manage_stock'])
        || isset($postdata['_manage_stock']) && empty($postdata['_manage_stock'])
    ) {
        // enable stock management
        update_post_meta(
            $product_id,
            '_manage_stock',
            'yes'
        );
    }

    if (
        !isset($postdata['_stock'])
        || isset($postdata['_stock']) && empty($postdata['_stock'])
    ) {
        // set stock to quantity to 1
        update_post_meta(
            $product_id,
            '_stock',
            '1'
        );
    }

    if (
        !isset($postdata['_stock_status'])
        || isset($postdata['_stock_status']) && empty($postdata['_stock_status'])
    ) {
        // set stock to status to instock
        update_post_meta(
            $product_id,
            '_stock_status',
            'instock'
        );
    }
}

// set _auction_dates_from field
add_action('dokan_new_product_added', 'save_auction_dates_from_field', 10, 2);
function save_auction_dates_from_field($product_id, $postdata)
{
    //set _auction_dates_from field with Current Time
    update_post_meta($product_id, '_auction_dates_from', date_i18n('Y-m-d H:i'));
}


