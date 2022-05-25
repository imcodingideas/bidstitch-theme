<?php

// extends: dokan-lite/templates/products/new-product-single.php
// version: dokan lite 3.2.9

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

$is_merch = false;
$product_cats = wp_get_object_terms( $post_id, 'product_cat' );
foreach ($product_cats as $product_cat) {
  if ($product_cat->slug === 'merch') {
    $is_merch = true;
    break;
  }
}

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

                    if ( dokan_is_seller_enabled( get_current_user_id() ) ) { ?>
                        <form data-disable-submit class="dokan-product-edit-form" role="form" method="post">

                            <?php do_action( 'dokan_product_data_panel_tabs' ); ?>
                            <?php do_action( 'dokan_product_edit_before_main' ); ?>

                            <div class="dokan-form-top-area">

                                <div class="content-half-part dokan-product-meta">

                                    <div id="dokan-product-title-area" class="dokan-form-group">
                                        <input type="hidden" name="dokan_product_id" id="dokan-edit-product-id" value="<?php echo esc_attr( $post_id ); ?>"/>

                                        <label for="post_title" class="form-label"><?php esc_html_e( 'Title', 'dokan-lite' ); ?></label>
                                        <input type="text" name="post_title" id="post_title" value="{!! $post_title !!}" class="dokan-form-control" placeholder="Product name..." maxlength="120">
                                        <div class="dokan-product-title-alert dokan-hide">
                                            <?php esc_html_e( 'Please enter product title!', 'dokan-lite' ); ?>
                                        </div>


                                        <?php // change ?>
                                        <div class="mt-6">
                                            <?php if (empty($post->post_excerpt)): ?>
                                                <?php echo \Roots\view('dokan.product-fields.description', ['post' => $post])->render(); ?>
                                            <?php else: ?>
                                                <?php echo \Roots\view('dokan.product-fields.excerpt', ['post' => $post])->render(); ?>
                                            <?php endif; ?>
                                        </div>

                                        <?php // change ?>
                                        <div class="mt-6">
                                            <?php echo \Roots\view('dokan.product-fields.condition', [ 'post'=> $post ])->render(); ?>
                                        </div>

                                        <div id="edit-slug-box" class="hide-if-no-js"></div>
                                        <?php wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false ); ?>
                                        <input type="hidden" name="editable-post-name" class="dokan-hide" id="editable-post-name-full-dokan">
                                        <input type="hidden" value="<?php echo esc_attr( $post->post_name ); ?>" name="edited-post-name" class="dokan-hide" id="edited-post-name-dokan">
                                    </div>

                                    <?php $product_types = apply_filters( 'dokan_product_types', 'simple' ); ?>

                                    <?php if( 'simple' === $product_types ): ?>
                                            <input type="hidden" id="product_type" name="product_type" value="simple">
                                    <?php endif; ?>

                                    <?php // change:hide ?>
                                    <?php if ( is_array( $product_types ) ): ?>
                                        <div class="dokan-form-group hidden">
                                            <label for="product_type" class="form-label"><?php esc_html_e( 'Product Type', 'dokan-lite' ); ?> <i class="fa fa-question-circle tips" aria-hidden="true" data-title="<?php esc_html_e( 'Choose Variable if your product has multiple attributes - like sizes, colors, quality etc', 'dokan-lite' ); ?>"></i></label>
                                            <select name="product_type" class="dokan-form-control" id="product_type">
                                                <?php foreach ( $product_types as $key => $value ) { ?>
                                                    <option value="<?php echo esc_attr( $key ) ?>" <?php selected( $product_type, $key ) ?>><?php echo esc_html( $value ) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>

                                    <?php // change: do_action( 'dokan_product_edit_after_title', $post, $post_id ); ?>

                                    <div class="show_if_simple dokan-clearfix show_if_external">

                                        <div class="dokan-form-group dokan-clearfix dokan-price-container">

                                            <div class="regular-price">
                                                <label for="_regular_price" class="form-label"><?php esc_html_e( 'Price', 'dokan-lite' ); ?>
                                                    <span
                                                        class="vendor-earning simple-product"
                                                        data-commission="<?php echo esc_attr( dokan()->commission->get_earning_by_product( $post_id ) ); ?>"
                                                        data-product-id="<?php echo esc_attr( $post_id ); ?>">
                                                            ( <?php esc_html_e( ' You Earn : ', 'dokan-lite' ) ?><?php echo esc_html( get_woocommerce_currency_symbol() ); ?>
                                                                <span class="vendor-price">
                                                                    <?php echo esc_html( wc_format_localized_price( esc_attr( dokan()->commission->get_earning_by_product( $post_id ) ) ) ); ?>
                                                                </span>
                                                            )
                                                    </span>
                                                </label>
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo esc_html( get_woocommerce_currency_symbol() ); ?></span>
                                                    <?php dokan_post_input_box( $post_id, '_regular_price', array( 'class' => 'dokan-product-regular-price', 'placeholder' => __( '0.00', 'dokan-lite' ) ), 'price' ); ?>
                                                </div>
                                            </div>

                                            <?php // change ?>
                                            <div class="content-half-part sale-price hidden">
                                                <label for="_sale_price" class="form-label">
                                                    <?php esc_html_e( 'Discounted Price', 'dokan-lite' ); ?>
                                                    <a href="#" class="sale_schedule <?php echo ($show_schedule ) ? 'dokan-hide' : ''; ?>"><?php esc_html_e( 'Schedule', 'dokan-lite' ); ?></a>
                                                    <a href="#" class="cancel_sale_schedule <?php echo ( ! $show_schedule ) ? 'dokan-hide' : ''; ?>"><?php esc_html_e( 'Cancel', 'dokan-lite' ); ?></a>
                                                </label>

                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo esc_html( get_woocommerce_currency_symbol() ); ?></span>
                                                    <?php dokan_post_input_box( $post_id, '_sale_price', array( 'class' => 'dokan-product-sales-price','placeholder' => __( '0.00', 'dokan-lite' ) ), 'price' ); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dokan-form-group dokan-clearfix dokan-price-container">
                                            <div class="dokan-product-less-price-alert dokan-hide">
                                                <?php esc_html_e('Product price can\'t be less than the vendor fee!', 'dokan-lite' ); ?>
                                            </div>
                                        </div>

                                        <div class="sale_price_dates_fields dokan-clearfix dokan-form-group <?php echo ( ! $show_schedule ) ? 'dokan-hide' : ''; ?>">
                                            <div class="content-half-part from">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php esc_html_e( 'From', 'dokan-lite' ); ?></span>
                                                    <input type="text" name="_sale_price_dates_from" class="dokan-form-control dokan-start-date" value="<?php echo esc_attr( $_sale_price_dates_from ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'dokan-lite' ); ?>">
                                                </div>
                                            </div>

                                            <div class="content-half-part to">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php esc_html_e( 'To', 'dokan-lite' ); ?></span>
                                                    <input type="text" name="_sale_price_dates_to" class="dokan-form-control dokan-end-date" value="<?php echo esc_attr( $_sale_price_dates_to ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'dokan-lite' ); ?>">
                                                </div>
                                            </div>
                                        </div><!-- .sale-schedule-container -->
                                    </div>

                                    <?php do_action( 'dokan_product_edit_after_pricing', $post, $post_id ); ?>


                                    <?php // change ?>
                                    <div class="dokan-form-group hidden">
                                        <label for="product_tag" class="form-label"><?php esc_html_e( 'Tags', 'dokan-lite' ); ?></label>
                                        <?php
                                        require_once DOKAN_LIB_DIR.'/class.taxonomy-walker.php';
                                        $terms            = wp_get_post_terms( $post_id, 'product_tag', array( 'fields' => 'all' ) );
                                        $can_create_tags  = dokan_get_option( 'product_vendors_can_create_tags', 'dokan_selling' );
                                        $tags_placeholder = 'on' === $can_create_tags ? __( 'Select tags/Add tags', 'dokan-lite' ) : __( 'Select product tags', 'dokan-lite' );

                                        $drop_down_tags = array(
                                            'hide_empty' => 0,
                                        );
                                        ?>
                                        <select multiple="multiple" name="product_tag[]" id="product_tag_search" class="product_tag_search product_tags dokan-form-control dokan-select2" data-placeholder="<?php echo esc_attr( $tags_placeholder ); ?>">
                                            <?php if ( ! empty( $terms ) ) : ?>
                                                <?php foreach ( $terms as $tax_term ) : ?>
                                                    <option value="<?php echo esc_attr( $tax_term->term_id ); ?>" selected="selected" ><?php echo esc_html( $tax_term->name ); ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>

                                    <?php do_action( 'dokan_product_edit_after_product_tags', $post, $post_id ); ?>
                                </div><!-- .content-half-part -->

                                <div class="content-half-part featured-image">
                                    <div class="grid">
                                        @php
                                            $feat_image_id = get_post_thumbnail_id($post_id);
                                            $featured_image_urls = [];
                                            if (!empty($feat_image_id)) $featured_image_urls[] = $feat_image_id;

                                            $product_images = get_post_meta($post_id, '_product_image_gallery', true);
                                            $gallery = (!empty($product_images)) ? explode(',', $product_images) : [];
                                        @endphp

                                        <div class="grid gap-4">
                                            <x-form-group>
                                                <label class="font-bold uppercase">
                                                    {{ _e('Featured Image', 'sage') }}
                                                    <span class="text-red-500">{{ _e('(Required)', 'sage') }}</span>
                                                </label>
                                                <x-media-uploader
                                                    name="feat_image_id"
                                                    :files="$featured_image_urls"
                                                    labelIdle="Upload Featured Image"
                                                    required
                                                />
                                            </x-form-group>

                                            <x-form-group>
                                                <label class="font-bold uppercase">
                                                    {{ _e('Listing Images', 'sage') }}
                                                    <span>{{ _e('(Max 7)', 'sage') }}</span>
                                                </label>
                                                <x-media-uploader
                                                    name="product_image_gallery"
                                                    :files="$gallery"
                                                    labelIdle="Upload Listing Images"
                                                    multiple
                                                />
                                            </x-form-group>
                                        </div>
                                    </div>
                                </div><!-- .content-half-part -->
                            </div><!-- .dokan-form-top-area -->

                            @if (get_current_user_id() == 1)
                              <div>
                                <input id="add-to-merch" type="checkbox" name="add_to_merch" value="yes" @php if ($is_merch) echo 'checked' @endphp>
                                <label for="add-to-merch">Add as merch</label>
                              </div>
                            @endif

                            <?php // change ?>
                            <div class="md:flex w-full md:space-x-6 space-y-6 md:space-y-0 bg-white p-4 mt-6">
                                <div class="flex-1 flex-col space-y-6">
                                    <?php echo \Roots\view('dokan.product-fields.category-subcategory-size', [ 'post'=>$post ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.color', [ 'post'=>$post ])->render(); ?>
                                </div>
                                <div class="flex-1 flex-col space-y-6">
                                    <?php echo \Roots\view('dokan.product-fields.tag-type', [ 'post'=>$post ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.pit-to-pit', [ 'post'=>$post ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.length', [ 'post'=>$post ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.stitching', [ 'post'=>$post ])->render(); ?>
                                </div>
                            </div>

                            <?php if (!empty($post->post_excerpt)): ?>
                                <div class="mt-6">
                                    <?php echo \Roots\view('dokan.product-fields.description', ['post' => $post])->render(); ?>
                                </div>
                            <?php endif; ?>

                            <?php // change: hide ?>
                            <div class="hidden">
                            <?php do_action( 'dokan_new_product_form', $post, $post_id ); ?>
                            <?php do_action( 'dokan_product_edit_after_main', $post, $post_id ); ?>
                            <?php do_action( 'dokan_product_edit_after_inventory_variants', $post, $post_id ); ?>
                            </div>

                            <?php if ( $post_id ): ?>
                                <?php do_action( 'dokan_product_edit_after_options', $post_id ); ?>
                            <?php endif; ?>

                            <?php wp_nonce_field( 'dokan_edit_product', 'dokan_edit_product_nonce' ); ?>


                            <!--hidden input for Firefox issue-->
                            <input type="hidden" name="dokan_update_product" value="<?php esc_attr_e( 'Save Product', 'dokan-lite' ); ?>"/>

                            <?php // change margin ?>
                            <div class="mt-6">
                                <input type="submit" name="dokan_update_product" class="dokan-btn dokan-btn-theme dokan-btn-lg dokan-right" value="<?php esc_attr_e( 'Save Product', 'dokan-lite' ); ?>"/>
                            </div>
                            <div class="dokan-clearfix"></div>
                        </form>
                    <?php } else { ?>
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
