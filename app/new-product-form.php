<?php

// helper functions for resources/views/dokan/new-product-form.blade.php

function get_a_child_category(){
	$category_slug   = $_POST['category_slug'];

	$terms_html = array();
    $taxonomy = 'product_cat';
    // Get the product category (parent) WP_Term object
    $parent = get_term_by( 'slug', $category_slug, $taxonomy );
    // Get an array of the subcategories IDs (children IDs)
    $children_ids = get_term_children( $parent->term_id, $taxonomy );

    $order = 'asc';
    if($parent->term_id == 93 || $parent->term_id == 94){
    	$order = 'desc';
    }
    if(!empty( $children_ids)){
	    // Loop through each children IDs
         $product_categories = get_terms(array(
          'taxonomy' => 'product_cat',
          'include' => $children_ids,
          'hide_empty'  => false,
          'meta_key'      => 'order',
           // 'meta_compare'  => 'NUMERIC',
           'orderby'       => 'meta_value_num',
          'order'         => $order,
        ));
	    foreach($product_categories as $key => $term){
	        // $term = get_term( $children_id, $taxonomy ); // WP_Term object
	        $terms_html[$key]['id'] = $term->term_id;
	        $terms_html[$key]['slug'] = $term->slug;
	        $terms_html[$key]['name'] = $term->name;
	        $terms_html[$key]['order'] = get_field('order', $term->taxonomy . '_' . $term->term_id);
	        
	    }
    }else{
    	$terms_html = [];

    }

	wp_send_json($terms_html);

	die();

}

add_action("wp_ajax_get_a_child_category", "get_a_child_category");
add_action("wp_ajax_nopriv_get_a_child_category", "get_a_child_category");


// get a child category by parent category slug
function get_tag_size_by_category(){
	$category_slug   = $_POST['category_slug'];

	$terms_html = array();
    $taxonomy = 'product_size';

    $parent = get_term_by( 'slug', $category_slug, $taxonomy );
    $children_ids = get_term_children( $parent->term_id, $taxonomy );

    // Loop through each children IDs
    foreach($children_ids as $children_id){
        $term = get_term( $children_id, $taxonomy ); // WP_Term object
 
        $terms_html[$children_id]['id'] = $children_id;
        $terms_html[$children_id]['slug'] = $term->slug;
        $terms_html[$children_id]['name'] = $term->name;

    }

	wp_send_json($terms_html);

	die();

}

add_action("wp_ajax_get_tag_size_by_category", "get_tag_size_by_category");
add_action("wp_ajax_nopriv_get_tag_size_by_category", "get_tag_size_by_category");
