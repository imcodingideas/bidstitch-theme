<div class="profile-info-summery-right large-6 medium-12 small-12">

	@if ( isset( $store_how_for ) && !empty( $store_how_for ) ) 
		<div class="dokan-store-custom-field">
			<p class="dokan-store-custom-field-label">{{  _e('HOW LONG HAVE YOU BEEN SELLING VINTAGE FOR?','sage') }}</p>
			<p class="dokan-store-custom-field-info">{{  $store_how_for }}</p>
		</div>                                  
	@endif

	@if ( isset( $store_specialize ) && !empty( $store_specialize ) ) 
		<div class="dokan-store-custom-field">
			<p class="dokan-store-custom-field-label">{{  _e('WHAT DO YOU SPECIALIZE IN SELLING/FINDING?','sage') }}</p>
			<p class="dokan-store-custom-field-info">{{  $store_specialize }}</p>
		</div>                                 
	@endif

	@if ( isset( $store_get_into ) && !empty( $store_get_into ) ) 
		<div class="dokan-store-custom-field">
			<p class="dokan-store-custom-field-label">{{  _e('HOW DID YOU GET INTO VINTAGE','sage') }}</p>
			<p class="dokan-store-custom-field-info">
				@if (strlen($store_get_into) > 90) 
					<span class="text_less">
						{!! substr($store_get_into ,0, 91).'...' !!}
						<br>
						<a class="view-more">{{  _e('View more','sage') }}</a>

					</span>
					<span class="text_full">
						{!! $store_get_into !!}
						<br>
						<a class="view-less">{{  _e('View less','sage') }}</a>
					</span>					
				@else
					{!! $store_get_into !!}  
				@endif
			</p>
		</div>                               
	@endif
</div>
