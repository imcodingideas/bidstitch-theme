<div class="flex-1 flex flex-col relative bg-gray-50">

  <a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
  </a>

  @include('partials.header')

  @hasSection('sidebar')
    <div class="container">
      <div class="grid gap-y-8 py-8 lg:grid-cols-12 md:gap-x-12 md:gap-y-12 md:py-12">
        <div class="lg:col-span-3 h-full">
          <aside class="h-full">
            @yield('sidebar')
          </aside>
        </div>
        <div class="lg:col-span-9 h-full">
          <main id="main" class="main">
            @yield('content')
          </main>
        </div>
      </div>
    </div>
  @else
    <main id="main" class="main container">
      @yield('content')
    </main>
  @endif

  @include('partials.footer')
</div>
