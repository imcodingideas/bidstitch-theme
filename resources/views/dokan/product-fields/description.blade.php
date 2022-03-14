@php
if ($post) {
    $post_content = $post->post_content;
} else {
    $post_content = dokan_posted_input('post_content');
}
@endphp
<div class="">
  <label for="post_content" class="form-label">{{ _e('Description', 'dokan-lite') }}</label>
  <textarea required name="post_content" id="post_content" class="dokan-form-control" rows="5" placeholder="{{ _e('Product description, including any useful measurements and remarks on the condition (pinholes, stains, rips, etc.)', 'dokan') }}">{{ $post_content }}</textarea>
</div>
