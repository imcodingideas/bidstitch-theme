@if (class_exists('woocommerce'))
  <a href="{{ (new \app\DokanNavMenu())->get_vendor_store_url() }}"
    class="flex px-4 -mr-4 h-full items-center account-link account-login"
    title="{{ _e('My account', 'woocommerce') }}">
    <span class="sr-only">Open user menu</span>
    <div class="h-8 w-8 rounded-full overflow-hidden bg-gray-200">
      @include('partials.header-avatar-image')
    </div>
  </a>
@endif
