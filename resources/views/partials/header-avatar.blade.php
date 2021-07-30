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

    <!--
              Dropdown menu, show/hide based on menu state.

              Entering: "transition ease-out duration-100"
                From: "transform opacity-0 scale-95"
                To: "transform opacity-100 scale-100"
              Leaving: "transition ease-in duration-75"
                From: "transform opacity-100 scale-100"
                To: "transform opacity-0 scale-95"
            -->
    <div id="header-avatar-menu" class="hidden z-10 origin-top-right absolute right-0 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
      <!-- Active: "bg-gray-100", Not Active: "" -->
      <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

      <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>

      <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
    </div>
  </div>
@endif
