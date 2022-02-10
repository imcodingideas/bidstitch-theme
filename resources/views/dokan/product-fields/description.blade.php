@php
if ($post) {
    $post_content = $post->post_content;
} else {
    $post_content = dokan_posted_input('post_content');
}
@endphp
<div class="">
  <label for="post_content" class="form-label">{{ _e('Additional details', 'dokan-lite') }}</label>
  <textarea required name="post_content" id="post_content" class="dokan-form-control" rows="5" placeholder="{{ _e('Please enter any additional details the buyer should be aware of, such as useful measurements and remarks on the condition (pinholes, stains, rips, etc.)', 'dokan') }}">{{ $post_content }}</textarea>
</div>
