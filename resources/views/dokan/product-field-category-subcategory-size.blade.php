{{-- category --}}
<div class="dokan-form-group category" id="product-field-category-subcategory-size">
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

{{-- subcategory --}}
<div class="dokan-form-group subcate relative">
  <label for="product_sub_cat" class="form-label">{{ _e('SubCategory', 'dokan-lite') }} <div class="product-field-category-subcategory-size__loading-sub text-xs ml-3 absolute right-0 top-0 hidden">loading...</div> </label><br>
  <select name="product_cat_sub" id="product_cat_sub" class="product_cat_sub dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true" placeholder="{{ _e('Select a sub category', 'dokan-lite') }}" data-slug="true">
    <option value="">{{ _e('Select a sub category', 'dokan-lite') }}</option>
    @if (!empty($subcategory_terms))
      @foreach ($subcategory_terms as $term)
        <option {{ $term->term_id == $product_cat_sub ? 'selected' : '' }} value="{{ $term->term_id }}" slug="{{ $term->slug }}">{{ $term->name }}</option>
      @endforeach
    @endif
  </select>
</div>

{{-- size --}}
<div class="size relative">
  <label for="product_size" class="form-label flex">{{ _e('Size', 'dokan-lite') }} <div class="product-field-category-subcategory-size__loading-size text-xs ml-3 absolute right-0 top-0 hidden">loading...</div> </label>
  <select name="product_size" id="product_size" class="product_size dokan-form-control dokan-select2" tabindex="-1" aria-hidden="true">
    <option value="">{{ _e('Select a Size', 'dokan-lite') }}</option>
    @if (!empty($size_terms))
      @foreach ($size_terms as $term)
        <option {{ $term->term_id == $product_size ? 'selected' : '' }} value="{{ $term->term_id }}">{{ $term->name }}</option>
      @endforeach
    @endif
  </select>
</div>
