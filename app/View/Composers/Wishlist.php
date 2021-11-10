<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Wishlist extends Composer {
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.wishlist'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with() {
        // set query args
        $query_args = [
            'per_page' => 5,
            'current_page' => 1,
            'pagination' => 'yes',
        ];

        // get wishlist
        $wishlist = $this->get_wishlist($query_args);
        
        // get pagination args
        $pagination_args = $this->get_pagination_args($wishlist, $query_args);

        return [
            'items' => $this->get_wishlist_items($wishlist, $pagination_args),
            'pagination' => $this->get_pagination($pagination_args),
        ];
    }

    public function get_product_vendor($product_id = '') {
        // check if product exists
        if (empty($product_id)) return false;
        
        // get product post
        $post = get_post($product_id);

        // validate post existence
        if (empty($post)) return false;

        // get product post author
        $post_author = $post->post_author;

        // validate author existence
        if (empty($post_author)) return false;

        // get product vendor
        $vendor = dokan()->vendor->get($post_author);

        // validate vendor existence
        if (empty($vendor)) return false;

        return $vendor;
    }

    public function get_pagination_args($wishlist, $query_args) {
        // validate query args existence
        if (empty($query_args)) return false;

        // check if wishlist exists
        if (empty($wishlist)) return false;

        // get wishlist item count
        $count = $wishlist->count_items();

        // get per page param
        $per_page = $query_args['per_page'];

        // set pages default value
        $pages = 1;
    
        // get queried page number
        $queried_page = isset($_GET['pagenum']) ? wc_clean($_GET['pagenum']) : 1;

        // get current page
        $current_page = max(1, $queried_page ? $queried_page : $query_args['current_page']);

        // set offset default value
        $offset = 0;

        // check if wishlist item count should be paginated
        if ($count > 1) {
            // set total number of pages
            $pages = ceil($count / $per_page);

            // if current page is greater than number of pages
            // set current page to last page
            if ($current_page > $pages) $current_page = $pages;

            // set current page offset
            $offset = ($current_page - 1) * $per_page;
        } else {
            // set value if should not paginate
            $per_page = 0;
        }

        return [
            'current_page' => $current_page,
            'pages' => $pages,
            'per_page' => $per_page,
            'offset' => $offset,
            'base_url' =>  esc_url($wishlist->get_url()),
        ];
    }

    public function get_wishlist($query_args) {
        // validate query args existence
        if (empty($query_args)) return false;

        // Validate class existence
        if (!class_exists('YITH_WCWL_Wishlist_Factory')) return false;

        // get wishlist
        $wishlist = \YITH_WCWL_Wishlist_Factory::get_current_wishlist($query_args);

        // check if wishlist exists
        if (empty($wishlist)) return false;

        // validate wishlist visibility
        if (!$wishlist->current_user_can('view')) return false;
        
        // validate wishlist owner
        if (!$wishlist->is_current_user_owner()) return false;

        return $wishlist;
    }

    public function get_product_purchase_status($product) {
        // validate product existence
        if (empty($product)) return false;

        // get product type
        $product_type = $product->get_type();
        
        // check if is auction product
        if ($product_type != 'auction') {
            // get stock status
            $stock_status = $product->get_stock_status();

            // check if product is in stock
            return $stock_status == 'instock';
        }

        // check if auction product is purchasable
        return !$product->is_closed();
    }

    public function get_wishlist_items($wishlist, $pagination_args) {
        // check if wishlist exists
        if (empty($wishlist)) return false;

        // check if pagination args exist
        if (empty($pagination_args)) return false;

        // get wishlist items
        $wishlist_items = $wishlist->get_items(
            $pagination_args['per_page'], 
            $pagination_args['offset']
        );

        // check if wishlist items exist
        if (empty($wishlist_items)) return false;

        $payload = [];

        foreach ($wishlist_items as $key => $item) {
            $product = $item->get_product();

            // check if product exists
            if (empty($product)) continue;

            // get product id
            $product_id = $product->get_id();

            // get product vendor
            $vendor = $this->get_product_vendor($product_id);

            $payload[] = (object) [
                'product_image' => $product->get_image('woocommerce_thumbnail', ['class' => 'w-24 h-24 rounded-md object-center object-cover sm:w-32 sm:h-32'], true),
                'product_title' => $product->get_title(),
                'product_link' => $product->get_permalink(),
                'product_price' => $product->get_price_html(),
                'product_purchase_status' => $this->get_product_purchase_status($product),
                'store_name' => $vendor ? $vendor->get_shop_name() : false,
                'store_link' => $vendor ? $vendor->get_shop_url() : false,
                'remove_link' => add_query_arg('remove_from_wishlist', $product_id),
            ];
        }

        return $payload;
    }

    public function get_pagination($pagination_args) {
        // check if pagination args exist
        if (empty($pagination_args)) return false;

        // check if should paginate
        if ($pagination_args['pages'] <= 1) return false;

        $pagination = paginate_links([
            'current' => $pagination_args['current_page'],
            'total' => $pagination_args['pages'],
            'base' => $pagination_args['base_url'] . '%_%',
            'format' => '?pagenum=%#%',
            'add_args' => false,
            'type' => 'array',
        ]);

        return $pagination;
    }
}
