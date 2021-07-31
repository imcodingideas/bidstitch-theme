<header class="banner">
  <div class="shadow-lg">
    <div class="flex flex-col space-y-5 py-5 max-w-6xl mx-auto">

      <div class="flex space-x-4 w-full justify-between h-full items-center">
        <div class="">
          <a class="brand header-logo text-black" href="{{ home_url('/') }}">
            {{ $siteName }}
          </a>
        </div>
        <div class="flex h-full items-center flex-1">
          @include('partials.header-search')
        </div>
        <div class="flex space-x-4 h-full items-center">
          @include('partials.header-navigation')
          @include('partials.header-avatar')
        </div>
      </div>
      <div class="flex space-x-4 justify-between h-full items-center">

        <nav class="nav-primary">
          @if (has_nav_menu('primary_navigation'))
            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
          @endif
        </nav>
        @include('partials.header-icons')
      </div>
    </div>
  </div>
</header>
