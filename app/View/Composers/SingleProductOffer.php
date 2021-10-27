<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use App\OffersHelpers;

class SingleProductOffer extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.single-product.add-to-cart.offer'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */

    public function with()
    {
        // get product id
        $product_id = $this->get_current_product_id();
        
        return [
            'user_can_offer' => $this->user_can_offer($product_id),
            'current_user_has_offers' => OffersHelpers::current_user_has_open_offers($product_id),
            'current_user_can_create_offer' => OffersHelpers::current_user_can_create_offer($product_id),
            'buyer_counteroffer_data' => $this->get_buyer_counteroffer_action_data($product_id),
            'received_offers_link' => OffersHelpers::get_received_offers_permalink(),
            'sent_offers_link' => OffersHelpers::get_sent_offers_permalink(),
            'product_id' => $product_id,
        ];
    }
    public function user_can_offer($product_id = '') {
        if (empty($product_id)) return false;

        // check if offers are enabled for this product
        $offers_enabled = OffersHelpers::get_offers_enabled_status_by_product_id($product_id);
        if (!$offers_enabled) return false;

        // check if user can offer
        $user_can_offer = OffersHelpers::current_user_can_offer();
        if (!$user_can_offer) return false;

        // check if user is product author
        $user_is_product_author = OffersHelpers::current_user_is_product_author($product_id);
        if ($user_is_product_author) return false;

        return true;
    }

    public function get_current_product_id() {
        global $product;
        if (!isset($product)) return false;

        // get product id
        $product_id = $product->get_id();
        if (empty($product_id)) return false;

        return $product_id;
    }

    public function is_buyer_counteroffer_request() {
        // check if action arg is set
        if (!isset($_GET['aewcobtn'])) return false;

        // check if offer id is set
        if (!isset($_GET['offer-pid'])) return false;
        if (empty($_GET['offer-pid'])) return false;

        return true;
    }

    public function get_buyer_counteroffer_action_data($product_id = '') {
        if (empty($product_id)) return false;

        // check if is counteroffer request
        $is_buyer_counteroffer_request = $this->is_buyer_counteroffer_request($product_id);
        if (!$is_buyer_counteroffer_request) return false;

        // get offer id
        $offer_id = wc_clean($_GET['offer-pid']);

        // check if can buyer counteroffer
        $user_can_buyercounter_offer = OffersHelpers::current_user_can_buyer_counteroffer($offer_id);
        if (!$user_can_buyercounter_offer) return false;

        // get offer action data
        $offer_action_data = OffersHelpers::get_offer_action_data($offer_id);
        if (empty($offer_action_data)) return false;

        return $offer_action_data;
    }
}
