@if ($navigation)
  <ul class="flex flex-wrap md:ml-auto items-center text-base justify-center font-title font-semibold space-x-2">
    @foreach ($navigation as $item)
      <li class="navigation relative inline-block {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }} {{ $item->children ? 'navigation__has-submenu' : '' }}">
        <a href="{{ $item->url }}" target="{{ $item->target }}" class="btn btn--small btn--black" data-id="{{ $item->dbId }}">
          <span class="flex-shrink-0">
            {{ $item->label }}
          </span>
          @if ($item->children)
            <svg fill="currentColor" viewBox="0 0 20 20" class="flex-shrink-0 w-4 h-4 ml-1">
              <path class="navigation__arrow transition duration-150 ease-in-out origin-center transform" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          @endif
        </a>
        @if ($item->children)
          <div style="display:none" class="navigation__submenu absolute right-0 z-10 pt-2 transition duration-150 ease-in ease-out transform -translate-y-3 scale-95 opacity-0 ">
            <div class="relative py-1 bg-white border border-gray-200 rounded-md shadow-xl">
              <div class="absolute right-0 top-0 w-4 h-4 origin-center transform rotate-45 -translate-x-5 -translate-y-2 bg-white border-t border-l border-gray-200 rounded-sm pointer-events-none"></div>
              <ul class="relative">
                @foreach ($item->children as $child)
                  <li class="block w-full px-4 py-2 hover:bg-gray-100 focus:shadow-outline transition duration-300 ease-in-out {{ $child->classes ?? '' }} {{ $child->active ? 'active' : '' }}">
                    <a class="block w-max font-medium text-gray-700 whitespace-no-wrap focus:outline-none hover:text-gray-900 focus:text-gray-900 " href="{{ $child->url }}" target="{{ $item->target }}">
                      {{ $child->label }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif
      </li>
    @endforeach
  </ul>
@endif
