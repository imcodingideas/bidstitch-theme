<?php

// extends: dokan-lite/templates/products/new-product.php
// version: dokan lite 3.2.9

use WeDevs\Dokan\Walkers\TaxonomyDropdown;

    $get_data  = wp_unslash( $_GET ); // WPCS: CSRF ok.
    $post_data = wp_unslash( $_POST ); // WPCS: CSRF ok.

    /**
     *  dokan_new_product_wrap_before hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_new_product_wrap_before' );
?>

<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

    <div class="dokan-dashboard-wrap">

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *  dokan_before_new_product_content_area hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_before' );
            do_action( 'dokan_before_new_product_content_area' );
        ?>


        <div class="dokan-dashboard-content">

            <?php

                /**
                 *  dokan_before_new_product_inside_content_area hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_before_new_product_inside_content_area' );
            ?>

            <header class="dokan-dashboard-header dokan-clearfix">
                <h1 class="entry-title">
                    <?php esc_html_e( 'Add New Product', 'dokan-lite' ); ?>
                </h1>
            </header><!-- .entry-header -->


            <div class="dokan-new-product-area">
                <?php if ( dokan()->dashboard->templates->products->has_errors() ) { ?>
                    <div class="dokan-alert dokan-alert-danger">
                        <a class="dokan-close" data-dismiss="alert">&times;</a>

                        <?php foreach ( dokan()->dashboard->templates->products->get_errors() as $error) { ?>

                            <strong><?php esc_html_e( 'Error!', 'dokan-lite' ); ?></strong> <?php echo esc_html( $error ); ?>.<br>

                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ( isset( $get_data['created_product'] ) ): ?>
                    <div class="dokan-alert dokan-alert-success">
                        <a class="dokan-close" data-dismiss="alert">&times;</a>
                        <strong><?php esc_html_e( 'Success!', 'dokan-lite' ); ?></strong>
                        <?php printf( __( 'You have successfully created <a href="%s"><strong>%s</strong></a> product', 'dokan-lite' ), esc_url( dokan_edit_product_url( intval( $get_data['created_product'] ) ) ), get_the_title( intval( $get_data['created_product'] ) ) ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php endif ?>

                <?php

                $can_sell         = apply_filters( 'dokan_can_post', true );
                $can_create_tags  = dokan_get_option( 'product_vendors_can_create_tags', 'dokan_selling' );
                $tags_placeholder = 'on' === $can_create_tags ? __( 'Select tags/Add tags', 'dokan-lite' ) : __( 'Select product tags', 'dokan-lite' );

                if ( $can_sell ) {
                    $posted_img       = dokan_posted_input( 'feat_image_id' );
                    $posted_img_url   = $hide_instruction = '';
                    $hide_img_wrap    = 'dokan-hide';
                    $post_content     = isset( $post_data['post_content'] ) ? $post_data['post_content'] : '';

                    if ( !empty( $posted_img ) ) {
                        $posted_img     = empty( $posted_img ) ? 0 : $posted_img;
                        $posted_img_url = wp_get_attachment_url( $posted_img );
                        $hide_instruction = 'dokan-hide';
                        $hide_img_wrap = '';
                    }
                    if ( dokan_is_seller_enabled( get_current_user_id() ) ) { ?>

                        <form class="dokan-form-container" method="post">

                            <div class="product-edit-container dokan-clearfix">
                                <div class="content-half-part featured-image">
                                    <div class="grid">
                                        @php
                                            $featured_image_urls = (!empty($posted_img_url)) ? [$posted_img_url] : [];

                                            $gallery = [];
                                            if ( isset( $post_data['product_image_gallery'] ) ) {
                                                $product_images = $post_data['product_image_gallery']; // WPCS: CSRF ok, input var ok.
                                                $gallery = explode( ',', $product_images );
                                            }
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
                                </div>

                                <div class="content-half-part dokan-product-meta">

                                <?php // change ?>
                                <div class="">
                                    <?php echo \Roots\view('dokan.product-fields.title', [ 'post'=>null ])->render(); ?>
                                </div>

                                <?php // change ?>
                                <div class="mt-6">
                                    <?php echo \Roots\view('dokan.product-fields.excerpt', [ 'post'=>null ])->render(); ?>
                                </div>

                                <?php // change ?>
                                <div class="mt-6">
                                    <?php echo \Roots\view('dokan.product-fields.condition', [ 'post'=>null ])->render(); ?>
                                </div>

                                <?php // change ?>
                                    <div class="dokan-form-group mt-6">
                                        <div class="dokan-form-group dokan-clearfix dokan-price-container">
                                            <div class="">
                                                <label for="_regular_price" class="dokan-form-label form-label"><?php esc_html_e( 'Price', 'dokan-lite' ); ?></label>
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo esc_attr__( get_woocommerce_currency_symbol() ); ?></span>
                                                    <input required type="text" class="dokan-form-control wc_input_price dokan-product-regular-price" name="_regular_price" placeholder="0.00" id="_regular_price" value="<?php echo esc_attr( dokan_posted_input( '_regular_price' ) ) ?>">
                                                </div>
                                            </div>

                                            <div class="content-half-part sale-price hidden">
                                                <label for="_sale_price" class="form-label">
                                                    <?php esc_html_e( 'Discounted Price', 'dokan-lite' ); ?>
                                                    <a href="#" class="sale_schedule"><?php esc_html_e( 'Schedule', 'dokan-lite' ); ?></a>
                                                    <a href="#" class="cancel_sale_schedule dokan-hide"><?php esc_html_e( 'Cancel', 'dokan-lite' ); ?></a>
                                                </label>

                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo esc_attr__( get_woocommerce_currency_symbol() ); ?></span>
                                                    <input type="text" class="dokan-form-control wc_input_price dokan-product-sales-price" name="_sale_price" placeholder="0.00" id="_sale_price" value="<?php echo esc_attr( dokan_posted_input( '_sale_price' ) ) ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dokan-hide sale-schedule-container sale_price_dates_fields dokan-clearfix dokan-form-group">
                                            <div class="content-half-part from">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php esc_html_e( 'From', 'dokan-lite' ); ?></span>
                                                    <input type="text" name="_sale_price_dates_from" class="dokan-form-control datepicker sale_price_dates_from" maxlength="10" value="<?php echo esc_attr( dokan_posted_input('_sale_price_dates_from') ); ?>" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php esc_attr_e( 'YYYY-MM-DD', 'dokan-lite' ); ?>">
                                                </div>
                                            </div>

                                            <div class="content-half-part to">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php esc_html_e( 'To', 'dokan-lite' ); ?></span>
                                                    <input type="text" name="_sale_price_dates_to" class="dokan-form-control datepicker sale_price_dates_to" value="<?php echo esc_attr( dokan_posted_input('_sale_price_dates_to') ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php esc_attr_e( 'YYYY-MM-DD', 'dokan-lite' ); ?>">
                                                </div>
                                            </div>
                                        </div><!-- .sale-schedule-container -->
                                    </div>

                                    <div class="dokan-form-group hidden">
                                        <label for="product_tag" class="form-label"><?php esc_html_e( 'Tags', 'dokan-lite' ); ?></label>
                                        <select multiple="multiple" placeholder="<?php echo esc_attr( $tags_placeholder ); ?>" name="product_tag[]" id="product_tag_search" class="product_tag_search product_tags dokan-form-control dokan-select2" data-placeholder="<?php echo esc_attr( $tags_placeholder ); ?>"></select>
                                    </div>

                                    <?php do_action( 'dokan_new_product_after_product_tags' ); ?>
                                </div>
                            </div>

                            <?php // change ?>
                            <div class="md:flex w-full md:space-x-6 bg-white p-4 mt-6">
                                <div class="flex-1 flex-col space-y-6">
                                    <?php echo \Roots\view('dokan.product-fields.category-subcategory-size', [ 'post'=>null ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.color', [ 'post'=>null ])->render(); ?>
                                </div>
                                <div class="flex-1 flex-col space-y-6">
                                    <?php echo \Roots\view('dokan.product-fields.pit-to-pit', [ 'post'=>null ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.tag-type', [ 'post'=>null ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.length', [ 'post'=>null ])->render(); ?>
                                    <?php echo \Roots\view('dokan.product-fields.stitching', [ 'post'=>null ])->render(); ?>
                                </div>
                            </div>

                            <?php // change ?>
                            <div class="mt-6">
                                <?php echo \Roots\view('dokan.product-fields.description', ['post'=>null])->render(); ?>
                            </div>

                            <?php do_action( 'dokan_new_product_form' ); ?>

                            <hr>

                            <div class="dokan-form-group dokan-right mt-6">
                                <?php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ); ?>
                                <?php
                                $display_create_and_add_new_button = true;
                                if ( function_exists( 'dokan_pro' ) && dokan_pro()->module->is_active( 'product_subscription' ) ) {
                                    if ( \DokanPro\Modules\Subscription\Helper::get_vendor_remaining_products( dokan_get_current_user_id() ) === 1 ) {
                                        $display_create_and_add_new_button = false;
                                    }
                                }
                                if ( $display_create_and_add_new_button ) :
                                ?>
                                <button type="submit" name="add_product" class="dokan-btn dokan-btn-default" value="create_and_add_new"><?php esc_attr_e( 'Create & Add New', 'dokan-lite' ); ?></button>
                                <?php endif; ?>
                                <button type="submit" name="add_product" class="dokan-btn dokan-btn-default dokan-btn-theme" value="create_new"><?php esc_attr_e( 'Create Product', 'dokan-lite' ); ?></button>
                            </div>

                        </form>

                    <?php } else { ?>

                        <?php dokan_seller_not_enabled_notice(); ?>

                    <?php } ?>

                <?php } else { ?>

                    <?php do_action( 'dokan_can_post_notice' ); ?>

                <?php } ?>
            </div>

            <?php

                /**
                 *  dokan_after_new_product_inside_content_area hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_after_new_product_inside_content_area' );
            ?>

        </div> <!-- #primary .content-area -->

        <?php

            /**
             *  dokan_dashboard_content_after hook
             *  dokan_after_new_product_content_area hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_after' );
            do_action( 'dokan_after_new_product_content_area' );
        ?>

    </div><!-- .dokan-dashboard-wrap -->

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>

<?php

    /**
     *  dokan_new_product_wrap_after hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_new_product_wrap_after' );
?>
