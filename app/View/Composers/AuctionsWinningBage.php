<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class AuctionsWinningBage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.loop.winning-bage'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'badge' => $this->has_badge(),
        ];
    }

    public function has_badge() {
        global $product;
        
        // if no product, return
        if (!isset($product) || empty($product)) return false;

        // if is not auction product, return 
        if (!method_exists($product, 'get_type')) return false;
        if ($product->get_type() != 'auction') return false;
        
        $user_id  = get_current_user_id();

        // if user is not current bidder, return
        if ($user_id != $product->get_auction_current_bider()) return false;

        // if product is not available, return
        if ($product->get_auction_closed() || $product->is_sealed()) return false;

        return (object) [
            'product_id' => $product->get_id(),
            'user_id' => $user_id,
        ];
    }
}
