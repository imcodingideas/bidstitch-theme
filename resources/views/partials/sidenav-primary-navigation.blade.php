@if ($navigation)
  @foreach ($navigation as $item)
    <li class="border-b">
      @if ($item->children)
        <button
          class="w-full p-4 flex items-center justify-between text-left mr-2 font-bold uppercase focus:outline-none sidenav__dropdown__toggle {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}">
          <span class="mr-2">{{ $item->label }}</span>
          <svg class="text-gray-400 ml-1 h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor"
              d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" />
          </svg>
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
