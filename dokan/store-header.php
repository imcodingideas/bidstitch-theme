<?php
/* TODO: transform to blade */
$store_user               = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info               = $store_user->get_shop_info();
$social_info              = $store_user->get_social_profiles();
$store_tabs               = dokan_get_store_tabs( $store_user->get_id() );
$social_fields            = dokan_get_social_profile_fields();

$dokan_appearance         = get_option( 'dokan_appearance' );
$profile_layout           = empty( $dokan_appearance['store_header_template'] ) ? 'default' : $dokan_appearance['store_header_template'];
$store_address            = dokan_get_seller_short_address( $store_user->get_id(), false );

$dokan_store_time_enabled = isset( $store_info['dokan_store_time_enabled'] ) ? $store_info['dokan_store_time_enabled'] : '';
$store_open_notice        = isset( $store_info['dokan_store_open_notice'] ) && ! empty( $store_info['dokan_store_open_notice'] ) ? $store_info['dokan_store_open_notice'] : __( 'Store Open', 'dokan-lite' );
$store_closed_notice      = isset( $store_info['dokan_store_close_notice'] ) && ! empty( $store_info['dokan_store_close_notice'] ) ? $store_info['dokan_store_close_notice'] : __( 'Store Closed', 'dokan-lite' );
$show_store_open_close    = dokan_get_option( 'store_open_close', 'dokan_appearance', 'on' );

$general_settings         = get_option( 'dokan_general', [] );
$banner_width             = dokan_get_option( 'store_banner_width', 'dokan_appearance', 625 );

if ( ( 'default' === $profile_layout ) || ( 'layout2' === $profile_layout ) ) {
	$profile_img_class = 'profile-img-circle';
} else {
	$profile_img_class = 'profile-img-square';
}

if ( 'layout3' === $profile_layout ) {
	unset( $store_info['banner'] );

	$no_banner_class      = ' profile-frame-no-banner';
	$no_banner_class_tabs = ' dokan-store-tabs-no-banner';

} else {
	$no_banner_class      = '';
	$no_banner_class_tabs = '';
}

$rating = $store_user->get_rating( $store_user->id );
$rating_count = $rating['count'];

//pho
$all_comments = get_comment_all_store($store_user->id);

//pho
$dokan_store_des        = isset( $store_info['vendor_biography'] ) ? $store_info['vendor_biography'] : '';
$store_instagramhandle  = isset( $store_info['instagramhandle'] ) ? $store_info['instagramhandle'] : '';
$store_how_for          = isset( $store_info['how_for'] ) ? $store_info['how_for'] : '';
$store_specialize       = isset( $store_info['specialize'] ) ? $store_info['specialize'] : '';
$store_get_into         = isset( $store_info['get_into'] ) ? $store_info['get_into'] : '';


