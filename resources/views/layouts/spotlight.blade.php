<div class="flex-1 flex flex-col relative bg-gray-100">

  <a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
  </a>

  @include('partials.header')

    <main id="main">
      @include('partials.spotlight')
    </main>
  @include('partials.best-selling-products')
  @include('partials.footer')
</div>