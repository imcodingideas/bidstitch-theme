<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class MyAccountBids extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.bids'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with() {
        return [
            'bids' => $this->get_bids(),
            'pagination' => $this->pagination(),
        ];
    }

    public function get_bid_count() {
        global $wpdb;

        $data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'simple_auction_log as a
            join '.$wpdb->prefix.'posts as b
            on a.auction_id = b.ID
            WHERE a.userid ='.get_current_user_id().' ORDER BY a.date desc, a.bid asc, a.id desc');
        
        if (!$data || empty($data)) return false;

        return count($data);
    }

    public function get_pagination_args() {
        $posts_per_page = 20;
        $cur_page_num = max(1, @$_GET['pagenum']);
        $offset = ($cur_page_num - 1) * $posts_per_page;

        return (object) [
            'posts_per_page' => $posts_per_page,
            'cur_page_num' => $cur_page_num,
            'offset' => $offset
        ];
    }

    public function get_bids() {
        global $wpdb;

        $pagination_args = $this->get_pagination_args();

        $bid_list = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'simple_auction_log  as a
            join '.$wpdb->prefix.'posts  as b
            on a.auction_id = b.ID
            WHERE a.userid ='.get_current_user_id().' ORDER BY  a.date desc, a.bid asc, a.id desc LIMIT '.$pagination_args->offset.', '.$pagination_args->posts_per_page.'');

        $datetimeformat = get_option('date_format') . ' ' . get_option('time_format');
        
        $payload = [];

        foreach($bid_list as $bid_item) {
            $product = wc_get_product($bid_item->auction_id);
            if (!$product || empty($product)) continue;

            $product_link = $product->get_permalink($product->ID);
            $product_name = $product->get_title();
            $date = mysql2date($datetimeformat, $bid_item->date);
            $amount = $bid_item->bid;

            $payload[] = (object) [
                'date' => $date,
                'amount' => $amount,
                'product_name' => $product_name,
                'product_link' => $product_link,
            ];
        }

        if (empty($payload)) return false;

        return $payload;
    }

    public function pagination() {
        $total_count = $this->get_bid_count();
        if (!$total_count) return false;

        $pagination_args = $this->get_pagination_args();

        $args = [
            'current' => $pagination_args->cur_page_num,
            'total' => ceil($total_count / $pagination_args->posts_per_page),
            'base' => add_query_arg('pagenum', '%#%'),
            'add_args' => false,
            'type' => 'array',
            'end_size'  => 1,
            'mid_size'  => 1,
            'prev_text' => __('&larr; Previous', 'sage'),
            'next_text' => __('Next &rarr;', 'sage'),
        ];


        $links = paginate_links($args);

        return $links;
    }
}
