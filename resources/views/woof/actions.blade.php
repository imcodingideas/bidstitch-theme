<div class="woof_submit_search_form_container">
  @if ($filter_button)
    <button class="btn btn--black btn--md justify-center woof_submit_search_form">{{ $filter_button->label }}</button>
  @endif
  @if ($reset_button)
    <button class="btn btn--white btn--md justify-center woof_reset_search_form"
      data-link="{{ esc_attr($reset_button->link) }}">
      {{ $reset_button->label }}
    </button>
  @endif
</div>
