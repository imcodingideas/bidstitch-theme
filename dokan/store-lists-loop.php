<div id="dokan-seller-listing-wrap" class="grid-view">
    <div class="seller-listing-content my-8">
        <?php if ( $sellers['users'] ) : ?>
            <ul class="mx-auto grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4 md:gap-x-6 lg:gap-x-8 lg:gap-y-12 xl:grid-cols-6">
                <?php
                foreach ( $sellers['users'] as $seller ) {
                    $vendor            = dokan()->vendor->get( $seller->ID );
                    $store_banner_id   = $vendor->get_banner_id();
                    $store_name        = $vendor->get_shop_name();
                    $store_url         = $vendor->get_shop_url();
                    $store_rating      = $vendor->get_rating();
                    $is_store_featured = $vendor->is_featured();
                    $store_phone       = $vendor->get_phone();
                    $store_info        = dokan_get_store_info( $seller->ID );
                    $store_address     = dokan_get_seller_short_address( $seller->ID );
                    $store_banner_url  = $store_banner_id ? wp_get_attachment_image_src( $store_banner_id, $image_size ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';
                    
                    $show_store_open_close    = dokan_get_option( 'store_open_close', 'dokan_appearance', 'on' );
                    $dokan_store_time_enabled = isset( $store_info['dokan_store_time_enabled'] ) ? $store_info['dokan_store_time_enabled'] : '';
                    $store_open_is_on = ( 'on' === $show_store_open_close && 'yes' === $dokan_store_time_enabled && ! $is_store_featured ) ? 'store_open_is_on' : '';
                    ?>
                    <li>
                        <div class="space-y-4 text-center">
                            <a href="<?php echo esc_url( $store_url ); ?>">
                                <img src="<?php echo esc_url( $vendor->get_avatar() ) ?>"
                                        alt="<?php echo esc_attr( $vendor->get_shop_name() ) ?>" class="mx-auto h-20 w-20 rounded-full lg:w-24 lg:h-24">
                            </a>
                            <div class="space-y-2">
                            <div class="text-xs font-medium lg:text-sm">
                                <a href="<?php echo esc_url( $store_url ); ?>">
                                    <h3 class="capitalize"><?php echo esc_attr( $vendor->get_shop_name() ) ?></h3>
                                </a>
                            </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
                <div class="dokan-clearfix"></div>
            </ul> <!-- .dokan-seller-wrap -->

            <?php
            $user_count   = $sellers['count'];
            $num_of_pages = ceil( $user_count / $limit );

            if ( $num_of_pages > 1 ) {
                echo '<div class="pagination-container clearfix mt-8">';

                $pagination_args = array(
                    'current'   => $paged,
                    'total'     => $num_of_pages,
                    'base'      => $pagination_base,
                    'type'      => 'array',
                    'prev_text' => __( '&larr; Previous', 'dokan-lite' ),
                    'next_text' => __( 'Next &rarr;', 'dokan-lite' ),
                );

                if ( ! empty( $search_query ) ) {
                    $pagination_args['add_args'] = array(
                        'dokan_seller_search' => $search_query,
                    );
                }

                $page_links = paginate_links( $pagination_args );

                if ( $page_links ) {
                    $pagination_links  = '<div class="pagination-wrap text-center">';
                    $pagination_links .= '<ul class="pagination"><li>';
                    $pagination_links .= join( "</li>\n\t<li>", $page_links );
                    $pagination_links .= "</li>\n</ul>\n";
                    $pagination_links .= '</div>';

                    echo $pagination_links; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                }

                echo '</div>';
            }
            ?>

        <?php else:  ?>
            <p class="dokan-error"><?php esc_html_e( 'No vendor found!', 'dokan-lite' ); ?></p>
        <?php endif; ?>
    </div>
</div>
