<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();
$layout       = get_theme_mod( 'store_layout', 'left' );

$products_by_store_user    = $store_user->get_products();

$post_counts  = dokan_count_posts( 'product', get_query_var( 'author' ) );

$count_product = $post_counts->publish;

$orders_count = dokan_count_orders(get_query_var( 'author' ));
$store_total_sales = $orders_count->total;



$catalog_orderby_options = apply_filters(
    'woocommerce_catalog_orderby',
    array(
        'menu_order' => __( 'Default sorting', 'woocommerce' ),
        'popularity' => __( 'Sort by popularity', 'woocommerce' ),
        'rating'     => __( 'Sort by average rating', 'woocommerce' ),
        'date'       => __( 'Sort by latest', 'woocommerce' ),
        'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
        'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
    )
);

$default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );

$orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby;


if ( ! wc_review_ratings_enabled() ) {
    unset( $catalog_orderby_options['rating'] );
}
if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
    $orderby = current( array_keys( $catalog_orderby_options ) );
}

get_header( 'shop' );

?>

<?php //do_action( 'woocommerce_before_main_content' ); ?>

<div class="dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

    <div id="dokan-primary" class="dokan-single-store">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

            <?php dokan_get_template_part( 'store-header' ); ?>

            <div class="row header-seller">
                <p><?php echo $count_product; ?> <?php echo _e('Listings','flatsome-child'); ?> | <?php echo $store_total_sales; ?> <?php echo _e(' Sales','flatsome-child'); ?></p>
                <form class="dokan-ordering-product ajaxfilterform" method="get">
                    <select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
                        <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                            <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="store_user_id" value="<?php echo $store_user->get_id(); ?>" />
                    <input type="hidden" name="paged" value="1" />
                    <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
                </form>
            </div>

            <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

            <?php if ( have_posts() ) { ?>

                <div class="seller-items">

                    <?php woocommerce_product_loop_start(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>



                    <?php woocommerce_product_loop_end(); ?>

                </div>

                <?php dokan_content_nav( 'nav-below' ); ?>

            <?php } else { ?>

                <div class="container">
                    <p class="dokan-info"><?php esc_html_e( 'This seller does not have any listings yet!', 'dokan-lite' ); ?></p>
                </div>           

            <?php } ?>
            <?php echo \Roots\view('partials.single-product-notice')->render(); ?>
        </div>

    </div><!-- .dokan-single-store -->

    <?php if ( 'right' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

</div><!-- .dokan-store-wrap -->

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>

