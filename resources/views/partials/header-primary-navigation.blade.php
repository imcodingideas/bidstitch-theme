@if ($navigation)
  <nav class="h-full hidden lg:flex">
    <ul class="flex h-full space-x-8">
      @foreach ($navigation as $item)
        @if ($item->children)
          <li class="h-full relative group navigation__dropdown">
            <button
              class="h-full flex items-center text-sm font-bold relative uppercase focus:outline-none navigation__dropdown__toggle {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}">
              <span>{{ $item->label }}</span>
              <svg aria-hidden="true" focusable="false" class="text-gray-400 ml-2 h-3 w-3 group-hover:text-gray-500"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="currentColor"
                  d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" />
              </svg>
            </button>
            <x-dropdown-navigation :navigation="$item->children" type="left" />
          </li>
        @else
          <li class="h-full">
            <a href="{{ $item->url }}" target="{{ $item->target }}"
              class="h-full flex items-center text-sm font-bold relative uppercase {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}">
              {{ $item->label }}
            </a>
          </li>
        @endif
      @endforeach
    </ul>
  </nav>
@endif
