{{-- todo: can't find a product where this code is displayed, and then reformat to blade --}}
@if ($should_be_displayed)
	<div class="tab-item">
		<div class="tab-top">
			<p>{{  _e('Pending offers','sage') }}</p>
			<i class="chevron-down-wuc"></i>
		</div>
		<div class="tab-content">
			@if (count($offers))
				@foreach ($offers as $offer)
					@php
						extract($offers)
					@endphp

					<div class="make_offer_item content-box child-offer">
						<div class="avatar_offer img-ava">
							@if(!empty($avatar[0]) && !empty(wp_get_attachment_url($avatar[0])))
								<img src="{{  wp_get_attachment_url($avatar[0])}}" alt="{{ _e('Avatar','sage') }}" width="50" height="50">
							@else
								<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" alt="<?php _e('Avatar','sage'); ?>" width="50" height="50">
							@endif
						</div>
						<div class="info_offer noti">

							<p class="text"><a href="<?php echo $user_profile_link; ?>"><span class="bold">@<?php echo $user->display_name;  ?></span></a> <?php _e('offered ','sage') ;?><?php echo get_woocommerce_currency_symbol();echo $offer_price_per; ?><?php _e(' for this item','sage') ;?></p>
							<p class="time-log"><?php echo time_elapsed_string(get_the_date()); ?></p>
						</div>

						<div class="btn action_offer">
							<?php
							if ($post_status == 'publish') { ?>
													<div class="dec decline-offer-link">
														<button class="decline woocommerce-offer-post-action-link woocommerce-offer-post-action-link-decline" data-target = "<?php echo $id_offer; ?>">
															<div class="div-loadmore">
																<i class="fas fa-spinner fa-spin"></i>
															</div>
															<?php _e('DECLINE','sage'); ?>
														</button>
													</div>
													<div class="acc accept-offer-link">
														<button class="accept woocommerce-offer-post-action-link woocommerce-offer-post-action-link-accept" data-target="<?php echo $id_offer; ?>">
															<div class="div-loadmore">
																<i class="fas fa-spinner fa-spin"></i>
															</div>
															<?php _e('ACCEPT', 'sage'); ?>
														</button>
													</div>
													<?php }elseif ($post_status == 'accepted-offer') { ?>
													<div class="acc">
														<div class="woocommerce-offer-post-status-grid-icon accepted" title="<?php _e('Offer Status: Accepted','sage'); ?>"><?php _e('Accepted', 'sage'); ?></div>
													</div>

													<?php }elseif ($post_status == 'declined-offer') { ?>
													<div class="acc">
														<div class="woocommerce-offer-post-status-grid-icon declined" title=" <?php _e('Offer Status: Declined','sage'); ?>"><?php _e('Declined', 'sage'); ?></div>
													</div>
													<?php
														}
													?>
						</div>
					</div>
				@endforeach

			@else
				<p>{{  _e('No offers found!','sage') }}</p>
			@endif
		</div>
	</div>
@endif
