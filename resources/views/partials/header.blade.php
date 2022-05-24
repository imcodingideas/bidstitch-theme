<header class="sticky top-0 bg-white z-30">
  <div class="border-b">
    <div class="max-w-screen-xl mx-auto px-4 flex justify-between items-center h-12 lg:h-20">
      <div class="flex justify-between items-center space-x-8">
      <h1 class="header-logo text-4xl lg:text-5xl text-black font-normal leading-none tracking-wide">
        <a href="{{ home_url('/') }}" class="flex">{{ $siteName }}</a>
      </h1>
      <div class="hidden lg:flex lg:h-full lg:justify-between px-5">
        @if (has_nav_menu('primary_navigation'))
          @include('partials.header-primary-navigation')
        @endif
      </div>
      <div class="hidden lg:flex">
        @if (is_active_sidebar('sidebar-header'))
          @php dynamic_sidebar('sidebar-header') @endphp
        @endif
      </div>
    </div>
      <div class="h-full flex">
        @if (is_user_logged_in())
          <div class="mr-4">
            @include('partials.header-icons')
          </div>
          @if (has_nav_menu('myaccount_navigation'))
            <div class="h-full relative items-center navigation__dropdown hidden lg:flex lg:h-full">
              @include('partials.header-avatar')
              @include('partials.header-myaccount-navigation')
            </div>
          @endif
        @else
          <div class="flex items-center space-x-2 ml-4 mr-4 lg:space-x-4 lg:mr-0">
            <a class="btn btn--black text-sm px-2 py-1 lg:px-3 lg:py-2 whitespace-nowrap"
              href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '#register') }}">{{ _e('Sign Up', 'sage') }}</a>
            <a class="btn btn--white text-sm hidden px-2 py-1 lg:px-3 lg:py-2 lg:flex whitespace-nowrap"
              href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) }}">{{ _e('Log In', 'sage') }}</a>
            <ul class="mx-2">
              @include('partials.cart-icon')
            </ul>
          </div>
        @endif
        @include('partials.sidenav')
      </div>
    </div>
  </div>
  <div class="border-b lg:hidden">
    <div class="flex items-center h-10">
      <div class="h-full w-full flex items-center mobile-search-container">
        @if (is_active_sidebar('sidebar-header'))
          @php dynamic_sidebar('sidebar-header') @endphp
        @endif
      </div>
    </div>
  </div>
</header>

