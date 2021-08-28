<div class='grid grid-cols-6 gap-6 form-group user-role vendor-customer-registration'>
    <label class="col-span-6 sm:col-span-3 rounded relative border p-4 flex cursor-pointer focus:outline-none">
        <input type="radio" name="role" value="customer"<?php checked( $role, 'customer' ); ?> class="h-4 w-4 mt-0.5 cursor-pointer text-black border-gray-300 focus:ring-gray-500">
        <span class="ml-3 block font-medium"><?php esc_html_e( 'I am a customer', 'dokan-lite' ); ?></span>
    </label>

    <label class="col-span-6 sm:col-span-3 rounded relative border p-4 flex cursor-pointer focus:outline-none">
        <input type="radio" name="role" value="seller"<?php checked( $role, 'seller' ); ?> class="h-4 w-4 mt-0.5 cursor-pointer text-black border-gray-300 focus:ring-gray-500">
        <span class="ml-3 block font-medium"><?php esc_html_e( 'I am a vendor', 'dokan-lite' ); ?></span>
    </label>
    <?php do_action( 'dokan_registration_form_role', $role ); ?>
</div>


<div class="show_if_seller" style="<?php echo esc_attr( $role_style ); ?>">
    <div class="grid grid-cols-6 gap-6 mb-2">
        <p class="col-span-6 sm:col-span-3">
            <label for="first-name" class="block text-sm font-medium text-gray-700 mb-2"><?php esc_html_e( 'First Name', 'dokan-lite' ); ?> <span class="required text-red-500">*</span></label>
            <input type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="fname" id="first-name" value="<?php if ( ! empty( $postdata['fname'] ) ) { echo esc_attr( $postdata['fname'] ); } ?>" required="required" />
        </p>

        <p class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block text-sm font-medium text-gray-700 mb-2"><?php esc_html_e( 'Last Name', 'dokan-lite' ); ?> <span class="required text-red-500">*</span></label>
            <input type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="lname" id="last-name" value="<?php if ( ! empty( $postdata['lname'] ) ) { echo esc_attr( $postdata['lname'] ); } ?>" required="required" />
        </p>
    </div>

    <p class="form-row form-group form-row-wide">
        <label for="company-name" class="block text-sm font-medium text-gray-700 mb-2"><?php esc_html_e( 'Shop Name', 'dokan-lite' ); ?> <span class="required">*</span></label>
        <input type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="shopname" id="company-name" value="<?php if ( ! empty( $postdata['shopname'] ) ) { echo esc_attr( $postdata['shopname'] ); } ?>" required="required" />
    </p>

    <p class="form-row form-group form-row-wide">
        <label for="seller-url" class="pull-left block text-sm font-medium text-gray-700 mb-2"><?php esc_html_e( 'Shop URL', 'dokan-lite' ); ?> <span class="required">*</span></label>
        <strong id="url-alart-mgs" class="pull-right"></strong>
        <input type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="shopurl" id="seller-url" value="<?php if ( ! empty( $postdata['shopurl'] ) ) { echo esc_attr( $postdata['shopurl'] ); } ?>" required="required" />
        <small><?php echo esc_url( home_url() . '/' . dokan_get_option( 'custom_store_url', 'dokan_general', 'store' ) ); ?>/<strong id="url-alart"></strong></small>
    </p>

    <?php
    /**
     * @since 3.2.8
     */
    do_action( 'dokan_seller_registration_after_shopurl_field', ! empty( $postdata ) ? $postdata : [] );
    ?>

    <p class="form-row form-group form-row-wide">
        <label for="shop-phone" class="block text-sm font-medium text-gray-700 mb-2"><?php esc_html_e( 'Phone Number', 'dokan-lite' ); ?><span class="required"> *</span></label>
        <input type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="phone" id="shop-phone" value="<?php if ( ! empty( $postdata['phone'] ) ) { echo esc_attr( $postdata['phone'] ); } ?>" required="required" />
    </p>

    <?php
    $show_terms_condition = dokan_get_option( 'enable_tc_on_reg', 'dokan_general' );
    $terms_condition_url  = dokan_get_terms_condition_url();

    if ( 'on' === $show_terms_condition && $terms_condition_url ) { ?>
        <p class="form-row form-group form-row-wide mb-4">
            <input class="focus:ring-black h-4 w-4 text-indigo-600 border-gray-300 rounded" type="checkbox" id="tc_agree" name="tc_agree" required="required">
            <label style="display: inline" for="tc_agree" class="font-medium text-gray-700 text-sm"><?php echo wp_kses_post( sprintf( __( 'I have read and agree to the <a target="_blank" href="%s">Terms &amp; Conditions</a>.', 'dokan-lite' ), esc_url( $terms_condition_url ) ) ); ?></label>
        </p>
    <?php }

    do_action( 'dokan_seller_registration_field_after' );
    ?>
</div>

<?php do_action( 'dokan_reg_form_field' ); ?>

