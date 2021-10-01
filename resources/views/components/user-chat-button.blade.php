@if ($user_can_message)
  @if ($receiver_data)
    <button {{ $attributes->merge(['class' => 'message__compose__button']) }} {{ $attributes }}
      data-message-receiver="{!! htmlspecialchars($receiver_data, ENT_QUOTES, 'UTF-8') !!}">
      <div class="relative w-full">
        <span class="transition-opacity opacity-0 message__compose__button__label">
          {{ $message }}
        </span>

        <div
          class="flex items-center justify-center absolute top-0 left-0 w-full h-full opacity-100 visible z-10 message__compose__button__loading">
          <svg aria-hidden="true" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
          </svg>
        </div>
      </div>
    </button>
  @endif
@else
  <a {{ $attributes }} href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) }}">
    {{ _e('Login to Chat', 'sage') }}
  </a>
@endif
