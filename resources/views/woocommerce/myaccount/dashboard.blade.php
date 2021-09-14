<div class="grid space-y-8">
  <div class="grid space-y-8">
    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{ _e('My Account', 'sage') }}</h1>
    @if ($navigation)
      <div
        class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
        @foreach ($navigation as $item)
          <div class="relative group bg-white p-6">
            <div>
              <span class="rounded-lg inline-flex p-3 bg-gray-100 text-gray-700 ring-4 ring-white">
                {!! $item->icon !!}
              </span>
            </div>
            <div class="mt-8">
              <h3 class="text-lg font-medium">
                <a href="{{ $item->link }}" class="focus:outline-none">
                  <span class="absolute inset-0" aria-hidden="true"></span>
                  {{ $item->label }}
                </a>
              </h3>
              <p class="mt-2 text-sm text-gray-500">
                {{ $item->description }}
              </p>
            </div>
            <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
              aria-hidden="true">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
              </svg>
            </span>
          </div>
        @endforeach
      </div>
    @endif
  </div>
  @php do_action('woocommerce_account_dashboard') @endphp
  @php do_action('woocommerce_before_my_account') @endphp
  @php do_action('woocommerce_after_my_account') @endphp
</div>
