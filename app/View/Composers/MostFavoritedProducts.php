<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class MostFavoritedProducts extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.most-favorited-products'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'args' => $this->args(),
        ];
    }

    public function args()
    {
        global $wpdb;
        // fetch 20 to discard not matching products in next query
        $result_product_id = $wpdb->get_col(
            "SELECT w.prod_id FROM `{$wpdb->prefix}yith_wcwl` w 
            INNER JOIN {$wpdb->prefix}posts p ON p.id = w.prod_id 
            WHERE p.post_status='publish' 
            GROUP BY w.prod_id 
            ORDER BY count(prod_id) DESC 
            LIMIT 20"
        );

        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            // 'ignore_sticky_posts'   => 1,
            'post__in' => $result_product_id,
            'posts_per_page' => 4,
            'orderby' => 'post__in',
            'meta_query' => [
                [
                    'key' => '_stock_status',
                    'value' => 'instock',
                ],
            ],
        ];

        $args['tax_query'] = [
            [
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => ['auction', 'product_pack'],
                'operator' => 'NOT IN',
            ],
        ];
        return $args;
    }
}
