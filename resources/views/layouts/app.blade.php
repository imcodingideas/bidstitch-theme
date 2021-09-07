<div class="flex-1 flex flex-col relative bg-white">

  <a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
  </a>

  @include('partials.header')

  @hasSection('sidebar')
    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 xl:space-x-8 container py-8">
      <div class="md:w-3/12">
        <aside class="shop-sidebar">
          @yield('sidebar')
        </aside>
      </div>
      <div class="md:w-9/12">
        <main id="main" class="main">
          @yield('content')
        </main>
      </div>
    </div>
  @else
    <main id="main" class="main container py-8">
      @yield('content')
    </main>
  @endif

  @include('partials.footer')
</div>
