<div class="content-half-part featured-image">
  <div class="featured-image">
    <div class="dokan-feat-image-upload">
      <div class="instruction-inside">
        <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="{{ $feat_image_id }}">
        <img class="w-28 mx-auto mb-2" src="@asset('images/cloud-upload-alt-solid.svg')" alt="upload" />
        <a href="#" class="dokan-feat-image-btn dokan-btn">{{ _e('Upload Product Image', 'dokan-lite') }}</a>
      </div>

      <div class="image-wrap {{ empty($feat_image_url) ? 'hidden' : '' }}">
        <a class="close dokan-remove-feat-image">&times;</a>
        <img src="{{ $feat_image_url }}" alt="">
      </div>
    </div>
  </div>

  <div class="dokan-product-gallery">
    <div class="dokan-side-body" id="dokan-product-images">
      <div id="product_images_container">
        <ul class="product_images dokan-clearfix">
          @if ($gallery_items)
            @foreach ($gallery_items as $item)
              <li class="image" data-attachment_id="{{ $item['id'] }}">
                <img src="{{ $item['url'] }}" alt="">
                <a href="#" class="action-delete" title="{{ _e('Delete image', 'dokan-lite') }}">&times;</a>
              </li>
            @endforeach
          @endif
          <li class="add-image add-product-images tips" data-title="{{ _e('Add gallery image', 'dokan-lite') }}">
            <a href="#" class="add-product-images flex justify-center">
              <img class="w-4" src="@asset('images/plus-solid.svg')" alt="plus" />
            </a>
          </li>
        </ul>
        <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
      </div>
    </div>
  </div> <!-- .product-gallery -->

  @php do_action( 'dokan_product_gallery_image_count' ) @endphp
</div>