$vendor_id = $store_user->get_id();
$igverified = get_field("ig_verified", 'user_'. $vendor_id);
$founder = get_field("founder_member", 'user_'. $vendor_id);
$vendor = new WP_User($vendor_id);
$vendor_name = $vendor->display_name;
$address = $store_info['address'];
/* TODO: this gives error $country = $split[count(explode(" ", $address))-1]; */
$countrycode = $address['country'];
$countryname = WC()->countries->countries[$countrycode] ?? $countrycode;
$vendor_profile_link = get_field('user_profile','option');
$vendor_profile_link = !empty($vendor_profile_link) ? $vendor_profile_link.'?id='.$vendor_id : '#';
?>
<div class="dokan-profile-frame-wrapper">
	<div class="profile-frame<?php echo esc_attr( $no_banner_class ); ?>">

		<div class="profile-info-box profile-layout-<?php echo esc_attr( $profile_layout ); ?>">
			<?php if ( $store_user->get_banner() ) { ?>
				<img src="<?php echo esc_url( $store_user->get_banner() ); ?>"
				alt="<?php echo esc_attr( $store_user->get_shop_name() ); ?>"
				title="<?php echo esc_attr( $store_user->get_shop_name() ); ?>"
				class="profile-info-img">
			<?php } ?>

			<div class="profile-info-summery-wrapper dokan-clearfix">
				<div class="row py-12">
					<div class="lg:flex max-w-screen-xl mx-auto profile-info-summery relative row">
						<div class="flex space-x-10">
							<div class="profile-info-head">
								<div class="profile-img <?php echo esc_attr( $profile_img_class ); ?>">
									<img src="<?php echo esc_url( $store_user->get_avatar() ) ?>"
									alt="<?php echo esc_attr( $store_user->get_shop_name() ) ?>"
									size="150">
								</div>
								<?php if ( ! empty( $store_user->get_shop_name() ) && 'default' === $profile_layout ) { ?>
									<h1 class="store-name"><?php echo esc_html( $store_user->get_shop_name() ); ?></h1>
								<?php } ?>
							</div>

							<div class="profile-info flex flex-col space-y-2">
								<?php if ( ! empty( $store_user->get_shop_name() ) && 'default' !== $profile_layout ) { ?>
									<h1 class="store-name"><?php echo esc_html( $store_user->get_shop_name() ); ?> <?php if($founder == "true"){ echo '<svg version="1.1" id="Capa_1" class="userbadges goldfill" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 267.5 267.5" style="enable-background:new 0 0 267.5 267.5;" xml:space="preserve"><path d="M256.975,100.34c0.041,0.736-0.013,1.485-0.198,2.229l-16.5,66c-0.832,3.325-3.812,5.663-7.238,5.681l-99,0.5
	c-0.013,0-0.025,0-0.038,0H35c-3.444,0-6.445-2.346-7.277-5.688l-16.5-66.25c-0.19-0.764-0.245-1.534-0.197-2.289
	C4.643,98.512,0,92.539,0,85.5c0-8.685,7.065-15.75,15.75-15.75S31.5,76.815,31.5,85.5c0,4.891-2.241,9.267-5.75,12.158
	l20.658,20.814c5.221,5.261,12.466,8.277,19.878,8.277c8.764,0,17.12-4.162,22.382-11.135l33.95-44.984
	C119.766,67.78,118,63.842,118,59.5c0-8.685,7.065-15.75,15.75-15.75s15.75,7.065,15.75,15.75c0,4.212-1.672,8.035-4.375,10.864
	c0.009,0.012,0.02,0.022,0.029,0.035l33.704,45.108c5.26,7.04,13.646,11.243,22.435,11.243c7.48,0,14.514-2.913,19.803-8.203
	l20.788-20.788C238.301,94.869,236,90.451,236,85.5c0-8.685,7.065-15.75,15.75-15.75s15.75,7.065,15.75,15.75
	C267.5,92.351,263.095,98.178,256.975,100.34z M238.667,198.25c0-4.142-3.358-7.5-7.5-7.5h-194c-4.142,0-7.5,3.358-7.5,7.5v18
	c0,4.142,3.358,7.5,7.5,7.5h194c4.142,0,7.5-3.358,7.5-7.5V198.25z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>';} if($igverified == "true"){ echo '<svg id="Layer_1" class="userbadges" enable-background="new 0 0 511.375 511.375" height="512" viewBox="0 0 511.375 511.375" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m511.375 255.687-57.89-64.273 9.064-86.045-84.65-17.921-43.18-75.011-79.031 35.32-79.031-35.32-43.18 75.011-84.65 17.921 9.063 86.045-57.89 64.273 57.889 64.273-9.063 86.045 84.65 17.921 43.18 75.011 79.031-35.321 79.031 35.321 43.18-75.011 84.65-17.921-9.064-86.045zm-148.497-55.985-128.345 143.792-89.186-89.186 21.213-21.213 66.734 66.734 107.203-120.104z"/></g></svg>';}?></h1>
									<p class="vendorshophandle"> <a href="<?php echo $vendor_profile_link; ?>"><?php echo $vendor_name; ?></a></p>
								<?php } ?>
								<div class="dokan-store-rating mb-show dokan-store-rating-mb ml-6">
									<?php echo wp_kses_post( dokan_get_store_rating( $store_user->get_id() ) ); ?>
								</div>
								<div class="hidden items-center md:flex space-x-4">
									<p>
									<button data-store_id="1" class="btn btn--white dokan-store-support-btn flex items-center px-8 py-2 space-x-3 uppercase user_logged">
										<span class="fab fa-telegram-plane"></span>
										<span class="">Send Message</span>
									</button>
									</p>
									<?php 
									if (is_user_logged_in()){
										$customer_id = get_current_user_id();
										$status = null;

										$btn_labels = dokan_follow_store_button_labels();

										if ( dokan_follow_store_is_following_store( $vendor_id, $customer_id ) ) {
											$label_current = $btn_labels['following'];
											$status = 'following';
										} else {
											$label_current = $btn_labels['follow'];
										}

										$args_btn_follow = array(
											'label_current'  => $label_current,
											'label_unfollow' => $btn_labels['unfollow'],
											'vendor_id'      => $vendor_id,
											'status'         => $status,
											'button_classes' => 'btn btn--white px-8 py-2 uppercase dokan-follow-store-button vender_action_btn',
											'is_logged_in'   => $customer_id,
										);
										dokan_follow_store_get_template( 'follow-button', $args_btn_follow );
									}else{ ?>
										<p><a href="<?php echo home_url('/log-in'); ?>" class="login_btn vender_action_btn" ><i class="far fa-heart"></i></a></p>
									<?php	} ?>
								</div>
								<div class="dokan-store-des">
									<?php echo $dokan_store_des; ?>
								</div>
								
								<?php if($countryname): ?>
									<div class="dokan-store-address">
										<p class="dokan-store-address-label"><?php echo _e('Location','flatsome-child'); ?></p>
										<p class="dokan-store-address-info"></i>
											<?php // TOOD: this gives error: echo $country; ?>
											<?php echo $countryname; ?>
										</p>
									</div>                                   
								<?php endif ?>
								
							</div> <!-- .profile-info -->
						</div><!-- profile-info-summery-left -->
						<div class="profile-info-summery-right large-6 medium-12 small-12">
							<?php
							if ( isset( $store_how_for ) && !empty( $store_how_for ) ) { ?>
								<div class="dokan-store-custom-field">
									<p class="dokan-store-custom-field-label"><?php echo _e('HOW LONG HAVE YOU BEEN SELLING VINTAGE FOR?','flatsome-child'); ?></p>
									<p class="dokan-store-custom-field-info"><?php echo $store_how_for; ?></p>
								</div>                                  
							<?php } ?>
							<?php
							if ( isset( $store_specialize ) && !empty( $store_specialize ) ) { ?>
								<div class="dokan-store-custom-field">
									<p class="dokan-store-custom-field-label"><?php echo _e('WHAT DO YOU SPECIALIZE IN SELLING/FINDING?','flatsome-child'); ?></p>
									<p class="dokan-store-custom-field-info"><?php echo $store_specialize; ?></p>
								</div>                                 
							<?php } ?>
							<?php
							if ( isset( $store_get_into ) && !empty( $store_get_into ) ) { ?>
								<div class="dokan-store-custom-field">
									<p class="dokan-store-custom-field-label"><?php echo _e('HOW DID YOU GET INTO VINTAGE','flatsome-child'); ?></p>
									<p class="dokan-store-custom-field-info">
										<?php 
										$leng_info = strlen($store_get_into);
										if ($leng_info > 90) { ?>
											<span class="text_less">
												<?php 
												echo substr($store_get_into ,0, 91).'...';
												?>
												<br>
												<a class="view-more"><?php echo _e('View more','flatsome-child'); ?></a>
												
											</span>
											<span class="text_full">
												<?php 
												echo $store_get_into;
												?>
												<br>
												<a class="view-less"><?php echo _e('View less','flatsome-child'); ?></a>

											</span>					
										<?php }else{
											echo $store_get_into; 
										}

										?>		
									</p>
									<!-- <a class="view-less"></a> -->
								</div>                               
							<?php } ?>
						</div><!-- profile-info-summery-right -->

					</div><!-- .profile-info-summery -->
				</div>               
			</div><!-- .profile-info-summery-wrapper -->
		</div> <!-- .profile-info-box -->
	</div> <!-- .profile-frame -->

	<div class="row max-w-screen-xl mx-auto dokan-store-tabs<?php echo esc_attr( $no_banner_class_tabs ); ?>">
		<div class="dokan-list-wapper">
			<ul class="dokan-list-inline">
				<?php 
                // $actual_link = "$_SERVER[REQUEST_URI]";
                // echo $actual_link == dokan_get_store_url( $store_user->get_id() ) ? 'active' : '';
				?>
				<li><a href="<?php echo dokan_get_store_url( $store_user->get_id() ); ?>"><?php echo esc_html('Shop listings', 'dokan-lite'); ?></a></li>
				<li><a href="<?php echo dokan_get_review_url( $store_user->get_id() ); ?>/"><?php echo esc_html('Reviews ', 'dokan-lite'); echo '('.count($all_comments).')'; ?></a></li>
				<?php do_action( 'dokan_after_store_tabs', $store_user->get_id() ); ?>
			</ul>
		</div>      
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		var url      = window.location.href; 
		$('.dokan-list-inline li').each(function(){
			var _this = $(this);
			var link = _this.find('a').attr('href'); 
			if (url == link) {
				_this.find('a').addClass('active');
			}
		});
	});
</script>

