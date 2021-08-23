<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ShopByCategory extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.shop-by-category'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'categories' => $this->categories(),
        ];
    }

    public function categories()
    {
        $categories = [];
        $category_list = get_field('category_list');
        if ($category_list) {
            $category_array = implode(',', $category_list);
            $product_categories = get_terms([
                'taxonomy' => 'product_cat',
                'include' => $category_array,
                'hide_empty' => false,
                'orderby' => 'meta_value_num',
                'meta_key' => 'meta_value_num',
                'order' => 'ASC',
            ]);
        }
        if (!empty($product_categories)) {
            $count_tee = 0;
            foreach ($product_categories as $key => $category) {
                $count_tee = $count_tee + 1;
                $string_category =
                    $count_tee != count($product_categories)
                        ? get_field('string_category')
                        : '';
                $categories[] = [
                    'link' => get_term_link($category),
                    'name' => $category->name,
                    'image' => wp_get_attachment_url(get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true )),
                    'string_category' => $string_category,
                ];
            }
        }

        return $categories;
    }
}
