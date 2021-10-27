<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanOffersView extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.offers.offers-view'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $offer_query = $this->get_offer_query();

        return [
            'pagination' => $this->pagination($offer_query),
            'offer_groups' => $this->get_offer_groups($offer_query),
        ];
    }

    public function get_offer_args($vendor_id, $product_id) {
        if (empty($vendor_id)) return false;

        $paged = get_query_var('paged');

        $post_statuses = [
            'publish', 'accepted-offer', 
            'countered-offer', 'buyercountered-offer', 
            'on-hold-offer', 'expired-offer', 
            'declined-offer', 'completed-offer'
        ];

        $query_args = [
            'post_type' => 'woocommerce_offer',
            'post_status' => $post_statuses,
            'per_page' => apply_filters('ofw_dokan_table_post_per_page', 20),
            'paged' => !empty($is_paged) ? $is_paged : 1,
        ];

        // check if should query by single product
        if (!empty($product_id)) {
            $query_args['meta_query'] = [
                [
                    'key' => 'offer_product_id',
                    'value' => $product_id,
                ]
            ];
        } else {
            $product_query = dokan()->product->all([
                'author' => $vendor_id,
                'fields' => 'ids'
            ]);

            if (empty($product_query->posts)) return false;

            $query_args['meta_query'] = [
                'relation' => 'AND',
                [
                    'key' => 'offer_product_id',
                    'value' => $product_query->posts,
                    'compare' => 'IN',
                ]
            ];
        }

        return apply_filters('ofw_dokan_vendor_offer_args', $query_args, $vendor_id);
    }

    public function get_offer_query() {
        $vendor_id = get_current_user_id();
        if (empty($vendor_id)) return false;

        $is_vendor = dokan_is_user_seller($vendor_id);
        if (!$is_vendor) return false;

        $product_id = isset($_GET['product_id']) && !empty($_GET['product_id']) ? $_GET['product_id'] : '';

        $query_args = $this->get_offer_args($vendor_id, $product_id);
        if (empty($query_args)) return false;

        $query_results = new \WP_Query($query_args);
    
        wp_reset_postdata();

        if (empty($query_results)) return false;

        return $query_results;
    }

    public function get_offer_actions($offer_id) {
        if (empty($offer_id)) return false;

        $offers_slug = 'woocommerce_offer';

        $actions = [
            (object) [
                'label' => __('Accept', 'sage'),
                'link' => dokan_get_navigation_url($offers_slug . '/accept/' . $offer_id),
            ],
            (object) [
                'label' => __('Decline', 'sage'),
                'link' => dokan_get_navigation_url($offers_slug . '/decline/' . $offer_id),
            ],
        ];

        return $actions;
    }

    public function user_can_manage_offer($status) {
        if (empty($status)) return false;

        $actionable_status_list = [
            'publish',
            'buyercountered-offer',
        ];

        return in_array($status, $actionable_status_list);
    }

    public function get_offer_status_label($status) {
        if (empty($status)) return false;

        $offer_status = apply_filters('ofw_dokan_status', [
            'publish' => __('Pending', 'sage'),
            'accepted-offer' => __('Accepted', 'sage'),
            'countered-offer' => __('Countered', 'sage'),
            'declined-offer' => __('Declined', 'sage'),
            'on-hold-offer' => __('On Hold', 'sage'),
            'buyercountered-offer' => __('Buyer Countered', 'sage'),
            'expired-offer' => __('Expired', 'sage'),
            'completed-offer' => __('Completed', 'sage'),
        ]);

        if (!isset($offer_status[$status])) return false;
        if (empty($offer_status[$status])) return false;

        return $offer_status[$status];
    }

    public function get_offer_status($offer_id) {
        if (empty($offer_id)) return false;

        $status_value = get_post_status($offer_id);
        if (empty($status_value)) return false;

        $status_label = $this->get_offer_status_label($status_value);
        if (empty($status_label)) return false;

        return (object) [
            'label' => $status_label,
            'value' => $status_value,
        ];
    }

    public function get_offer_groups($offer_query) {
        if (empty($offer_query)) return false;
        if (!isset($offer_query->posts)) return false;
        if (empty($offer_query->posts)) return false;

        $offer_list = $offer_query->posts;

        $offer_groups = [];

        foreach($offer_list as $offer) {
            if (!isset($offer->ID)) continue;
            if (empty($offer->ID)) continue;

            $offer_id =  $offer->ID;

            $product_id = get_post_meta($offer_id, 'orig_offer_product_id', true);

            $product = wc_get_product($product_id);
            if (empty($product)) continue;

            $product_name = $product->get_name();
            $product_thumbnail = $product->get_image('medium', ['class' => 'object-center object-cover rounded'], true);
            $product_link = $product->get_permalink();

            $offer_author = get_post_meta($offer_id, 'offer_name', true);
            $offer_price_per = get_post_meta($offer_id, 'offer_price_per', true);
            $offer_quantity = get_post_meta($offer_id, 'offer_quantity', true);
            $offer_amount = get_post_meta($offer_id, 'offer_amount', true);
            $offer_status = $this->get_offer_status($offer_id);
            $offer_date = get_the_date('F j, Y', $offer_id);
            $offer_time = get_the_date('g:i a', $offer_id);
            $offer_actions = $this->get_offer_actions($offer_id);

            $offer_item = (object) [
                'author' => $offer_author,
                'date' => $offer_date,
                'time' => $offer_time,
                'price_per' => !empty($offer_price_per) ? $offer_price_per : 0,
                'quantity' => $offer_quantity,
                'amount' => !empty($offer_amount) ? $offer_amount : 0,
                'status' => $offer_status,
                'actions' => $offer_actions,
                'id' => $offer_id,
                'user_can_manage' => $this->user_can_manage_offer($offer_status->value),
            ];

            if (isset($offer_groups[$product_id])) {
                $offer_groups[$product_id]->offers[] = $offer_item;

                continue;
            }

            $offer_groups[$product_id] = (object) [
                'product_name' => $product_name,
                'product_thumbnail' => $product_thumbnail,
                'product_link' => $product_link,
                'product_id' => $product_id,
                'offers' => [$offer_item],
            ];
        }

        return $offer_groups;
    }
    

    public function pagination($offer_query) {
        if (empty($offer_query)) return false;
        if (!isset($offer_query->max_num_pages)) return false;

        $current_page = max(1, get_query_var('paged'));

        $big = 999999999;

        $pagination_args = [
            'current' => $current_page,
            'total' => $offer_query->max_num_pages,
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'add_args' => false,
            'type' => 'array',
            'prev_text' => __('&larr; Previous', 'sage'),
            'next_text' => __('Next &rarr;', 'sage'),
            'format' => '?paged=%#%',
        ];

        $pagination_args = apply_filters('ofw_dokan_offers_pagination_args', $pagination_args, $current_page, $offer_query->max_num_pages, $offer_query);

        $links = paginate_links($pagination_args);

        return $links;
    }
}
