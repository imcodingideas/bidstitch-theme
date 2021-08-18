{{-- TODO: add transitions --}}
{{-- Dropdown menu, show/hide based on menu state. --}}
{{-- Entering: "transition ease-out duration-100" --}}
{{-- From: "transform opacity-0 scale-95" --}}
{{-- To: "transform opacity-100 scale-100" --}}
{{-- Leaving: "transition ease-in duration-75" --}}
{{-- From: "transform opacity-100 scale-100" --}}
{{-- To: "transform opacity-0 scale-95" --}}
@if ($navigation)
  <div id="header-avatar-menu" class="hidden z-10 origin-top-right absolute right-0 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
    @foreach ($navigation as $item)
      <a href="{{ $item->url }}" target="{{ $item->target }}" role="menuitem" tabindex="-1" class="block px-4 py-2 text-sm text-black font-bold uppercase {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }} {{ $item->children ? 'navigation__has-submenu' : '' }}">
        {{ $item->label }}
      </a>
      @if ($item->children)
        @foreach ($item->children as $child)
          <a href="{{ $child->url }}" target="{{ $child->target }}" role="menuitem" tabindex="-1" class="block ml-1 px-4 py-2 text-sm text-gray-700 font-medium uppercase {{ $child->classes ?? '' }} {{ $child->active ? 'active' : '' }}">
            {{ $child->label }}
          </a>
        @endforeach
      @endif
    @endforeach
  </div>
@endif