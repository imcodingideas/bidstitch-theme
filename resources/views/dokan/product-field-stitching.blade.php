@php
if (!empty($post_id)) {
    $tees_stitching = get_post_meta($post_id, 'tees_stitching', true);
} else {
    $tees_stitching = dokan_posted_input('tees_stitching');
}
@endphp
<div class="">
  <label for="tees_stitching" class="form-label">{{ _e('Stitching', 'dokan-lite') }}</label>
  <input name="tees_stitching" id="tees_stitching" class="dokan-form-control" placeholder="<?php esc_attr_e('Stitching', 'dokan'); ?>" value="{{ $tees_stitching }}">
</div>
