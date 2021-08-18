<div class="">
  <label for="product_tag" class="form-label">{{ _e('Tags', 'dokan-lite') }}</label>
  <select multiple="multiple" placeholder="{{ $tags_placeholder }}" name="product_tag[]" id="product_tag_search" class="product_tag_search product_tags dokan-form-control dokan-select2" data-placeholder="{{ $tags_placeholder }}"></select>
</div>

@php do_action( 'dokan_new_product_after_product_tags' ) @endphp
