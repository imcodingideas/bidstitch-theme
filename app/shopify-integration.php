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
		'type' => $product->get_type(),
        'price' => number_format($product->get_price(), 2),
		'vendor' => '',
		'category' => '',
        'variations' => [],
        'attributes' => [],
	];

    $response = export_product((object)$product_data);

	wp_send_json(['Product' => $product_data, 'Response' => (array)$response]);
}

function get_product_tags($product_id) {
	$output = [];
	$terms = wp_get_post_terms($product_id, 'product_tag');

	if (count($terms) > 0) {
		foreach ($terms as $term){
			$output[] = $term->name;
		}
	}

	return $output;
}

function get_product_images($product_id) {
    // Populate images array
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
	$image_urls = [$thumb[0]];
	$product = new WC_Product($product_id);
    $attachment_ids = $product->get_gallery_image_ids();

    foreach ($attachment_ids as $attachment_id) {
		$image_urls[] = wp_get_attachment_url($attachment_id);
    }

    // Format for API
    $images = [];

    foreach ($image_urls as $image_url) {
        $images[] = ['src' => $image_url];
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
	$product_args = [
		'title' => $product->title,
		'body_html' => $product->desc,
		'vendor' => $product->vendor,
		'product_type' => $product->category,
		'tags' => $product->tags,
        'images' => $product->images,
		'variants' => $product->variations,
		'options' => $product->attributes
	];

	$create_response = $client->post('products', ['product' => $product_args]);

    // If successful then update our product
    if ($create_response->getStatusCode() == 201) {
        $body = $create_response->getDecodedBody();
        $variant = $body['product']['variants'][0];

        // Update default variant to set the price
        $variant_args = [
            'id' => $variant['id'],
            'price' => $product->price,
            'inventory_management' => 'shopify',
        ];

        $update_response = $client->put("variants/{$variant['id']}", ['variant' => $variant_args]);

        if ($update_response->getStatusCode() == 200) {
            // Set the inventory to 1
            $locations = $client->get('locations')->getDecodedBody();
            $location_id = $locations['locations'][0]['id'];
            $inventory_item_id = $variant['inventory_item_id'];

            $inventory_args = [
                'location_id' => $location_id,
                'inventory_item_id' => $inventory_item_id,
                'available' => 1,
            ];

            $client->post('inventory_levels/set', $inventory_args);
        }

        // Upate our product record
        update_post_meta($product->id, '_bidstitch_exported_to_shopify', '1');
    }

	return $create_response;
}
