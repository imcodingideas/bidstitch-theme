@if ($dokan_is_seller_enabled)

  <form class="dokan-form-container" method="post">

    <div class="product-edit-container dokan-clearfix">

      @include('dokan.new-product-field-images')

      <div class="content-half-part dokan-product-meta">

      @include('dokan.new-product-field-name')

      @include('dokan.new-product-field-price')

      @include('dokan.new-product-field-excerpt')

      @include('dokan.new-product-field-category')

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
