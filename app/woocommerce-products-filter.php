<?php
// override actions layout
function woof_show_btn($autosubmit = 1, $ajax_redraw = 0) {
    $view_args = [
        'autosubmit' => $autosubmit,
        'ajax_redraw' => $ajax_redraw
    ];
    
    echo \Roots\view('woof.actions', $view_args)->render();
}

// add filter button for mobile filters toggle
add_filter('woof_print_content_before_redraw_zone', function() {
    echo \Roots\view('woof.modal-actions')->render();
});

// add filter to render views for certain meta fields
add_filter('bidstitch_products_filter_meta_key', function($meta_key = '') {
    $target_keys = [
        'buying_formats',
    ];

    return in_array($meta_key, $target_keys);
});

// add custom query variables
add_action('woocommerce_product_query', function ($q, $query) {
    if (is_admin()) return $query;

    // default queries
    $tax_query = $q->get('tax_query');

    // target queries
    $buying_formats = isset($_GET['buying_formats']) ? $_GET['buying_formats'] : false;
    
    if ($buying_formats) {
        // auction query
        if ($buying_formats === '1') {
            $tax_query[] = [
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction',
                'operator' => 'IN' 
            ];
        }

        // buy it now query
        if ($buying_formats === '2') {
            $tax_query[] = [
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction',
                'operator' => 'NOT IN' 
            ];
        }
    }

    $q->set('tax_query', $tax_query);
}, 21, 2);

// filter out parent terms from select taxonomies label field
add_filter('woof_sort_terms_before_out', function($terms, $field_type) {
    if ($field_type !== 'label') return $terms;

    $target_types = [
        'product_size',
    ];

    $payload = [];

    foreach($terms as $term) {
        // check if is target term
        if (!in_array($term['taxonomy'], $target_types)) {
            return $terms;
        }

        // check if is child term
        if ($term['parent'] != 0) {
            $payload[] = $term;
            continue 1;
        } else {
            foreach($term['childs'] as $child_term) {
                $payload[] = $child_term;
            }
        }
    }

	return $payload;
}, 21, 2);