<div class="profile-info-head">
  <div class="profile-img {{  $profile_img_class }}">
    <img src="{{  $avatar }}" alt="{{  $shop_name }}" size="150">
  </div>
  @if ( ! empty($shop_name) && 'default' === $profile_layout ) 
    <h1 class="store-name">{{  $shop_name }}</h1>
  @endif
</div>
