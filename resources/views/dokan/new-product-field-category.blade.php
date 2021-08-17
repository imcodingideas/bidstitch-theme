@if (dokan_get_option('product_category_style', 'dokan_selling', 'single') == 'single')
  <div class="dokan-form-group">
    <label class="form-label">{{ _e('Category', 'dokan-lite') }}</label>
    @php wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) ) @endphp
  </div>
@elseif ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'multiple' )
  <div class="dokan-form-group">
    <label class="form-label">{{ _e('Category', 'dokan-lite') }}</label>
    @php
      echo str_replace('<select', '<select data-placeholder="' . esc_attr__('Select product category', 'dokan-lite') . '" multiple="multiple" ', $drop_down_category); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
    @endphp
  </div>
@endif
