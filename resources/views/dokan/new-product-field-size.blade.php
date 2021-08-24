  <div class=" size">
    <label for="product_size" class="form-label">{{ _e('Size', 'dokan-lite') }}</label>
    <select name="product_size" id="product_size" class="product_size dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true">
      <option value="">{{ _e('Select a Size', 'dokan-lite') }}</option>
      @if (!empty($terms_size))
        @foreach ($terms_size as $term)
          <option {{ $term->term_id == $product_size ? 'selected' : '' }} value="{{ $term->term_id }}">{{ $term->name }}</option>
        @endforeach
      @endif
    </select>
  </div>
