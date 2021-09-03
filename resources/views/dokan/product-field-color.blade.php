@php
if (!empty($post_id)) {
    // current color
    $term_color = wp_get_post_terms($post_id, 'product_color', [
        'fields' => 'ids',
    ]);
    $product_color = $term_color ? $term_color[0] : '';
} else {
    $product_color = dokan_posted_input('product_color');
}

// color terms
$terms_color = get_terms([
    'taxonomy' => 'product_color',
    'hide_empty' => false,
]);
@endphp
<div class="color">
  <label for="product_color" class="form-label">{{ _e('Color', 'dokan-lite') }}</label>
  <select name="product_color" id="product_color" class="product_color dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true">
    <option value="">{{ _e('Select a Color', 'dokan-lite') }}</option>
    @if (!empty($terms_color))
      @foreach ($terms_color as $term)
        <option {{ $term->term_id == $product_color ? 'selected' : '' }} value="{{ $term->term_id }}">{{ $term->name }}</option>
      @endforeach
    @endif
  </select>
</div>
