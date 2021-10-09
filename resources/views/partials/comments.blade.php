@if (!$password_required)
  @if ($comments_open_status)
    <section id="comments" class="comments-area relative">
      @if ($has_comments)
        <div class="grid space-y-1">
          <h2 class="text-xl font-bold uppercase">{{ _e('Discussion', 'sage') }}</h2>
        </div>

        <div class="comment-list">
          {!! wp_list_comments($comment_list_args) !!}
        </div>

        @if ($pagination)
        <nav>
          <ul class="pager">
            @if ($pagination->prev_link)
              <li class="previous">
                {!! $pagination->prev_link !!}
              </li>
            @endif

            @if ($pagination->prev_next)
            <li class="previous">
              {!! $pagination->prev_next !!}
            </li>
          @endif
          </ul>
        </nav>
        @endif
      @else
      <div class="grid space-y-1">
        <h2 class="text-xl font-bold uppercase">{{ _e('Discussion', 'sage') }}</h2>
        <p>{{ _e('Be the first to leave a comment', 'sage') }}</p>
      </div>
      @endif

      @php
        comment_form($comment_form_args);
      @endphp
    </section>
  @endif
@endif
