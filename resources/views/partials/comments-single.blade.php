@if ($comment_item)
  <{!! $comment_item->element !!} {!! $comment_item->class !!} id="comment-{{ $comment_item->id }}">
    <span class="absolute top-0 left-4 -ml-px h-full w-0.5 bg-gray-100" aria-hidden="true"></span>

    <div class="relative mt-2" class="{{ $comment_item->type != 'div' ? 'comment-body' : 'div-comment-body' }}">
      <div class="relative flex items-start space-x-3">
        <div class="avatar avatar-32 photo h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
          {!! $comment_item->author_avatar !!}
        </div>
        <div class="grid flex-1">
          <div class="flex items-center flex space-x-2 text-sm h-8 min-w-0">
            <div class="font-medium text-gray-900 truncate">{{ $comment_item->author_name }}</div>
            <div class="flex items-center space-x-2 flex-1 whitespace-nowrap">
              <div class="text-gray-500">
                <span>{{ $comment_item->date }}</span>
                <span>{{ _e('ago', 'sage') }}</span>
              </div>
            </div>
          </div>
          <div class="mt-1 mb-2 text-sm text-gray-700">
            {!! $comment_item->text !!}
          </div>
          <div class="flex text-sm items-center space-x-2 text-gray-500">
            @if (!$comment_item->approved)
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                {{ _e('Awaiting Approval', 'sage') }}
              </span>
              @else
              @if ($comment_item->reply_link)
                <div class="flex items-center space-x-1 comment-reply">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                  </svg>
                  {!! $comment_item->reply_link !!}
                </div>
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
