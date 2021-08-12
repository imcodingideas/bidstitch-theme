<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SingleProductAccordionOffers extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.single-product-accordion-offers'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'should_be_displayed' => $this->should_be_displayed(),
            'offers' => $this->offers(),
        ];
    }
    public function should_be_displayed()
    {
        global $product;
        $product_id = get_the_ID();
        $is_auction = $this->check_product_is_auction($product_id);
        $current_user_id = get_current_user_id();
        $author_product_id = get_the_author_meta('ID');
        return is_user_logged_in() &&
            !$is_auction &&
            $current_user_id == $author_product_id;
    }
    public function check_product_is_auction($product_id)
    {
        global $product;

        $terms = get_the_terms($product_id, 'product_type');

        if ($terms && !is_wp_error($terms)):
            foreach ($terms as $term) {
                if ($term->slug == 'auction') {
                    return true;
                }
            }
        endif;

        return false;
    }
    public function offers()
    {
        global $product;
        $product_id = get_the_ID();

        $args_offer = [
            'post_status' => 'any',
            'post_type' => 'woocommerce_offer',
            'meta_key' => 'offer_product_id',
            'meta_query' => [
                [
                    'key' => 'offer_product_id',
                    'value' => $product_id,
                ],
            ],
        ];
        $offers = [];

        $query_offer = new \WP_Query($args_offer);
        if ($query_offer->have_posts()) {
            while ($query_offer->have_posts()) {
                $query_offer->the_post();

                $id_offer = get_the_ID();
                $author_id = get_the_author_meta('ID');
                $user = get_userdata($author_id);
                $avatar = get_user_meta($author_id, 'wp_user_avatar');
                $offer_price_per = get_post_meta(
                    get_the_ID(),
                    'offer_price_per',
                    true
                );
                $vendor = new \WP_User($author_id);
                $store_info = dokan_get_store_info($author_id);
                $post_status = get_post_status();

                $user_profile_link = get_field('user_profile', 'option');
                $user_profile_link = !empty($user_profile_link)
                    ? $user_profile_link . '?id=' . $author_id
                    : '#';
                $time_elapsed_string = $this->time_elapsed_string(
                    get_the_date()
                );
                $offers[] = compact(
                    'id_offer',
                    'author_id',
                    'user',
                    'avatar',
                    'offer_price_per',
                    'vendor',
                    'store_info',
                    'post_status',
                    'user_profile_link',
                    'user_profile_link',
                    'time_elapsed_string'
                );
            }
        }
        wp_reset_postdata();
        return $offers;
    }
    public function time_elapsed_string($datetime, $full = false)
    {
        $now = new \DateTime();
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
