@php
if (!empty($post_id)) {
    $post_title = $post->post_title;
} else {
    $post_title = dokan_posted_input('post_title');
}
@endphp
<div class="">
  <label for="tees_length" class="form-label">
    {{ _e('Title', 'dokan-lite') }}
    <span class="text-red-500">(required)</span>
  </label>
  <input class="dokan-form-control" name="post_title" id="post-title" placeholder="{{ _e('Product name', 'dokan-lite') }}" value="{{ $post_title }}">
</div>
