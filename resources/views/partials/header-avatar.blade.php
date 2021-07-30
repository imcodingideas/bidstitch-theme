@if (class_exists('woocommerce'))
  <!-- Profile dropdown -->
  <div id="header-avatar" class="ml-3 relative">
    <div>
      <button type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
        <span class="sr-only">Open user menu</span>
        <div class="h-8 w-8 rounded-full overflow-hidden bg-gray-200">
          <a href="{{ get_permalink(get_option('woocommerce_myaccount_page_id')) }}" class="account-link account-login" title="{{ _e('My account', 'woocommerce') }}">
            @include('partials.header-avatar-image')
          </a>
        </div>
      </button>
    </div>

    @if (has_nav_menu('myaccount_navigation') && is_user_logged_in())
      @include('partials.myaccount-navigation')
    @endif
  </div>
@endif
