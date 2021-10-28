<?php

namespace App\View\Composers;

use Illuminate\Support\Collection;
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
        return [
            'show_variation' => get_option('yith_wcwl_variation_show') == 'yes',
            'show_price' => get_option('yith_wcwl_price_show') == 'yes',
            'show_price_variations' => get_option('yith_wcwl_price_changes_show') == 'yes',
            'show_stock_status' => get_option('yith_wcwl_stock_show') == 'yes',
            'show_remove_product' => get_option('yith_wcwl_show_remove', 'yes') == 'yes',
            'has_wishlist' => $this->has_wishlist(),
            'items' => $this->getWishlistItems(),
        ];
    }
    /**
     * Data to be passed to view before rendering.
     * @return array
     */
    protected function getWishlistItems():array
    {
        $wishlist_items = $this->data['wishlist_items'] ?? [];
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

                $payload[] = [
                    'product_image' => $product->get_image('medium', ['class' => 'w-24 h-24 rounded-md object-center object-cover sm:w-32 sm:h-32'], true),
                    'product_title' => wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ),
                    'product_link' => esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ),
                    'product_price' => $item->get_formatted_product_price(),
                    'product_price_variation' => $item->get_price_variation(),
                    'store_name' => $store['store_name'] ?? '',
                    'store_url' => dokan_get_store_url($vendor_id),
                    'is_type_variation' => $product->is_type( 'variation'),
                    'formatted_variation' => wc_get_formatted_variation($product),
                    'product_is_out_of_stock' => 'out-of-stock' === ($availability['class'] ?? ''),
                    'product_remove_url' => esc_url( add_query_arg( 'remove_from_wishlist', $item->get_product_id() ) )
                ];
            }
        }
        return $payload;
    }
    /**
     * Data to be passed to view before rendering.
     *
     * @return boolean
     */
    protected function has_wishlist(): bool
    {
        return $this->data['wishlist'] && $this->data['wishlist']->has_items();
    }
}
