@if ($navigation)
  <nav class="h-full">
    <ul class="flex h-full space-x-8">
      @foreach ($navigation as $item)
        @if ($item->children)
          <li class="h-full relative group navigation__dropdown">
            <button
              class="h-full flex items-center text-sm font-bold relative uppercase focus:outline-none navigation__dropdown__toggle {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}">
              <span>{{ $item->label }}</span>
              <img aria-hidden="true" focusable="false"
                class="transition-opacity opacity-60 ml-2 h-3 w-3 group-hover:opacity-80"
                src="@asset('images/chevron-down.svg')" alt="chevron-down" />
            </button>
            <x-dropdown-navigation :navigation="$item->children" type="right" />
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
