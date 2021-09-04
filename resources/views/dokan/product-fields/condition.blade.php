@php
if (!empty($post)) {
    // current condition
    $term_condition = wp_get_post_terms($post->ID, 'product_condition', [
        'fields' => 'ids',
    ]);
    $product_condition = $term_condition ? $term_condition[0] : '';
} else {
    $product_condition = dokan_posted_input('product_condition');
}

// condition terms
$terms_condition = get_terms([
    'taxonomy' => 'product_condition',
    'hide_empty' => false,
]);
@endphp
<div class="condition">
  <label for="product_condition" class="form-label">{{ _e('condition', 'dokan-lite') }}</label>
  <select required name="product_condition" id="product_condition" class="product_condition dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true">
    <option value="">{{ _e('Select a condition', 'dokan-lite') }}</option>
    @if (!empty($terms_condition))
      @foreach ($terms_condition as $term)
        <option {{ $term->term_id == $product_condition ? 'selected' : '' }} value="{{ $term->term_id }}">{{ $term->name }}</option>
      @endforeach
    @endif
  </select>
</div>
