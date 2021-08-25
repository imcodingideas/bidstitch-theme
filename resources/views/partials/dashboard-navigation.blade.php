<div class="hidden lg:grid lg:gap-y-8">
  <div class="grid gap-y-8">
    <nav class="grid">
      @if ($account_navigation)
        <div class="grid">
          <h4 class="font-bold text-lg p-4 border-b bg-gradient-to-r from-white to-gray-100">
            {{ _e('Account', 'sage') }}</h4>
          @foreach ($account_navigation as $item)
            <a href="{{ $item->url }}"
              class="transition-colors bg-gradient-to-r from-white hover:to-gray-50 flex items-center px-4 py-3 text-sm uppercase border-b {{ $item->active ? 'to-gray-50' : 'to-white' }}">
              {{ $item->label }}
            </a>
          @endforeach
        </div>
      @endif
      @if ($seller_enabled)
        @if ($vendor_navigation)
          <div class="grid">
            <h4 class="font-bold text-lg p-4 border-b bg-gradient-to-r from-white to-gray-100">
              {{ _e('Store', 'sage') }}</h4>
            @foreach ($vendor_navigation as $item)
              <a href="{{ $item->url }}"
                class="transition-colors bg-gradient-to-r from-white hover:to-gray-50 flex items-center px-4 py-3 text-sm uppercase border-b {{ $item->active ? 'to-gray-50' : 'to-white' }}">
                {{ $item->label }}
              </a>
            @endforeach
          </div>
        @endif
      @endif
    </nav>
  </div>
</div>
