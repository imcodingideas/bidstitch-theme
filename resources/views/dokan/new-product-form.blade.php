@if ($dokan_is_seller_enabled)

  <form class="dokan-form-container" method="post">

    <div class="product-edit-container dokan-clearfix">

      @include('dokan.new-product-field-images')

      <div class="content-half-part dokan-product-meta">

      @include('dokan.new-product-field-name')

        <div class="dokan-form-group">
          <div class="dokan-form-group dokan-clearfix dokan-price-container">
            <div class="content-half-part">
              <label for="_regular_price" class="dokan-form-label">{{ _e('Price', 'dokan-lite') }}</label>
              <div class="dokan-input-group">
                <span class="dokan-input-group-addon">{!! get_woocommerce_currency_symbol() !!}</span>
                <input type="text" class="dokan-form-control wc_input_price dokan-product-regular-price" name="_regular_price" placeholder="0.00" id="_regular_price" value="{{ dokan_posted_input('_regular_price') }}">
              </div>
            </div>

            <div class="content-half-part sale-price">
              <label for="_sale_price" class="form-label">
                {{ _e('Discounted Price', 'dokan-lite') }}
                <a href="#" class="sale_schedule">{{ _e('Schedule', 'dokan-lite') }}</a>
                <a href="#" class="cancel_sale_schedule dokan-hide">{{ _e('Cancel', 'dokan-lite') }}</a>
              </label>

              <div class="dokan-input-group">
                <span class="dokan-input-group-addon">{!! get_woocommerce_currency_symbol() !!}</span>
                <input type="text" class="dokan-form-control wc_input_price dokan-product-sales-price" name="_sale_price" placeholder="0.00" id="_sale_price" value="{{ dokan_posted_input('_sale_price') }}">
              </div>
            </div>
          </div>

          <div class="dokan-hide sale-schedule-container sale_price_dates_fields dokan-clearfix dokan-form-group">
            <div class="content-half-part from">
              <div class="dokan-input-group">
                <span class="dokan-input-group-addon">{{ _e('From', 'dokan-lite') }}</span>
                <input type="text" name="_sale_price_dates_from" class="dokan-form-control datepicker sale_price_dates_from" maxlength="10" value="{{ dokan_posted_input('_sale_price_dates_from') }}" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="{{ _e('YYYY-MM-DD', 'dokan-lite') }}">
              </div>
            </div>

            <div class="content-half-part to">
              <div class="dokan-input-group">
                <span class="dokan-input-group-addon">{{ _e('To', 'dokan-lite') }}</span>
                <input type="text" name="_sale_price_dates_to" class="dokan-form-control datepicker sale_price_dates_to" value="{{ dokan_posted_input('_sale_price_dates_to') }}" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="{{ _e('YYYY-MM-DD', 'dokan-lite') }}">
              </div>
            </div>
          </div><!-- .sale-schedule-container -->
        </div>

        <div class="dokan-form-group">
          <textarea name="post_excerpt" id="post-excerpt" rows="5" class="dokan-form-control" placeholder="{{ _e('Short description of the product...', 'dokan-lite') }}">{{ dokan_posted_textarea('post_excerpt') }}</textarea>
        </div>

        @if (dokan_get_option('product_category_style', 'dokan_selling', 'single') == 'single')
          <div class="dokan-form-group">
            @php wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) ) @endphp
          </div>
        @elseif ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'multiple' )
          <div class="dokan-form-group">
            @php
              echo str_replace('<select', '<select data-placeholder="' . esc_attr__('Select product category', 'dokan-lite') . '" multiple="multiple" ', $drop_down_category); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
            @endphp
          </div>
        @endif
        
        @include('dokan.new-product-field-condition')

        @include('dokan.new-product-field-size')

        @include('dokan.new-product-field-color')

        @include('dokan.new-product-field-pit-to-pit')

        @include('dokan.new-product-field-length')

        @include('dokan.new-product-field-tag-type')

        @include('dokan.new-product-field-stitching')

        <div class="dokan-form-group">
          <label for="product_tag" class="form-label">{{ _e('Tags', 'dokan-lite') }}</label>
          <select multiple="multiple" placeholder="{{ $tags_placeholder }}" name="product_tag[]" id="product_tag_search" class="product_tag_search product_tags dokan-form-control dokan-select2" data-placeholder="{{ $tags_placeholder }}"></select>
        </div>

        @php do_action( 'dokan_new_product_after_product_tags' ) @endphp
      </div>
    </div>

    <div class="dokan-form-group">
      <label for="post_content" class="control-label">{{ _e('Description', 'dokan-lite') }} <i class="fa fa-question-circle tips" data-title="{{ esc_attr_e('Add your product description', 'dokan-lite') }}" aria-hidden="true"></i></label>
      @php wp_editor( htmlspecialchars_decode( $post_content, ENT_QUOTES ), 'post_content', array('editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_content') ) @endphp
    </div>

    @php do_action( 'dokan_new_product_form' ) @endphp

    <hr>

    <div class="dokan-form-group dokan-right">
      @php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ) @endphp
      @if ($display_create_and_add_new_button)
        <button type="submit" name="add_product" class="dokan-btn dokan-btn-default" value="create_and_add_new">{{ _e('Create & Add New', 'dokan-lite') }}</button>
      @endif
      <button type="submit" name="add_product" class="dokan-btn dokan-btn-default dokan-btn-theme" value="create_new">{{ _e('Create Product', 'dokan-lite') }}</button>
    </div>

  </form>

@else
  @php dokan_seller_not_enabled_notice() @endphp
@endif
