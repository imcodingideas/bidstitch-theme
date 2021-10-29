<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class MyOffers extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.my-offers'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'offers' => $this->get_customer_offers(),
        ];
    }
    private function get_customer_offers()
    {
        $customer_offers = get_posts(apply_filters('ofw_my_account_my_offers_query', array(
            'numberposts' => -1,
            'author' => get_current_user_id(),
            'post_type' => 'woocommerce_offer',
            'post_status' => 'any'
        )));
        $payload = [];
        foreach ($customer_offers as $customer_order) {
            $offer_args = array();
            $post_id = $customer_order->ID;
            $offer_status = get_post_status($post_id);
            if (empty($offer_status)) {
                continue;
            }
            $post_status = $offer_status;
            $product_id = get_post_meta($post_id, 'orig_offer_product_id', true);
            $variant_id = get_post_meta($post_id, 'orig_offer_variation_id', true);
            $offer_uid = get_post_meta($post_id, 'offer_uid', true);
            $offer_final_offer = get_post_meta($post_id, 'offer_final_offer', true);
            $offer_currency = get_post_meta($post_id, 'offer_currency', true);
            if (empty($offer_currency)) {
                $offer_currency = get_woocommerce_currency();
            }
            if ('product' !== get_post_type($product_id)) {
                continue;
            }
            $product = ( $variant_id ) ? wc_get_product($variant_id) : wc_get_product($product_id);
            $product_title = get_the_title($product_id);
            $offer_args['product_url'] = $product->get_permalink();
            $offer_args['offer_id'] = $post_id;
            $offer_args['offer_uid'] = $offer_uid;
            $offer_args['final_offer'] = $offer_final_offer;
            $expiration_date = get_post_meta($post_id, 'offer_expiration_date', true);
            $expiration_date_formatted = ($expiration_date) ? date("Y-m-d 23:59:59", strtotime($expiration_date)) : false;

            if ($product_title) {
                $product_type = $product->get_type();
                $pproduct_id  = $product->get_id();

                if ($product_type == 'variation') {
                    $_product = new WC_Product_Variation($variant_id);
                    if (get_post_status($pproduct_id) == 'trash') {
                        $product_title = sprintf('%s', $_product->get_title());
                    } else {
                        $product_title = apply_filters('ofw_product_url', sprintf('<a title="%s" target="_blank" href="%s">%s</a>', __('View Product', 'offers-for-woocommerce'), esc_url($_product->get_permalink()), $_product->get_title()));
                    }
                } else {
                    if (get_post_status($pproduct_id) == 'trash') {
                        $product_title = sprintf('%s', get_the_title($product_id));
                    } else {
                        $product_title = apply_filters('ofw_product_url', sprintf('<a title="%s" target="_blank" href="%s">%s</a>', __('View Product', 'offers-for-woocommerce'), esc_url(get_the_permalink($product_id)), get_the_title($product_id)));
                    }
                }
            } else {
                $product_title = '<em>' . __('Not Found', 'offers-for-woocommerce') . '</em>';
            }

            if ($post_status == 'buyercountered-offer') {
                $val = get_post_meta($post_id, 'offer_buyer_counter_quantity', true);
            } else {
                $val = get_post_meta($post_id, 'offer_quantity', true);
            }
            $offer_quantity = ($val != '') ? $val : '0';

            if ($post_status == 'buyercountered-offer') {
                $val = get_post_meta($post_id, 'offer_buyer_counter_price_per', true);
            } else {
                $val = get_post_meta($post_id, 'offer_price_per', true);
            }
            $val = ($val != '') ? $val : '0';
            $offer_price_per = wc_price($val, array('currency' => $offer_currency));

            if ($post_status == 'buyercountered-offer') {
                $val = get_post_meta($post_id, 'offer_buyer_counter_amount', true);
            } else {
                $val = get_post_meta($post_id, 'offer_amount', true);
            }
            $val = ($val != '') ? $val : '0';
            $offer_amount = wc_price($val, array('currency' => $offer_currency));

            switch ($post_status) {
                case 'publish':
                    $offer_status = __('Pending', 'offers-for-woocommerce');
                    break;
                case 'countered-offer':
                    $offer_status = __('Countered', 'offers-for-woocommerce');
                    break;
                case 'accepted-offer':
                    $offer_status = __('Accepted', 'offers-for-woocommerce');
                    break;
                case 'declined-offer':
                    $offer_status = __('Declined', 'offers-for-woocommerce');
                    break;
                case 'buyercountered-offer':
                    $offer_status = __('Buyer Countered', 'offers-for-woocommerce');
                    break;
                case 'trash':
                    $offer_status = __('Trashed', 'offers-for-woocommerce');
                    break;
                case 'completed-offer':
                    $offer_status = __('Completed', 'offers-for-woocommerce');
                    break;
                case 'on-hold-offer':
                    $offer_status = __('On Hold', 'offers-for-woocommerce');
                    break;
                case 'expired-offer':
                    $offer_status = __('Expired', 'offers-for-woocommerce');
                    break;
                default:
                    $offer_status = $post_status;
                    break;
            }
            $offer_action = null;
            if (($expiration_date_formatted) && ($expiration_date_formatted <= (date("Y-m-d H:i:s", current_time('timestamp', 0))) )) {
            } else {
                $post_status = apply_filters('ofw_admin_created_offer_status', $post_status, $post_id);
                $payment_authorization = get_post_meta($post_id, '_payment_authorization_make_offer', true);
                switch ($post_status) {
                    case 'countered-offer':
                        if (empty($payment_authorization)) {
                            $v = strpos($offer_args['product_url'], '?') ? '&' : '?';
                            $offer_action = '<a class="button" href="' . $offer_args['product_url'] . $v . '__aewcoapi=1&woocommerce-offer-id=' . $offer_args['offer_id'] . '&woocommerce-offer-uid=' . $offer_args['offer_uid'] . '">Click to Pay</a>';
                        }
                        if (isset($offer_args['final_offer']) && $offer_args['final_offer'] == '1') {
                        } else {
                            $v = strpos($offer_args['product_url'], '?') ? '&' : '?';
                            $offer_action = '<a class="button" href="' . $offer_args['product_url'] . $v . 'aewcobtn=1&offer-pid=' . $offer_args['offer_id'] . '&offer-uid=' . $offer_args['offer_uid'] . '">Click to Counter</a>';
                        }
                        break;
                    case 'accepted-offer':
                        if (empty($payment_authorization)) {
                            $v = strpos($offer_args['product_url'], '?') ? '&' : '?';
                            $offer_action = '<a class="button" href="' . $offer_args['product_url'] . $v . '__aewcoapi=1&woocommerce-offer-id=' . $offer_args['offer_id'] . '&woocommerce-offer-uid=' . $offer_args['offer_uid'] . '">Click to Pay</a>';
                        }
                        break;
                }
            }
            $payload[] = [
              'product_title' => $product_title,
              'offer_quantity' => $offer_quantity,
              'offer_price_per' => wc_price($offer_price_per),
              'offer_amount' => wc_price($offer_amount),
              'offer_status' => $offer_status,
              'offer_action' => $offer_action,
            ];
        }
        return $payload;
    }
}
