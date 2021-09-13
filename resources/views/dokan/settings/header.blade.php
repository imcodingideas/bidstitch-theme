@if ($navigation)
  <div class="mb-8">
    <div class="hidden lg:grid-cols-4 lg:shadow lg:rounded-sm lg:overflow-hidden lg:grid">
      @foreach ($navigation as $item)
        <a class="flex w-full items-center justify-center text-center uppercase font-bold py-4 px-2 relative text-sm sm:text-base {{ $item->active ? 'bg-white' : 'bg-gray-50' }}"
          href="{{ $item->link }}">
          {{ $item->label }}
          <span aria-hidden="true"
            class="bg-gray-400 absolute inset-x-0 bottom-0 {{ $item->active ? 'h-0.5' : '' }}"></span>
        </a>
      @endforeach
    </div>
    <div class="lg:hidden" x-data="">
      <select @change="window.location = $event.target.value" id="tabs" name="tabs"
        class="text-sm appearance-none w-full px-3 py-2 border border-gray-300 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black">
        @foreach ($navigation as $item)
          <option {{ $item->active ? 'selected' : '' }} value="{{ $item->link }}">
            {{ $item->label }}
          </option>
        @endforeach
      </select>
    </div>
  </div>
@endif
