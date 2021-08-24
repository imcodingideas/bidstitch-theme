{{-- When category is modified these are modified: --}}
{{-- - subcategory --}}
{{-- - sizes --}}
<form class="dokan-product-edit-formx dokan-form-container" role="form" method="post">

  <div class="product-edit-container dokan-clearfix">
    <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
      <div class="flex flex-col lg:w-1/3 space-y-4 lg:space-y-5">
        @include('dokan.new-product-field-title')
        @include('dokan.new-product-field-condition')
        @include('dokan.new-product-field-category')
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

  <input type="hidden" name="post_excerpt" />
  <div class="submit-save-pro">
    <input type="hidden" id="_stock" name="_stock" value="<?php echo $_stock; ?>">
    <input type="hidden" id="_manage_stock" name="_manage_stock" value="<?php echo $_manage_stock; ?>">
    <input type="hidden" id="_backorders" name="_backorders" value="<?php echo $_backorders; ?>">
    <input type="hidden" id="post_status" name="post_status" value="publish">
    <input type="hidden" name="dokan_update_product" value="<?php esc_attr_e('Save Product', 'dokan-lite'); ?>" />
    <input type="submit" name="dokan_update_product" class="btn btn--white btn--md mt-6" value="<?php esc_attr_e('Save Listing', 'dokan-lite'); ?>" />
  </div>
  <div class="dokan-clearfix"></div>
</form>
