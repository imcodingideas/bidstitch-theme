@if ($navigation)
  <ul class="flex flex-wrap items-center space-y-3 md:space-x-6 md:space-y-0">
    @foreach ($navigation as $item)
      <li class="w-full text-center md:w-auto">
        <a class="text-white text-sm uppercase" href="{{ $item->url }}" target="{{ $item->target }}">
          {{ $item->label }}
        </a>
      </li>
      @if ($item->children)
        @foreach ($children as $child)
          <li class="w-full text-center md:w-auto">
            <a class="text-white text-sm uppercase" href="{{ $child->url }}" target="{{ $child->target }}">
              {{ $child->label }}
            </a>
          </li>
        @endforeach
      @endif
    @endforeach
  </ul>
@endif
