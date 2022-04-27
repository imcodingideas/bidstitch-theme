<?php

namespace App;

use Shopify\Auth\FileSessionStorage;
use Shopify\Clients\Rest;
use Shopify\Context;
use WC_Product;


add_action('wp_ajax_shopify_export', 'App\\export_to_shopify');
add_action('wp_ajax_nopriv_shopify_export', 'App\\export_to_shopify');

function export_to_shopify() {
	$product_id = $_POST['product_id'];
    $post = get_post($product_id);

    // Ensure this product belongs to the current user
    if (!$post || $post->post_author != get_current_user_id()) {
        wp_die();
    }

	$product = wc_get_product($product_id);

    $product_data = [
        'id' => $product_id,
		'title' => $product->get_name(),
		'desc' => $product->get_description(),
		'tags' => get_product_tags($product_id),
		'images' => get_product_images($product_id),
		'vendor' => '',
		'type' => $product->get_type(),
		'category' => '',
	];

    $response = export_product((object)$product_data);

	wp_send_json(['Product' => $product_data, 'Response' => (array)$response]);
}

function get_product_tags($product_id) {
	$output = [];
	$terms = wp_get_post_terms( $product_id, 'product_tag' );

	if (count($terms) > 0) {
		foreach ($terms as $term){
			$output[] = $term->name;
		}
	}

	return $output;
}

function get_product_images($product_id) {
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
	$images = [$thumb[0]];
	$product = new WC_Product($product_id);
    $attachment_ids = $product->get_gallery_image_ids();

    foreach ($attachment_ids as $attachment_id) {
		$images[] = wp_get_attachment_url($attachment_id);
    }

	return $images;
}

function export_product($product) {
    // Get Shopify account info
    $user_key = 'user_' . get_current_user_id();
    $store_url = get_field('store_url', $user_key);
    $api_key = get_field('api_key', $user_key);
    $api_secret = get_field('api_secret', $user_key);
    $access_token = get_field('access_token', $user_key);

    // Attempt setup
    try {
        Context::initialize($api_key, $api_secret, ['read_products', 'write_products'], $store_url, new FileSessionStorage(__DIR__.'/tmp/php_sessions'));
	    $client = new Rest($store_url, $access_token);
    } catch (Exception $e) {
        return null;
    }

    // Send request
	$args = [
		'title' => $product->title,
		'body_html' => $product->desc,
		'vendor' => $product->vendor,
		'product_type' => $product->category,
		'tags' => $product->tags,
		'variants' => $product->variations,
		'options' => $product->attributes
	];

	$response = $client->post('products', ['product' => $args]);

    // If successful then update our product
    if ($response->getStatusCode() == 201) {
        update_post_meta($product->id, '_bidstitch_exported_to_shopify', '1');
    }

	return $response;
}
