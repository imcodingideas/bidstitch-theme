<header class="sticky top-0 bg-white z-30">
  <div class="border-b">
    <div class="lg:container px-2 flex justify-between items-center h-16 lg:h-20 lg:justify-start">
      <h1 class="header-logo text-xl lg:text-3xl text-black leading-none tracking-widest">
        <a href="{{ home_url('/') }}" class="flex">{{ $siteName }}</a>
      </h1>
      @include('partials.header-search')
      <div class="hidden lg:flex h-full ml-auto">
        @if (has_nav_menu('header_navigation'))
          @include('partials.header-navigation')
        @endif
      </div>
      @if (has_nav_menu('myaccount_navigation') && is_user_logged_in())
        <div class="h-full relative hidden ml-4 lg:flex lg:items-center navigation__dropdown">
          @include('partials.header-avatar')
          @include('partials.header-myaccount-navigation')
        </div>
      @endif
      @include('partials.sidenav')
    </div>
  </div>
  <div class="border-b">
    <div class="container flex items-center h-12 justify-between">
      @if (has_nav_menu('primary_navigation'))
        @include('partials.header-primary-navigation')
      @endif
      <div class="flex lg:hidden h-full">
        @if (has_nav_menu('header_navigation'))
          @include('partials.header-navigation')
        @endif
      </div>
      @if (is_user_logged_in())
        @include('partials.header-icons')
      @else
        @include('partials.header-register-navigation')
      @endif
    </div>
  </div>
</header>
