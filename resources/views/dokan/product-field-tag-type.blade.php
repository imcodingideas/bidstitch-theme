@php
if (!empty($post_id)) {
    $tees_tag_type = get_post_meta($post_id, 'tees_tag_type', true);
} else {
    $tees_tag_type = dokan_posted_input('tees_tag_type');
}
@endphp
<div class="">
  <label for="tees_tag_type" class="form-label">{{ _e('Tag Type', 'dokan-lite') }}</label>
  <input name="tees_tag_type" id="tees_tag_type" class="dokan-form-control" placeholder="{{ _e('Tag Type', 'dokan') }}" value="{{ $tees_tag_type }}">
</div>
