{{-- based on layouts/wide --}}
{{-- - No container --}}
{{-- - No sidebar --}}
{{-- - No paddings --}}
<div class="flex-1 flex flex-col relative bg-white">

  <a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
  </a>

  @include('partials.header')

  <main id="main" class="main mx-auto flex-1 w-full">
    @if (is_user_logged_in())
      <div class="bg-gray-100">
        <div class="lg:container">
          <div class="flex flex-wrap lg:flex-nowrap min-h-screen content-start">
            <div class="w-full lg:w-72 lg:border-r relative">
              <div class="hidden lg:block bg-white right-0 w-screen h-full absolute"></div>
              <div class="relative">
                @include('partials.dashboard-navigation')
              </div>
            </div>
            <div class="w-full mx-auto sm:max-w-screen-sm md:max-w-screen-md lg:max-w-full lg:mx-0 p-8">
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="bg-gray-100 min-h-screen">
        <div class="container py-8">
          @yield('content')
        </div>
      </div>
    @endif
  </main>

  @include('partials.footer')
</div>
