@php
if (!empty($post)) {
    $post_excerpt = $post->post_excerpt;
} else {
    $post_excerpt = dokan_posted_input('post_excerpt');
}
@endphp
<div class="">
  <label for="post_excerpt" class="form-label h4">
    {{ _e('Description', 'dokan-lite') }}
  </label>
  <textarea name="post_excerpt" id="post-excerpt" rows="5" class="dokan-form-control" placeholder="{{ _e('Short description of the product...', 'dokan-lite') }}">{{ $post_excerpt }}</textarea>
</div>
