@if ($navigation)
  <div
    {{ $attributes->merge(['class' => "z-50 absolute top-full w-44 bg-white border navigation__dropdown__menu $type"]) }}
    role="menu" tabindex="-1">
    @foreach ($navigation as $item)
      <div class="border-b last:border-b-0 border-gray-200">
        <a href="{{ $item->url }}" target="{{ $item->target }}"
          class="transition-colors hover:bg-gray-100 block p-3 text-sm text-black font-bold {{ $item->classes ?? '' }} {{ $item->active ? 'active' : '' }}">
          {{ $item->label }}
        </a>
        @if ($item->children)
          @foreach ($item->children as $child)
            <a href="{{ $child->url }}" target="{{ $child->target }}"
              class="transition-colors hover:bg-gray-100 block p-3 text-sm text-gray-700 font-medium {{ $child->classes ?? '' }} {{ $child->active ? 'active' : '' }}">
              {{ $child->label }}
            </a>
          @endforeach
        @endif
      </div>
    @endforeach
  </div>
@endif
