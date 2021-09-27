@if ($featured)
  <article
    class="grid items-start relative h-full shadow bg-white rounded overflow-hidden md:grid-cols-2 col-span-2 md:col-span-3">
    @include('partials.content-archive-post-banner')

    <div class="static grid h-full gap-y-4 p-4 md:p-8">
      <div class="grid gap-y-4">
        @include('partials.content-archive-post-header')

        <div class="hidden md:text-sm md:block">
          {!! $excerpt !!}
        </div>
      </div>

      <div class="md:mt-auto">
        @include('partials.content-archive-post-footer')
      </div>

      <a class="absolute top-0 left-0 h-full w-full" href="{{ esc_url($link) }}"
        aria-label="{{ esc_html($title) }}"></a>
    </div>
  </article>
@else
  <article class="grid items-start relative h-full shadow bg-white rounded overflow-hidden">
    <div class="grid">
      @include('partials.content-archive-post-banner')

      <div class="p-2 md:p-4">
        @include('partials.content-archive-post-header')
      </div>
    </div>

    <div class="p-2 pt-0 md:p-4 md:pt-0 md:mt-auto">
      @include('partials.content-archive-post-footer')
    </div>

    <a class="absolute top-0 left-0 h-full w-full" href="{{ esc_url($link) }}"
      aria-label="{{ esc_html($title) }}"></a>
  </article>
@endif
