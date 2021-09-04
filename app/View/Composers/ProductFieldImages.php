<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ProductFieldImages extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [ 'dokan.product-field-images' ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        global $post;
        if (isset($post->ID) && $post->ID && 'product' == $post->post_type) {
            $post_id = $post->ID;

            // images
            $feat_image_id = null;
            $feat_image_url = null;
            if (has_post_thumbnail($post_id)) {
                $feat_image_id = get_post_thumbnail_id($post_id);
                $feat_image_url = wp_get_attachment_url($feat_image_id);
            }

            $gallery_items = $this->gallery_edit($post_id);
        } else {
            $post_id = null;
            $post = null;

            // images
            $feat_image_id = dokan_posted_input('feat_image_id');
            $feat_image_url = null;
            if (!empty($feat_image_id)) {
                $feat_image_url = wp_get_attachment_url($feat_image_id);
            }

            $gallery_items = $this->gallery_new();
        }

        return compact('feat_image_id', 'feat_image_url', 'gallery_items');
    }

    function gallery_new()
    {
        $items = [];
        if (isset($post_data['product_image_gallery'])) {
            $product_images = $post_data['product_image_gallery'];
            $gallery = explode(',', $product_images);

            if ($gallery) {
                foreach ($gallery as $image_id) {
                    if (empty($image_id)) {
                        continue;
                    }

                    $attachment_image = wp_get_attachment_image_src(
                        $image_id,
                        'thumbnail'
                    );
                    $items[] = [
                        'id' => $image_id,
                        'url' => $attachment_image[0],
                    ];
                }
            }
        }
        return $items;
    }
    function gallery_edit($post_id)
    {
        $items = [];

        $product_images = get_post_meta(
            $post_id,
            '_product_image_gallery',
            true
        );
        $gallery = explode(',', $product_images);

        if ($gallery) {
            foreach ($gallery as $image_id) {
                if (empty($image_id)) {
                    continue;
                }
                $attachment_image = wp_get_attachment_image_src(
                    $image_id,
                    'thumbnail'
                );
                $items[] = [
                    'id' => $image_id,
                    'url' => $attachment_image[0],
                ];
            }
        }
    }
}
