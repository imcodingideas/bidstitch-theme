@if ($navigation)
  <li class="border-b">
    <button class="w-full p-4 flex items-center text-left justify-between focus:outline-none sidenav__dropdown__toggle">
      <span class="mr-2 font-bold uppercase">My Account</span>
      <img aria-hidden="true" focusable="false"
        class="transition-opacity opacity-60 ml-2 h-3 w-3 group-hover:opacity-80"
        src="@asset('images/chevron-down.svg')" alt="chevron-down" />
    </button>
    <ul class="sidenav__dropdown__menu hidden bg-gray-50">
      @foreach ($navigation as $item)
        <li class="border-t">
          <a class="flex px-4 py-2 text-sm font-bold {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}"
            href="{{ $item->url }}" target="{{ $item->target }}">{{ $item->label }}</a>
        </li>
        @if ($item->children)
          @foreach ($item->children as $child)
            <li>
              <a class="flex px-4 py-2 text-sm {{ $child->classes ?? '' }} {{ $child->active ? 'active' : '' }}"
                href="{{ $child->url }}" target="{{ $child->target }}">{{ $child->label }}</a>
            </li>
          @endforeach
        @endif
      @endforeach
    </ul>
  </li>
@endif
