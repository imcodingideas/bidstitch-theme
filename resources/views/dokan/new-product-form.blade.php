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

        @include('dokan.new-product-field-tags')

      </div>
    </div>

        @include('dokan.new-product-field-description')

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
