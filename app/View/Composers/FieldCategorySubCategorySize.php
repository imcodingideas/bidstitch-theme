<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FieldCategorySubCategorySize extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.product-field-category-subcategory-size'];

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
            $term_size = wp_get_post_terms($post_id, 'product_size', [
                'fields' => 'ids',
            ]);
            $product_size = $term_size ? $term_size[0] : '';
        } else {
            $post_id = null;
            $post = null;
            $product_cat = dokan_posted_input('product_cat');
            $product_cat_sub = dokan_posted_input('product_cat_sub');
            $product_size = '';
        }

        // categories terms
        $category_terms = $this->category_terms();

        // subcategories terms
        $subcategory_terms = $this->subcategory_terms($product_cat);

        // size terms
        $size_terms = get_terms([
            'taxonomy' => 'product_size',
            'hide_empty' => false,
        ]);

        return compact(
            'product_cat',
            'product_cat_sub',
            'product_size',

            'category_terms',
            'subcategory_terms',
            'size_terms'
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
}
