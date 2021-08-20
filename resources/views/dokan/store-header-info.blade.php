<div class="profile-info flex flex-col space-y-2">
  @if ( ! empty( $shop_name ) && 'default' !== $profile_layout ) 
    <h1 class="store-name flex">
      {{ $shop_name }} 
      @if (true || $founder == "true")
        <img class="w-5 ml-4" src="@asset('images/crown.svg')" alt="crown"/>
      @endif
      @if(true ||  $igverified == "true")
        <img class="w-5 ml-4" src="@asset('images/instagram.svg')" alt="instagram"/>
      @endif
    </h1>
    <p class="vendorshophandle"> <a href="{{  $vendor_profile_link }}">{{  $vendor_name }}</a></p>
  @endif

  <div class="dokan-store-rating mb-show dokan-store-rating-mb ml-6">
    {!! $store_rating !!}
  </div>
  <div class="hidden items-center md:flex space-x-4">
    <p>
      <button data-store_id="1" class="btn btn--white dokan-store-support-btn flex items-center px-8 py-2 space-x-3 uppercase user_logged">
        <span class="fab fa-telegram-plane"></span>
        <span class="">Send Message</span>
      </button>
    </p>
    @if (is_user_logged_in())
      @php dokan_follow_store_get_template( 'follow-button', $args_btn_follow ) @endphp
    @else
      <p><a href="{{  home_url('/log-in') }}" class="login_btn vender_action_btn" ><i class="far fa-heart"></i></a></p>
    @endif
  </div>
  <div class="dokan-store-des">
    {{  $dokan_store_des }}
  </div>

  @if($countryname)
    <div class="dokan-store-address">
      <p class="dokan-store-address-label">{{  _e('Location','sage') }}</p>
      <p class="dokan-store-address-info"></i>
      {{  $countryname }}
      </p>
    </div>                                   
  @endif

</div>
