  <div class="dokan-form-group condition">
    <label for="product_condition" class="form-label">
      {{ _e('Condition', 'dokan-lite') }}
      <span class="text-red-500">(required)</span>
    </label>
    <select name="product_condition" id="product_condition" class="product_condition dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true">
      <option value="">{{ _e('Select a condition', 'dokan-lite') }}</option>
      @if (!empty($terms_condition))
        @foreach ($terms_condition as $term)
          <option value="{{ $term->term_id }}">{{ $term->name }}</option>
        @endforeach
      @endif
    </select>
  </div>
