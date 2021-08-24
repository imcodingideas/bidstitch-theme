<?php

use WeDevs\Dokan\Walkers\CategoryDropdownSingle;
use WeDevs\Dokan\Walkers\TaxonomyDropdown;

global $post;

$from_shortcode = false;

if ( !isset( $post->ID ) && ! isset( $_GET['product_id'] ) ) {
    wp_die( esc_html__( 'Access Denied, No product found', 'dokan-lite' ) );
}

if ( isset( $post->ID ) && $post->ID && 'product' == $post->post_type ) {
    $post_id      = $post->ID;
    $post_title   = $post->post_title;
    $post_content = $post->post_content;
    $post_excerpt = $post->post_excerpt;
    $post_status  = $post->post_status;
    $product      = wc_get_product( $post_id );
}

if ( isset( $_GET['product_id'] ) ) {
    $post_id        = intval( $_GET['product_id'] );
    $post           = get_post( $post_id );
    $post_title     = $post->post_title;
    $post_content   = $post->post_content;
    $post_excerpt   = $post->post_excerpt;
    $post_status    = $post->post_status;
    $product        = wc_get_product( $post_id );
    $from_shortcode = true;
}

if ( ! dokan_is_product_author( $post_id ) ) {
    wp_die( esc_html__( 'Access Denied', 'dokan-lite' ) );
    exit();
}

$_regular_price         = get_post_meta( $post_id, '_regular_price', true );
$_sale_price            = get_post_meta( $post_id, '_sale_price', true );
$is_discount            = !empty( $_sale_price ) ? true : false;
$_sale_price_dates_from = get_post_meta( $post_id, '_sale_price_dates_from', true );
$_sale_price_dates_to   = get_post_meta( $post_id, '_sale_price_dates_to', true );

$_sale_price_dates_from = !empty( $_sale_price_dates_from ) ? date_i18n( 'Y-m-d', $_sale_price_dates_from ) : '';
$_sale_price_dates_to   = !empty( $_sale_price_dates_to ) ? date_i18n( 'Y-m-d', $_sale_price_dates_to ) : '';
$show_schedule          = false;

if ( !empty( $_sale_price_dates_from ) && !empty( $_sale_price_dates_to ) ) {
    $show_schedule = true;
}

$_featured        = get_post_meta( $post_id, '_featured', true );
$terms            = wp_get_object_terms( $post_id, 'product_type' );
$product_type     = ( ! empty( $terms ) ) ? sanitize_title( current( $terms )->name ): 'simple';
$variations_class = ($product_type == 'simple' ) ? 'dokan-hide' : '';
$_visibility      = ( version_compare( WC_VERSION, '2.7', '>' ) ) ? $product->get_catalog_visibility() : get_post_meta( $post_id, '_visibility', true );

if ( ! $from_shortcode ) {
    get_header();
}

if ( ! empty( $_GET['errors'] ) ) {
    dokan()->dashboard->templates->products->set_errors( array_map( 'sanitize_text_field', wp_unslash( $_GET['errors'] ) ) );
}

/**
 *  dokan_dashboard_wrap_before hook
 *
 *  @since 2.4
 */
do_action( 'dokan_dashboard_wrap_before', $post, $post_id );
?>

<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

    <div class="dokan-dashboard-wrap">

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *  dokan_before_product_content_area hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_before' );
            do_action( 'dokan_before_product_content_area' );
        ?>

        <div class="dokan-dashboard-content dokan-product-edit">

            <?php

                /**
                 *  dokan_product_content_inside_area_before hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_product_content_inside_area_before' );
            ?>

            <header class="dokan-dashboard-header dokan-clearfix">
                <h1 class="entry-title">
                    <?php esc_html_e( 'Edit Product', 'dokan-lite' ); ?>
                    <span class="dokan-label <?php echo esc_attr( dokan_get_post_status_label_class( $post->post_status ) ); ?> dokan-product-status-label">
                        <?php echo esc_html( dokan_get_post_status( $post->post_status ) ); ?>
                    </span>

                    <?php if ( $post->post_status == 'publish' ) { ?>
                        <span class="dokan-right">
                            <a class="dokan-btn dokan-btn-theme dokan-btn-sm" href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" target="_blank"><?php esc_html_e( 'View Product', 'dokan-lite' ); ?></a>
                        </span>
                    <?php } ?>

                    <?php if ( $_visibility == 'hidden' ) { ?>
                        <span class="dokan-right dokan-label dokan-label-default dokan-product-hidden-label"><i class="fa fa-eye-slash"></i> <?php esc_html_e( 'Hidden', 'dokan-lite' ); ?></span>
                    <?php } ?>
                </h1>
            </header><!-- .entry-header -->

            <div class="product-edit-new-container product-edit-container">
                <?php if ( dokan()->dashboard->templates->products->has_errors() ) { ?>
                    <div class="dokan-alert dokan-alert-danger">
                        <a class="dokan-close" data-dismiss="alert">&times;</a>

                        <?php foreach ( dokan()->dashboard->templates->products->get_errors() as $error ) { ?>
                            <strong><?php esc_html_e( 'Error!', 'dokan-lite' ); ?></strong> <?php echo esc_html( $error ) ?>.<br>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ( isset( $_GET['message'] ) && $_GET['message'] == 'success') { ?>
                    <div class="dokan-message">
                        <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
                        <strong><?php esc_html_e( 'Success!', 'dokan-lite' ); ?></strong> <?php esc_html_e( 'The product has been saved successfully.', 'dokan-lite' ); ?>

                        <?php if ( $post->post_status == 'publish' ) { ?>
                            <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View Product &rarr;', 'dokan-lite' ); ?></a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php
                $can_sell = apply_filters( 'dokan_can_post', true );

                if ( $can_sell ) {
                    // change
                    if ( dokan_is_seller_enabled( get_current_user_id() ) ) { 
                        echo \Roots\view('dokan.edit-product-form')->render();
                    } else { ?>
                        <div class="dokan-alert dokan-alert">
                            <?php echo esc_html( dokan_seller_not_enabled_notice() ); ?>
                        </div>
                    <?php } ?>

                <?php } else { ?>

                    <?php do_action( 'dokan_can_post_notice' ); ?>

                <?php } ?>
            </div> <!-- #primary .content-area -->

            <?php

                /**
                 *  dokan_product_content_inside_area_after hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_product_content_inside_area_after' );
            ?>
        </div>

        <?php

            /**
             *  dokan_dashboard_content_after hook
             *  dokan_after_product_content_area hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_after' );
            do_action( 'dokan_after_product_content_area' );
        ?>

    </div><!-- .dokan-dashboard-wrap -->

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>

<div class="dokan-clearfix"></div>

<?php

    /**
     *  dokan_dashboard_content_before hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_dashboard_wrap_after', $post, $post_id );

    wp_reset_postdata();

    if ( ! $from_shortcode ) {
        get_footer();
    }
?>
