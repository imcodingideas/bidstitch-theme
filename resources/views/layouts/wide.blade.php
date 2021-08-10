{{-- based on layouts/app --}}
{{-- - No container --}}
{{-- - No sidebar --}}
{{-- - No paddings --}}
<div class="flex-1 flex flex-col relative bg-white">

  <a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
  </a>

  @include('partials.header')

    <main id="main" class="main mx-auto flex-1 w-full">
      @yield('content')
    </main>

    @hasSection('sidebar')
      <aside class="sidebar">
        @yield('sidebar')
      </aside>
    @endif

  @include('partials.footer')
</div>
