<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// change: parameters in app/View/Composers/DokanStore.php
get_header( 'shop' );

// change: no yoast_breadcrumb
?>
{{-- change: no woocommerce_before_main_content --}}

<div class="dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

    {{-- change: no left layout --}}

    <div id="dokan-primary" class="dokan-single-store">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

            <?php dokan_get_template_part( 'store-header' ); ?>
            {{-- change: --}} 
            @include('dokan.store-header-seller')

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

            {{-- change: --}} 
            @include('dokan.store-no-listings')

            <?php } ?>
            {{-- change: --}} 
            {!! \Roots\view('partials.single-product-notice')->render() !!}
        </div>

    </div><!-- .dokan-single-store -->

    <?php if ( 'right' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

</div><!-- .dokan-store-wrap -->

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>


