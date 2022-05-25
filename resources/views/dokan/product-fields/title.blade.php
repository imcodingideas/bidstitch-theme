@php
if ($post) {
    $post_title = $post->post_title;
} else {
    $post_title = dokan_posted_input('post_title');
}
@endphp
<div class="">
  <label for="post_title" class="form-label">
    {{ _e('Title', 'dokan-lite') }}
    <span class="text-red-500">(required)</span>
  </label>
  <input required class="dokan-form-control" name="post_title" id="post-title" placeholder="{{ _e('Product name', 'dokan-lite') }}" value="{{ $post_title }}" maxlength="120">
</div>
