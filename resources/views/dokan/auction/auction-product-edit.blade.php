<?php
// overwrites: dokan-pro/modules/simple-auction/templates/auction/auction-product-edit.php
// version:  3.3.3

use WeDevs\Dokan\Walkers\TaxonomyDropdown;

global $post, $product;

$post_id = $post->ID;
$seller_id = dokan_get_current_user_id();

if (isset($_GET['product_id'])) {
    $post_id = intval($_GET['product_id']);
    $post = get_post($post_id);
    $post_status = $post->post_status;
    $product = dokan_wc_get_product($post_id);
}

// bail out if not author
if ($post->post_author != $seller_id) {
    wp_die(__('Access Denied', 'dokan'));
}

$_regular_price = get_post_meta($post_id, '_regular_price', true);
$_featured = get_post_meta($post_id, '_featured', true);
$_stock = get_post_meta($post_id, '_stock', true);
$_auction_item_condition = get_post_meta($post_id, '_auction_item_condition', true);
$_auction_type = get_post_meta($post_id, '_auction_type', true);

$_auction_proxy = get_post_meta($post_id, '_auction_proxy', true);
$_auction_sealed = get_post_meta($post_id, '_auction_sealed', true);
$_auction_start_price = get_post_meta($post_id, '_auction_start_price', true);
$_auction_bid_increment = get_post_meta($post_id, '_auction_bid_increment', true);
$_auction_reserved_price = get_post_meta($post_id, '_auction_reserved_price', true);
$_auction_dates_from = get_post_meta($post_id, '_auction_dates_from', true);
$_auction_dates_to = get_post_meta($post_id, '_auction_dates_to', true);

$_auction_automatic_relist = get_post_meta($post_id, '_auction_automatic_relist', true);
$_auction_relist_fail_time = get_post_meta($post_id, '_auction_relist_fail_time', true);
$_auction_relist_not_paid_time = get_post_meta($post_id, '_auction_relist_not_paid_time', true);
$_auction_relist_duration = get_post_meta($post_id, '_auction_relist_duration', true);
$_visibility = (version_compare(WC_VERSION, '2.7', '>')) ? $product->get_catalog_visibility() : get_post_meta($post_id, '_visibility', true);
$visibility_options = dokan_get_product_visibility_options();
?>

<?php do_action('dokan_dashboard_wrap_start'); ?>

