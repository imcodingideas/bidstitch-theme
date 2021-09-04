@php
if (!empty($post)) {
    $tees_tip = get_post_meta($post->ID, 'tees_tip', true);
} else {
    $tees_tip = dokan_posted_input('tees_tip');
}
@endphp
<div class="">
  <label for="tees_tip" class="form-label">{{ _e('Pit to Pit', 'dokan-lite') }}</label>
  <input name="tees_tip" id="tees_tip" class="dokan-form-control" placeholder="{{ _e('Pit to Pit', 'dokan') }}" value="{{ $tees_tip }}">
</div>
