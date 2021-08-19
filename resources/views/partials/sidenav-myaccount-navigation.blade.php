@if ($navigation)
  <li class="border-b">
    <button class="w-full p-4 flex items-center text-left justify-between focus:outline-none sidenav__dropdown__toggle">
      <span class="mr-2 font-bold uppercase">My Account</span>
      <svg aria-hidden="true" focusable="false" class="text-gray-400 ml-2 h-3 w-3" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 448 512">
        <path fill="currentColor"
          d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" />
      </svg>
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
