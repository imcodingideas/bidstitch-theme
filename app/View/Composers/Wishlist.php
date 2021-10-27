<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Wishlist extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.wishlist.items'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $data['show_variation'] = get_option('yith_wcwl_variation_show') == 'yes';
        $data['show_price'] = get_option('yith_wcwl_price_show') == 'yes';
        $data['show_price_variations'] = get_option('yith_wcwl_price_changes_show') == 'yes';
        $data['show_stock_status'] = get_option('yith_wcwl_stock_show') == 'yes';
        $data['show_remove_product'] = get_option('yith_wcwl_show_remove', 'yes') == 'yes';

        $data['wishlist'] = $this->getWishlist();
        $wishlist_items = $this->getWishlistItems();

        $payload = [];
        if (count($wishlist_items)) {
            foreach ($wishlist_items as $key => $item) {

                $product = $item->get_product();
                $availability = $product->get_availability();

                // get vendor id
                $vendor_id = $product->post->post_author ?? 0;
                // get vendor store info
                $store = dokan_get_store_info($vendor_id);
                // get vendor store name

                $payload[$key]['product'] = $product;
                $payload[$key]['vendor_id'] = $vendor_id;
                $payload[$key]['stock_status'] = $availability['class'] ?? false;
                $payload[$key]['store_name'] = $store['store_name'] ?? '';
            }
        }
        $data['wishlist_items'] = $wishlist_items;
        $data['payload'] = $payload;

        return $data;
    }
    /**
     * Data to be passed to view before rendering.
     *
     * @return \YITH_WCWL_Wishlist Current wishlist
     */
    public function getWishlist()
    {
        return $this->data['wishlist'] ?? null;
    }
    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function getWishlistItems()
    {
        return $this->data['wishlist_items'] ?? [];
    }
}
