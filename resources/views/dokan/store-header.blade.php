<div class="dokan-profile-frame-wrapper">
  <div class="profile-frame{{ $no_banner_class }}">
    <div class="profile-info-box profile-layout-{{ $profile_layout }}">
      @if ($banner)
        <img src="{{ $banner }}" alt="{{ $shop_name }}" title="{{ $shop_name }}" class="profile-info-img">
      @endif
      <div class="profile-info-summery-wrapper dokan-clearfix">
        <div class="row py-12">
          <div class="lg:flex max-w-screen-xl mx-auto profile-info-summery relative row">
            <div class="flex flex-col sm:flex-row sm:space-x-10 space-y-4 sm:space-y-0">
              @include('dokan.store-header-head')
              @include('dokan.store-header-info')
            </div>
            @include('dokan.store-header-summary-right')
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('dokan.store-header-tabs')
</div>


