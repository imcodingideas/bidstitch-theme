  <div class="dokan-form-group color">
    <label for="product_color" class="form-label">{{ _e('Color', 'dokan-lite') }}</label>
    <select name="product_color" id="product_color" class="product_color dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true">
      <option value="">{{ _e('Select a Color', 'dokan-lite') }}</option>
      @if (!empty($terms_color))
        @foreach ($terms_color as $term)
          <option value="{{ $term->term_id }}">{{ $term->name }}</option>
        @endforeach
      @endif
    </select>
  </div>
