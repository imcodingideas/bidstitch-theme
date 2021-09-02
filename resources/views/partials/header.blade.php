<header class="sticky top-0 bg-white z-30">
  <div class="border-b">
    <div class="container flex justify-between items-center h-12 lg:h-20 lg:justify-start">
      <h1 class="header-logo text-2xl lg:text-3xl text-black leading-none tracking-widest">
        <a href="{{ home_url('/') }}" class="flex">{{ $siteName }}</a>
      </h1>
      <div class="hidden lg:max-w-md lg:flex lg:mx-8 lg:mr-0 w-full">
        @if (is_active_sidebar('sidebar-header'))
          @php dynamic_sidebar('sidebar-header') @endphp
        @endif
      </div>
      <div class="h-full ml-auto flex">
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
          <div class="flex items-center space-x-2 mr-4 lg:space-x-4 lg:mr-0">
            <a class="btn btn--black text-sm px-2 py-1 lg:px-3 lg:py-2"
              href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '#register') }}">{{ _e('Sign Up', 'sage') }}</a>
            <a class="btn btn--white text-sm hidden px-2 py-1 lg:px-3 lg:py-2 lg:flex"
              href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) }}">{{ _e('Log In', 'sage') }}</a>
          </div>
        @endif
      </div>
      @include('partials.sidenav')
    </div>
  </div>
  <div class="border-b">
    <div class="container flex items-center h-10 lg:h-12">
      <div class="h-full w-full">
        <div class="h-full w-full flex items-center lg:hidden">
          @if (is_active_sidebar('sidebar-header'))
            @php dynamic_sidebar('sidebar-header') @endphp
          @endif
        </div>
        <div class="hidden lg:flex lg:h-full lg:justify-between">
          @if (has_nav_menu('primary_navigation'))
            @include('partials.header-primary-navigation')
          @endif
          @if (has_nav_menu('header_navigation'))
            @include('partials.header-navigation')
          @endif
        </div>
      </div>
    </div>
  </div>
</header>
