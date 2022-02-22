<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanStore extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.store'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        // original:
        $store_user = dokan()->vendor->get(get_query_var('author'));
        $store_info = $store_user->get_shop_info();
        $map_location = $store_user->get_location();
        $layout = get_theme_mod('store_layout', 'left');

        // more:
        $products_by_store_user = $store_user->get_products();
        $post_counts = dokan_count_posts('product', get_query_var('author'));
        $count_product = $post_counts->publish;
        $store_total_sales = $this->get_sold_items_count($store_user->get_id());

        $catalog_orderby_options = apply_filters(
            'woocommerce_catalog_orderby',
            [
                'menu_order' => __('Default sorting', 'woocommerce'),
                'popularity' => __('Sort by popularity', 'woocommerce'),
                'rating' => __('Sort by average rating', 'woocommerce'),
                'date' => __('Sort by latest', 'woocommerce'),
                'price' => __('Sort by price: low to high', 'woocommerce'),
                'price-desc' => __('Sort by price: high to low', 'woocommerce'),
            ]
        );

        $default_orderby = wc_get_loop_prop('is_search')
            ? 'relevance'
            : apply_filters(
                'woocommerce_default_catalog_orderby',
                get_option('woocommerce_default_catalog_orderby', '')
            );

        $orderby = isset($_GET['orderby'])
            ? wc_clean(wp_unslash($_GET['orderby']))
            : $default_orderby;

        if (!wc_review_ratings_enabled()) {
            unset($catalog_orderby_options['rating']);
        }
        if (!array_key_exists($orderby, $catalog_orderby_options)) {
            $orderby = current(array_keys($catalog_orderby_options));
        }

        return compact(
            'store_user',
            'store_info',
            'map_location',
            'layout',
            'products_by_store_user',
            'post_counts',
            'count_product',
            'orders_count',
            'store_total_sales',
            'catalog_orderby_options',
            'default_orderby',
            'orderby'
        );
    }

    protected function get_sold_items_count($vendor_id)
    {
        $sold_products = wc_get_products([
            'author' => $vendor_id,
            'stock_status' => 'outofstock',
            // don't pull any actual data, just count
            'paginate' => true,
            'limit' => 0,
        ]);

        return $sold_products->total;
    }
}
