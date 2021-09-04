@php
if (!empty($post)) {
    $tees_length = get_post_meta($post->ID, 'tees_length', true);
} else {
    $tees_length = dokan_posted_input('tees_length');
}
@endphp
<div class="">
  <label for="tees_length" class="form-label">{{ _e('Length', 'dokan-lite') }}</label>
  <input name="tees_length" id="tees_length" class="dokan-form-control" placeholder="{{ _e('Length', 'dokan') }}" value="{{ $tees_length }}">
</div>
