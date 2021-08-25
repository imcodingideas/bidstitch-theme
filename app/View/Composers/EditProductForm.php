<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class EditProductForm extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'dokan.edit-product-form',
        'dokan.new-product-form',
    ];

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
            $post_title = $post->post_title;
            $post_content = $post->post_content;
            $post_excerpt = $post->post_excerpt;
            $post_status = $post->post_status;
            $product = wc_get_product($post_id);

            // current condition
            $term_condition = wp_get_post_terms($post_id, 'product_condition', [
                'fields' => 'ids',
            ]);
            $product_condition = $term_condition ? $term_condition[0] : '';

            // current category
            $term_category = wp_get_post_terms($post_id, 'product_cat', [
                'fields' => 'ids',
            ]);
            $product_cat = $term_category ? $term_category[0] : '';

            // current subcategory
            $product_cat_sub = null;
            foreach ($term_category as $term) {
                $term_object = get_term($term, 'product_cat');
                if ($term_object->parent != 0) {
                    $product_cat_sub = $term->term_id;
                }
            }

            // current size
            $term_condition = wp_get_post_terms($post_id, 'product_size', [
                'fields' => 'ids',
            ]);
            $product_size = $term_condition ? $term_condition[0] : '';

            // current color
            $term_color = wp_get_post_terms($post_id, 'product_color', [
                'fields' => 'ids',
            ]);
            $product_color = $term_color ? $term_color[0] : '';

            // other fields
            $tees_tip = get_post_meta($post_id, 'tees_tip', true);
            $tees_length = get_post_meta($post_id, 'tees_length', true);
            $tees_tag_type = get_post_meta($post_id, 'tees_tag_type', true);
            $tees_stitching = get_post_meta($post_id, 'tees_stitching', true);
            $_regular_price = get_post_meta($post_id, '_regular_price', true);

            // images
            $feat_image_id = null;
            $feat_image_url = null;
            if (has_post_thumbnail($post_id)) {
                $feat_image_id = get_post_thumbnail_id($post_id);
                $feat_image_url = wp_get_attachment_url($feat_image_id);
            }

            $gallery_items = $this->gallery_edit($post_id);

            // special
            $_stock = get_post_meta($post_id, '_stock', true);
            $_manage_stock = get_post_meta($post_id, '_manage_stock', true);
            $_backorders = get_post_meta($post_id, '_backorders', true);
            $_enable_reviews = get_post_meta($post_id, '_enable_reviews', true);
            $_stock_status = get_post_meta($post_id, '_stock_status', true);
            $_sku = get_post_meta($post_id, '_sku', true);
        } else {
            $post_id = null;
            $post = null;
            // when page is new product
            $post_title = dokan_posted_input('post_title');
            $post_content = dokan_posted_input('post_content');
            $product_condition = dokan_posted_input('product_condition');
            $product_cat = dokan_posted_input('product_cat');
            $product_cat_sub = dokan_posted_input('product_cat_sub');
            $product_size = dokan_posted_input('product_size');
            $product_color = dokan_posted_input('product_color');
            $tees_tip = dokan_posted_input('tees_tip ');
            $tees_length = dokan_posted_input('tees_length ');
            $tees_tag_type = dokan_posted_input('tees_tag_type ');
            $tees_stitching = dokan_posted_input('tees_stitching ');
            $_regular_price = dokan_posted_input('_regular_price ');
            // images
            $feat_image_id = dokan_posted_input('feat_image_id');
            $feat_image_url = null;
            if (!empty($feat_image_id)) {
                $feat_image_url = wp_get_attachment_url($feat_image_id);
            }

            $gallery_items = $this->gallery_new();

            // special
            $_stock = '';
            $_manage_stock = '';
            $_backorders = '';
            $_enable_reviews = '';
            $_stock_status = '';
            $_sku = '';
        }

        // condition terms
        $terms_condition = get_terms([
            'taxonomy' => 'product_condition',
            'hide_empty' => false,
        ]);

        // categories terms
        $category_terms = $this->category_terms();

        // subcategories terms
        $subcategory_terms = $this->subcategory_terms($product_cat);

        // size terms
        $terms_size = get_terms([
            'taxonomy' => 'product_size',
            'hide_empty' => false,
        ]);

        // color terms
        $terms_color = get_terms([
            'taxonomy' => 'product_color',
            'hide_empty' => false,
        ]);

        return compact(
            'post_title',
            'post_content',
            'terms_condition',
            'product_condition',
            'product_cat',
            'terms_condition',
            'category_terms',
            'subcategory_terms',
            'product_size',
            'product_color',
            'product_cat_sub',
            'terms_size',
            'terms_color',
            'tees_tip',
            'tees_length',
            'tees_tag_type',
            'tees_stitching',
            '_regular_price',
            'feat_image_id',
            'feat_image_url',
            'gallery_items',
            '_stock',
            '_manage_stock',
            '_backorders',
            '_enable_reviews',
            '_stock_status',
            '_sku',
            'post',
            'post_id'
        );
    }

    function category_terms()
    {
        return get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'parent' => 0,
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_key' => 'meta_value_num',
            'meta_query' => [
                [
                    'key' => 'meta_value_num',
                    'value' => [''],
                    'compare' => 'NOT IN',
                ],
            ],
        ]);
    }
    function subcategory_terms($category_id)
    {
        $terms = [];
        if (!$category_id) {
            return $terms;
        }
        // Get an array of the subcategories IDs (children IDs)
        $children_ids = get_term_children($category_id, 'product_cat');

        if (!empty($children_ids)) {
            return get_terms([
                'taxonomy' => 'product_cat',
                'include' => $children_ids,
                'hide_empty' => false,
                'meta_key' => 'order',
                // 'meta_compare'  => 'NUMERIC',
                'orderby' => 'meta_value_num',
                'order' => 'asc',
            ]);
        }
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
