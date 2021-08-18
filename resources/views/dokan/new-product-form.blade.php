@if ($dokan_is_seller_enabled)

  <h2 class="h3">Listing details</h2>

  <form class="dokan-form-container mt-6" method="post">

    <div class="product-edit-container dokan-clearfix">
      <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-5 lg:space-y-0 lg:space-x-4">
        <div class="flex flex-col lg:w-1/3 space-y-4 lg:space-y-5">
          @include('dokan.new-product-field-name')
          @include('dokan.new-product-field-condition')
          @include('dokan.new-product-field-category')
          <div class="">
            todo: subcategory
          </div>
          @include('dokan.new-product-field-pit-to-pit')
          @include('dokan.new-product-field-length')
        </div>

        <div class="flex flex-col lg:w-1/3 space-y-4 lg:space-y-5">
          @include('dokan.new-product-field-description')
          @include('dokan.new-product-field-size')
          @include('dokan.new-product-field-color')
          @include('dokan.new-product-field-tag-type')
          @include('dokan.new-product-field-stitching')
        </div>
        <div class="lg:w-1/3">
          @include('dokan.new-product-field-images')
        </div>
      </div>

      <div class="mt-4">
        <h2 class="h3">Selling details</h2>
        <div class="mt-3 lg:pr-4 lg:w-1/3">
          @include('dokan.new-product-field-price')
        </div>
      </div>
    </div>

    @php do_action( 'dokan_new_product_form' ) @endphp

    <div class="mt-4">
      @php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ) @endphp
      <button type="submit" name="add_product" class="btn btn--white btn--md mt-6" value="create_new">
        {{ _e('Add Listing', 'dokan-lite') }}
      </button>
    </div>

  </form>

@else
  @php dokan_seller_not_enabled_notice() @endphp
@endif
