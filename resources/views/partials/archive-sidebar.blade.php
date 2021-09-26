<div
  class="flex flex-row space-x-2 lg:space-x-0 lg:flex-col lg:divide-y lg:shadow lg:rounded lg:bg-white lg:sticky lg:top-40">
  @if ($page_for_posts)
    <div class="grid w-full flex-1 lg:p-4">
      @include('forms.search-archive')
    </div>
  @endif
  @if ($categories)
    <div class="hidden lg:grid">
      <h2 class="pl-4 text-base font-bold uppercase w-full py-4 flex items-center">
        {{ _e('Topics', 'sage') }}
      </h2>

      <div class="grid divide-y border-t">
        @foreach ($categories as $category)
          <a href="{{ esc_url($category->link) }}"
            class="flex justify-between space-x-2 transition-colors p-4 text-sm uppercase hover:bg-gray-50 {{ $category->active ? 'bg-gray-50' : '' }}">
            <h3 class="text-sm uppercase">{{ $category->name }}</h3>
            <img class="w-2" src="@asset('images/chevron-right-solid.svg')" alt="chevron-right" />
          </a>
        @endforeach
      </div>
    </div>
    <div class="grid w-36 lg:hidden" x-data="{}">
      <select
        class="text-sm appearance-none w-full px-3 py-2 border border-gray-300 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black"
        @change="if($event.target.value) window.location = $event.target.value">
        @foreach ($categories as $category)
          <option value="{{ esc_url($category->link) }}" {!! $category->active ? 'selected' : '' !!}>{{ $category->name }}</option>
        @endforeach
      </select>
    </div>
  @endif
</div>
