{{-- @if (dokan_get_option('product_category_style', 'dokan_selling', 'single') == 'single') --}}
<div class="dokan-form-group category">
  <label for="product_cat" class="form-label">{{ _e('Category', 'dokan-lite') }}</label><br>
  <select name="product_cat" id="product_cat" class="product_cat dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true" placeholder="{{ _e('Select a category', 'dokan-lite') }}">
    <option value="">{{ _e('Select a category', 'dokan-lite') }}</option>
    @if (!empty($category_terms))
      @foreach ($category_terms as $term)
        <option {{ $term->term_id == $product_cat ? 'selected' : '' }} value="{{ $term->term_id }}" slug="{{ $term->slug }}">{{ $term->name }}</option>
      @endforeach
    @endif
  </select>
</div>
<div class="dokan-form-group subcate">
  <label for="product_sub_cat" class="form-label">{{ _e('SubCategory', 'dokan-lite') }}</label><br>
  <select name="product_cat_sub" id="product_cat_sub" class="product_cat_sub dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true" placeholder="{{ _e('Select a sub category', 'dokan-lite') }}" data-slug="true">
    <option value="">{{ _e('Select a sub category', 'dokan-lite') }}</option>
    @if (!empty($subcategory_terms))
      @foreach ($subcategory_terms as $term)
        <option {{ $term->term_id == $product_cat_sub ? 'selected' : '' }} value="{{ $term->term_id }}" slug="{{ $term->slug }}">{{ $term->name }}</option>
      @endforeach
    @endif
  </select>
</div>
