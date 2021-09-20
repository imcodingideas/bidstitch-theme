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
        return [
            'pagination' => $this->pagination(),
            'offer_groups' => $this->get_offer_groups(),
        ];
    }

    public function get_offer_list() {
        $offer_list = isset($this->data['offer_list']) ? $this->data['offer_list'] : false;

        if (!$offer_list || empty($offer_list) || !is_array($offer_list)) return false;

        return $offer_list;
    }

    public function get_controller() {
        $controller = isset($this->data['ofw_dokan_controller']) ? $this->data['ofw_dokan_controller'] : false;

        return $controller;
    }

    public function get_offer_actions($offer_id) {
        if (!$offer_id || empty($offer_id)) return false;

        $controller = $this->get_controller();
        if (!$controller) return false;

        $actions = $controller->offer_row_actions($offer_id);
        if (!$actions || empty($actions) || !is_array($actions)) return false;

        $actions = apply_filters('bidstitch_vendors_offers_actions', $actions, $offer_id);

        $payload = [];
        
        foreach($actions as $key => $row_action) {
            $custom_attr = '';

            if (!empty($row_action['custom']) && is_array($row_action['custom'])) {
                foreach($row_action['custom'] as $ckey => $attr) {
                    $custom_attr .= $ckey.'="'.$attr.'"';
                }
            }

            $payload[] = (object) [
                'custom_attr' => $custom_attr,
                'link' => !empty($row_action['url']) ? $row_action['url'] : '',
                'label' => !empty($row_action['label']) ? $row_action['label'] : '',
            ];
        }

        return $payload;
    }

    public function get_offer_status($offer_id) {
        if (!$offer_id || empty($offer_id)) return false;

        $controller = $this->get_controller();
        if (!$controller) return '';

        $offer_status = $controller->offer_status(get_post_status($offer_id));
        if (!$offer_status || empty($offer_status)) return '';

        return $offer_status;
    }

    public function get_offer_groups() {
        $offer_list = $this->get_offer_list();
        if (!$offer_list) return false;

        $offer_groups = [];

        foreach($offer_list as $offer) {
            $offer_id = !empty($offer->ID) ? $offer->ID : false;
            if (!$offer_id) continue;

            $product_id = get_post_meta($offer_id, 'orig_offer_product_id', true);

            $product = wc_get_product($product_id);
            if (!$product || empty($product)) continue;

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
            ];

            if (isset($offer_groups[$product_id])) {
                $offer_groups[$product_id]->offers[] = $offer_item;

                continue;
            }

            $offer_groups[$product_id] = (object) [
                'product_name' => $product_name,
                'product_thumbnail' => $product_thumbnail,
                'product_link' => $product_link,
                'offers' => [$offer_item],
            ];
        }

        return $offer_groups;
    }
    

    public function get_results() {
        $results = isset($this->data['results']) ? $this->data['results'] : false;

        return $results;
    }

    public function pagination() {
        $results = $this->get_results();
        if (!$results || empty($results) || !isset($results->max_num_pages)) return false;

        $current_page = max(1, get_query_var('paged'));

        // from plugin
        // change
        $big = 999999999;

        $pagination_args = [
            'current' => $current_page,
            'total' => $results->max_num_pages,
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'add_args' => false,
            'type' => 'array',
            'prev_text' => __('&larr; Previous', 'sage'),
            'next_text' => __('Next &rarr;', 'sage'),
            'format' => '?paged=%#%',
        ];

        $pagination_args = apply_filters('ofw_dokan_offers_pagination_args', $pagination_args, $current_page, $results->max_num_pages, $results);

        $links = paginate_links($pagination_args);

        return $links;
    }
}
