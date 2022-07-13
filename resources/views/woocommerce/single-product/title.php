<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// changed:
the_title( '<h1 class="product_title entry-title text-xl font-bold md:text-2xl lg:text-3xl mr-12">', '</h1>' );

// changed:
if (class_exists('YITH_WCWL_Shortcode')) {
  // plugin: yith-woocommerce-wishlist-premium
  echo YITH_WCWL_Shortcode::add_to_wishlist([]);
}

global $product;
if (get_current_user_id() == 1) {
?>
<div class="sm:inline-block mt-4">
    <?php echo \Roots\view('woocommerce.featured-product', ['product_id' => $product->get_id()])->render(); ?>
</div>
<?php }
