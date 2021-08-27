<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanProductsListing extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.products.products-listing'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $product_query = $this->product_query();

        return [
            'products' => $product_query,
            'pagination' => $this->pagination($product_query),
            'is_auction' => $this->is_auction(),
            'add_url' => $this->add_url(),
        ];
    }

    public function is_auction() {
        return isset($this->data['is_auction']) ? $this->data['is_auction'] : false;
    }

    public function add_url() {
        $is_auction = $this->is_auction();

        return dokan_get_navigation_url($is_auction ? 'new-auction-product' : 'new-product');
    }

    function get_page_num_param() {
        return isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
    }

    function post_statuses() {
        return apply_filters('dokan_product_listing_post_statuses', ['publish', 'draft', 'pending', 'future']);
    }

    function excluded_types() {
        return apply_filters('dokan_product_listing_exclude_type', array());
    }

    function product_query() {
        $is_auction = $this->is_auction();
        $user_id = get_current_user_id();

        $pagenum = $this->get_page_num_param();
        $post_statuses = $this->post_statuses();
        $get_data = wp_unslash($_GET);

        $args = [
            'posts_per_page' => 5,
            'paged' => $pagenum,
            'author' => $user_id,
            'post_status' => $post_statuses,
            'tax_query' => [],
        ];

        if ($is_auction) {
            $args['auction_archive'] = true;
            $args['show_past_auctions'] = true;

            $args['tax_query'][] = [
                'taxonomy' => 'product_type', 
                'field' => 'slug',
                'terms' => 'auction'
            ];
        } else {
            $args['tax_query'][] = [
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => $this->excluded_types(),
                'operator' => 'NOT IN',
            ];
        }

        if (isset($get_data['product_search_name']) && !empty( $get_data['product_search_name'])) {
            $args['s'] = $get_data['product_search_name'];
        }

        $query_args = apply_filters('dokan_pre_product_listing_args', $args, $get_data);
        $product_query = dokan()->product->all(apply_filters('dokan_product_listing_arg', $query_args));

        return $product_query;
    }

    public function pagination($product_query) {
        $is_auction = $this->is_auction();
        $pagenum = $this->get_page_num_param();

        $base_url = dokan_get_navigation_url($is_auction ? 'auction' : 'products');

        $links = [];

        if ($product_query->max_num_pages > 1) {
            $links = paginate_links([
                'current' => $pagenum,
                'total' => $product_query->max_num_pages,
                'base' => $base_url. '%_%',
                'format' => '?pagenum=%#%',
                'add_args' => false,
                'type' => 'array',
                'prev_text' => _e('Prev', 'sage'),
                'next_text' => _e('Next', 'sage')
            ]);
        }

        return $links;
    }
}
