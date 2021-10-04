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
      <h1 class="text-xl md:text-4xl font-bold">{!! $title !!}</h1>

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
    <div class="grid">
      <div class="grid border-t space-y-4 items-center justify-center bg-gradient-to-r from-white via-gray-100 to-white py-6">  
        <h3 class="uppercase font-bold text-sm text-center">{{ _e('Share this story:', 'e') }}</h3>
        <div class="flex justify-center space-x-4">
          <a href="https://twitter.com/intent/tweet?text={!! urlencode($title) !!}&url={!! urlencode($link) !!}" target="_blank" rel="noopener noreferrer" class="btn btn--sm btn--white space-x-2">
            <svg class="w-4" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
            </svg>
            <span>{{ _e('Twitter', 'sage') }}</span>
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u={!! urlencode($link) !!}" target="_blank" rel="noopener noreferrer" class="btn btn--sm btn--white space-x-2">
            <svg class="w-4" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
            </svg>
            <span>{{ _e('Facebook', 'sage') }}</span>
          </a>
        </div>
      </div>
      @php comments_template() @endphp
    </div>
  </div>
</div>
