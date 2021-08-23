@if ($navigation)
  @foreach ($navigation as $item)
    <li class="border-b">
      @if ($item->children)
        <button
          class="w-full p-4 flex items-center justify-between text-left mr-2 font-bold uppercase focus:outline-none sidenav__dropdown__toggle {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}">
          <span class="mr-2">{{ $item->label }}</span>
          <img aria-hidden="true" focusable="false" class="text-gray-400 ml-2 h-3 w-3 group-hover:text-gray-500"
            src="@asset('images/chevron-down.svg')" alt="chevron-down" />
        </button>
        <ul class="sidenav__dropdown__menu hidden bg-gray-50">
          @foreach ($item->children as $child)
            <li class="border-t">
              <a class="flex px-4 py-2 text-sm font-bold {{ $child->classes ?? '' }} {{ $child->active ? 'active' : '' }}"
                href="{{ $child->url }}" target="{{ $child->target }}">{{ $child->label }}</a>
            </li>
            @if ($child->children)
              @foreach ($child->children as $subchild)
                <li>
                  <a class="flex px-4 py-2 text-sm {{ $subchild->classes ?? '' }} {{ $subchild->active ? 'active' : '' }}"
                    href="{{ $subchild->url }}" target="{{ $subchild->target }}">{{ $subchild->label }}</a>
                </li>
              @endforeach
            @endif
          @endforeach
        </ul>
      @else
        <a class="w-full p-4 flex items-center mr-2 font-bold uppercase {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}"
          href="{{ $item->url }}" target="{{ $item->target }}">{{ $item->label }}</a>
      @endif
    </li>
  @endforeach
@endif
