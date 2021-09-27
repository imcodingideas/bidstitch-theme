<div class="space-y-8">
  @if ($thumbnail)
    <div class="max-w-screen-md mx-auto">
      <div class="aspect-w-16 aspect-h-9 bg-gray-50 object-cover">
        {!! $thumbnail !!}
      </div>
    </div>
  @endif
  <div class="max-w-screen-sm mx-auto space-y-8">
    <header class="grid gap-y-8">
      <h1 class="text-xl md:text-4xl font-bold">{{ $title }}</h1>

      <div class="flex items-center space-x-4">
        <div class="flex space-x-4 items-center">
          <div class="bg-gray-100 rounded-full overflow-hidden">
            {!! $avatar !!}
          </div>
          <div class="text-xs uppercase truncate font-bold">
            {{ $author }}
          </div>
        </div>

        @if ($category)
          <div class="flex space-y-4 space-x-4">
            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-bold bg-gray-100 text-gray-800">
              {{ $category }}
            </span>
          </div>
        @endif
      </div>
    </header>
    <div class="prose">
      {!! the_content() !!}
    </div>
    <div>
      @php comments_template() @endphp
    </div>
  </div>
</div>
