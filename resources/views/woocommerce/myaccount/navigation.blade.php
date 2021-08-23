@if ($navigation)
  <div class="flex lg:hidden bg-gray-50 border-b">
    <div class="container">
      <div class="relative flex lg:hidden group navigation__dropdown">
        <button
          class="flex items-center text-sm font-bold relative uppercase focus:outline-none h-12 navigation__dropdown__toggle">
          <span>
            @if ($active_item)
              {{ $active_item->label }}
            @else
              {{ $navigation[0]->label }}
            @endif
          </span>
          <svg aria-hidden="true" focusable="false" class="text-gray-400 ml-2 h-3 w-3 group-hover:text-gray-500"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor"
              d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
            </path>
          </svg>
        </button>
        <x-dropdown-navigation :navigation="$navigation" type="left" />
      </div>
    </div>
  </div>
  <div class="hidden lg:grid lg:gap-y-8">
    <div class="grid gap-y-8 pt-8">
      <h4 class="font-bold text-2xl">{{ _e('My Account', 'sage') }}</h4>
      <nav class="grid">
        @foreach ($navigation as $item)
          <a href="{{ $item->url }}"
            class="transition-colors hover:bg-gray-100 flex items-center px-4 py-3 text-sm font-bold uppercase border-b last:border-b-0 {{ $item->active ? 'bg-gray-100' : '' }}">
            {{ $item->label }}
          </a>
        @endforeach
      </nav>
    </div>
  </div>
@endif