<div class="dokan-dashboard-wrap">
    <?php
    do_action('dokan_dashboard_content_before');
    do_action('dokan_edit_auction_product_content_before');
    ?>
    <!--  -->
    <div class="dokan-dashboard-content dokan-product-edit">
        <?php

        /**
         *  dokan_edit_auction_product_content_inside_before hook
         *
         * @since 2.4
         */
        do_action('dokan_edit_auction_product_content_inside_before');
        ?>
        <header class="dokan-dashboard-header dokan-clearfix">
            <h1 class="entry-title">
                <?php _e('Edit Auction Products', 'dokan'); ?>
                <span class="dokan-label <?php echo dokan_get_post_status_label_class($post->post_status); ?> dokan-product-status-label">
                <?php echo dokan_get_post_status($post->post_status); ?>
            </span>

                <?php if ($_visibility == 'hidden') { ?>
                    <span class="dokan-label dokan-label-default"><?php _e('hidden', 'dokan'); ?></span>
                <?php } ?>

                <?php if ($post->post_status == 'publish') { ?>
                    <span class="dokan-right">
                <a class="view-product dokan-btn dokan-btn-sm" href="<?php echo get_permalink($post->ID); ?>"
                   target="_blank"><?php _e('View Product', 'dokan'); ?></a>
            </span>
                <?php } ?>
            </h1>
        </header>

        <div class="dokan-new-product-area">
            <?php wc_print_notices(); ?>
            <?php if (isset($_GET['message']) && $_GET['message'] == 'success') { ?>
                <div class="dokan-message">
                    <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
                    <strong><?php _e('Success!', 'dokan'); ?></strong> <?php _e('The product has been updated successfully.', 'dokan'); ?>

                    <?php if ($post->post_status == 'publish') { ?>
                        <a href="<?php echo get_permalink($post_id); ?>"
                           target="_blank"><?php _e('View Product &rarr;', 'dokan'); ?></a>
                    <?php } ?>
                </div>
            <?php } ?>

            <form class="dokan-form-container dokan-auction-product-form" role="form" method="post">
                <?php wp_nonce_field('dokan_edit_auction_product', 'dokan_edit_auction_product_nonce'); ?>
                <div class="product-edit-container dokan-clearfix">

                    <div id="edit-product">

                        <?php do_action('dokan_product_edit_before_main'); ?>

                        <div class="product-edit-container dokan-clearfix">
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
                            </div>
                            <div class="content-half-part dokan-product-meta">

                                <?php // change ?>
                                <div class="">
                                    <?php echo \Roots\view('dokan.product-fields.title', ['post' => $post])->render(); ?>
                                </div>

                                <?php // change ?>
                                <div class="mt-6">
                                    <?php if (empty($post->post_excerpt)): ?>
                                        <?php echo \Roots\view('dokan.product-fields.description', ['post' => $post])->render(); ?>
                                    <?php else: ?>
                                        <?php echo \Roots\view('dokan.product-fields.excerpt', ['post' => $post])->render(); ?>
                                    <?php endif; ?>
                                </div>

                                <div class="dokan-form-group dokan-auction-tags hidden">
                                    <label for="product_tag" class="form-label"><?php _e('Tags', 'dokan'); ?></label>
                                    <?php
                                    require_once DOKAN_LIB_DIR . '/class.taxonomy-walker.php';
                                    $term = wp_get_post_terms($post_id, 'product_tag', array('fields' => 'ids'));
                                    $selected = ($term) ? $term : array();
                                    $drop_down_tags = wp_dropdown_categories(array(
                                        'show_option_none' => __('', 'dokan'),
                                        'hierarchical' => 1,
                                        'hide_empty' => 0,
                                        'name' => 'product_tag[]',
                                        'id' => 'product_tag',
                                        'taxonomy' => 'product_tag',
                                        'title_li' => '',
                                        'class' => 'product_tags dokan-form-control dokan-select2',
                                        'exclude' => '',
                                        'selected' => $selected,
                                        'echo' => 0,
                                        'walker' => new TaxonomyDropdown($post_id)
                                    ));

                                    echo str_replace('<select', '<select data-placeholder="' . __('Select product tags', 'dokan') . '" multiple="multiple" ', $drop_down_tags);

                                    ?>
                                </div>
                                <?php do_action('dokan_auction_before_general_options', $post_id); ?>
                            </div>
                        </div>

                        <?php // change ?>
                        <div class="md:flex w-full md:space-x-6 bg-white p-4 mt-6">
                            <div class="flex-1 flex-col space-y-6">
                                <?php echo \Roots\view('dokan.product-fields.category-subcategory-size', ['post' => $post])->render(); ?>
                                <?php echo \Roots\view('dokan.product-fields.color', ['post' => $post])->render(); ?>
                            </div>
                            <div class="flex-1 flex-col space-y-6">
                                <?php echo \Roots\view('dokan.product-fields.tag-type', ['post' => $post])->render(); ?>
                                <?php echo \Roots\view('dokan.product-fields.pit-to-pit', ['post' => $post])->render(); ?>
                                <?php echo \Roots\view('dokan.product-fields.length', ['post' => $post])->render(); ?>
                                <?php echo \Roots\view('dokan.product-fields.stitching', ['post' => $post])->render(); ?>
                            </div>
                        </div>

                        <?php if (!empty($post->post_excerpt)): ?>
                            <div class="mt-6">
                                <?php echo \Roots\view('dokan.product-fields.description', ['post' => $post])->render(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="product-edit-new-container">
                            <div class="dokan-edit-row dokan-auction-general-sections dokan-clearfix">

                                <?php // change: remove heading ?>

                                <div class="dokan-section-content">
                                    <div class="content-half-part dokan-auction-item-condition">
                                        <div class="dokan-form-group">
                                            <label class="dokan-control-label"
                                                   for="_auction_item_condition"><?php _e('Item condition', 'dokan'); ?></label>
                                            <div class="dokan-form-group">
                                                <select required required name="_auction_item_condition"
                                                        class="dokan-form-control" id="_auction_item_condition">
                                                    <option value="new" <?php echo ($_auction_item_condition == 'new') ? 'selected' : '' ?>><?php _e('New', 'dokan') ?></option>
                                                    <option value="used" <?php echo ($_auction_item_condition == 'used') ? 'selected' : '' ?>><?php _e('Used', 'dokan') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <?php // change ?>
                                    <div class="content-half-part dokan-auction-type hidden">
                                        <div class="dokan-form-group">
                                            <label class="dokan-control-label"
                                                   for="_auction_type"><?php _e('Auction type', 'dokan'); ?></label>
                                            <div class="dokan-form-group">
                                                <select name="_auction_type" class="dokan-form-control"
                                                        id="_auction_type">
                                                    <option value="normal" <?php echo ($_auction_type == 'normal') ? 'selected' : '' ?>><?php _e('Normal', 'dokan') ?></option>
                                                    <option value="reverse" <?php echo ($_auction_type == 'reverse') ? 'selected' : '' ?>><?php _e('Reverse', 'dokan') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dokan-clearfix"></div>

                                    <?php // change ?>
                                    <div class="dokan-form-group dokan-auction-proxy-bid hidden">
                                        <div class="checkbox">
                                            <label for="_auction_proxy">
                                                <input type="checkbox" name="_auction_proxy" value="yes"
                                                       id="_auction_proxy" <?php checked($_auction_proxy, 'yes'); ?>>
                                                <?php _e('Enable proxy bidding for this auction product', 'dokan'); ?>
                                            </label>
                                        </div>
                                    </div>

                                    <?php if (get_option('simple_auctions_sealed_on', 'no') == 'yes') : ?>
                                        <div class="dokan-form-group dokan-auction-sealed-bid">
                                            <div class="checkbox">
                                                <label for="_auction_sealed">
                                                    <input type="checkbox" name="_auction_sealed" value="yes"
                                                           id="_auction_sealed" <?php checked($_auction_sealed, 'yes'); ?>>
                                                    <?php _e('Enable sealed bidding for this auction product', 'dokan'); ?>
                                                    <i class="fa fa-question-circle tips"
                                                       data-title="<?php _e('In this type of auction all bidders simultaneously submit sealed bids so that no bidder knows the bid of any other participant. The highest bidder pays the price they submitted. If two bids with same value are placed for auction the one which was placed first wins the auction.', 'dokan'); ?>"></i>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="content-half-part dokan-auction-start-price">
                                        <div class="dokan-form-group">
                                            <label class="dokan-control-label form-label"
                                                   for="_auction_start_price"><?php _e('Start Price', 'dokan'); ?></label>
                                            <div class="dokan-form-group">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                                    <input required class="wc_input_price dokan-form-control"
                                                           name="_auction_start_price" id="_auction_start_price"
                                                           type="text"
                                                           placeholder="<?php echo wc_format_localized_price('9.99'); ?>"
                                                           value="<?php echo wc_format_localized_price($_auction_start_price); ?>"
                                                           style="width: 97%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-half-part dokan-auction-bid-increment">
                                        <div class="dokan-form-group">
                                            <label class="dokan-control-label form-label"
                                                   for="_auction_bid_increment"><?php _e('Bid increment', 'dokan'); ?></label>
                                            <div class="dokan-form-group">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                                    <input required class="wc_input_price dokan-form-control"
                                                           name="_auction_bid_increment" id="_auction_bid_increment"
                                                           type="text"
                                                           placeholder="<?php echo wc_format_localized_price('9.99') ?>"
                                                           value="<?php echo wc_format_localized_price($_auction_bid_increment); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dokan-clearfix"></div>

                                    <?php // change ?>
                                    <div class="content-half-part dokan-auction-reserved-price hidden">
                                        <div class="dokan-form-group">
                                            <label class="dokan-control-label"
                                                   for="_auction_reserved_price"><?php _e('Reserved price', 'dokan'); ?></label>
                                            <div class="dokan-form-group">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                                    <input class="wc_input_price dokan-form-control"
                                                           name="_auction_reserved_price" id="_auction_reserved_price"
                                                           type="text"
                                                           placeholder="<?php echo wc_format_localized_price('9.99'); ?>"
                                                           value="<?php echo wc_format_localized_price($_auction_reserved_price); ?>"
                                                           style="width: 97%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php // change ?>
                                    <div class="content-half-part dokan-auction-regular-price hidden">
                                        <label class="dokan-control-label"
                                               for="_regular_price"><?php _e('Buy it now price', 'dokan'); ?></label>
                                        <div class="dokan-form-group">
                                            <div class="dokan-input-group">
                                                <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                                <input class="wc_input_price dokan-form-control" name="_regular_price"
                                                       id="_regular_price" type="text"
                                                       placeholder="<?php echo wc_format_localized_price('9.99') ?>"
                                                       value="<?php echo wc_format_localized_price($_regular_price); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dokan-auction-date">
                                        <div class="content-half-part dokan-auction-dates-from">
                                            <label class="dokan-control-label"
                                                   for="_auction_dates_from"><?php _e('Auction Start date', 'dokan'); ?></label>
                                            <div class="dokan-form-group">
                                                <input required class="dokan-form-control auction-datepicker"
                                                       name="_auction_dates_from" id="_auction_dates_from" type="text"
                                                       value="<?php echo $_auction_dates_from; ?>" style="width: 97%;"
                                                       readonly>
                                            </div>
                                        </div>

                                        <div class="content-half-part dokan-auction-dates-to">
                                            <label class="dokan-control-label"
                                                   for="_auction_dates_to"><?php _e('Auction End date', 'dokan'); ?></label>
                                            <div class="dokan-form-group">
                                                <input required class="dokan-form-control auction-datepicker"
                                                       name="_auction_dates_to" id="_auction_dates_to" type="text"
                                                       value="<?php echo $_auction_dates_to; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <?php // change: removed relisting options, have duplicate fields like: _auction_dates_from ?>

                                </div>
                            </div>

                            <?php // change do_action( 'dokan_auction_after_general_options', $post_id ); ?>


                            <?php // change ?>
                            <div class="dokan-edit-row dokan-auction-other-sections dokan-clearfix hidden">
                                <div class="dokan-section-heading" data-togglehandler="dokan_other_options">
                                    <h2><i class="fa fa-cog"
                                           aria-hidden="true"></i> <?php _e('Other Options', 'dokan'); ?></h2>
                                    <p><?php _e('Set your extra product options', 'dokan'); ?></p>
                                    <div class="dokan-clearfix"></div>
                                </div>

                                <div class="dokan-section-content">
                                    <div class="dokan-form-group content-half-part dokan-auction-product-status">
                                        <label for="post_status"
                                               class="form-label"><?php _e('Product Status', 'dokan'); ?></label>
                                        <?php if ($post_status != 'pending') { ?>
                                            <?php $post_statuses = apply_filters('dokan_post_status', array(
                                                'publish' => __('Online', 'dokan'),
                                                'draft' => __('Draft', 'dokan')
                                            ), $post); ?>

                                            <select id="post_status" class="dokan-form-control" name="post_status">
                                                <?php foreach ($post_statuses as $status => $label) { ?>
                                                    <option value="<?php echo $status; ?>"<?php selected($post_status, $status); ?>><?php echo $label; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <?php $pending_class = $post_status == 'pending' ? '  dokan-label dokan-label-warning' : ''; ?>
                                            <span class="dokan-toggle-selected-display<?php echo $pending_class; ?>"><?php echo dokan_get_post_status($post_status); ?></span>
                                        <?php } ?>
                                    </div>

                                    <div class="dokan-form-group content-half-part dokan-auction-product-visibility">
                                        <label for="_visibility"
                                               class="form-label"><?php _e('Visibility', 'dokan'); ?></label>
                                        <select name="_visibility" id="_visibility" class="dokan-form-control">
                                            <?php foreach ($visibility_options as $name => $label): ?>
                                                <option value="<?php echo $name; ?>" <?php selected($_visibility, $name); ?>><?php echo $label; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>

                                </div>
                            </div><!-- .dokan-other-options -->

                            <?php // change: fields like sku required, hide ?>
                            <div class="hidden">
                                <?php do_action('dokan_product_edit_after_main', $post, $post_id); ?>
                            </div>
                        </div>


                        <input type="hidden" name="dokan_product_id" id="dokan-edit-product-id"
                               value="<?php echo $post_id; ?>"/>
                        <input type="hidden" name="product-type" value="auction">
                        <input type="submit" name="update_auction_product"
                               class="dokan-btn dokan-btn-theme dokan-btn-lg dokan-right"
                               value="<?php esc_attr_e('Update Product', 'dokan'); ?>"/>

                        <div class="dokan-clearfix"></div>
                    </div>
                </div>
            </form>

        </div>
        <?php

        /**
         *  dokan_edit_auction_product_inside_after hook
         *
         * @since 2.4
         */
        do_action('dokan_edit_auction_product_inside_after');
        ?>
    </div>

    <?php
    /**
     *  dokan_dashboard_content_after hook
     *  dokan_withdraw_content_after hook
     *
     * @since 2.4
     */
    do_action('dokan_dashboard_content_after');
    do_action('dokan_edit_auction_product_content_after');
    wp_reset_postdata();
    wp_reset_query();
    ?>
</div><!-- .dokan-dashboard-wrap -->

<?php do_action('dokan_dashboard_wrap_end'); ?>

<style>
    .show_if_variable {
        display: none !important;
    }
</style>

<script>
    ;(function ($) {
        $(document).ready(function () {
            $('.auction-datepicker').datetimepicker({
                dateFormat: 'yy-mm-dd',
                currentText: dokan.datepicker.now,
                closeText: dokan.datepicker.done,
                timeText: dokan.datepicker.time,
                hourText: dokan.datepicker.hour,
                minuteText: dokan.datepicker.minute
            });

            if ($('#_auction_automatic_relist').prop('checked')) {
                $('.relist_options').show();
            } else {
                $('.relist_options').hide();
            }

            $('#_auction_automatic_relist').on('change', function () {
                if ($(this).prop('checked')) {
                    $('.relist_options').show();
                } else {
                    $('.relist_options').hide();
                }
            });

            $('.dokan-auction-proxy-bid').on('change', 'input#_auction_proxy', function () {
                if ($(this).prop('checked')) {
                    $('.dokan-auction-sealed-bid').hide();
                } else {
                    $('.dokan-auction-sealed-bid').show();
                }
            });

            $('.dokan-auction-sealed-bid').on('change', 'input#_auction_sealed', function () {
                if ($(this).prop('checked')) {
                    $('.dokan-auction-proxy-bid').hide();
                } else {
                    $('.dokan-auction-proxy-bid').show();
                }
            });
            $('input#_auction_proxy').trigger('change');
            $('input#_auction_sealed').trigger('change');

            $('.dokan-auction-relist-button').on('click', function (e) {
                e.preventDefault();

                $('.dokan-auction-date-relist').show();
                $(".dokan-auction-date").find('input').removeAttr('name');
                $(this).hide();
            });
        });
    })(jQuery)

</script>
