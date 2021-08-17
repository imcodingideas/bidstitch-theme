<div class="content-half-part featured-image">
  <div class="featured-image">
    <div class="dokan-feat-image-upload">
      <div class="instruction-inside {{ $hide_instruction }}">
        <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="{{ $posted_img }}">
        <i class="fa fa-cloud-upload"></i>
        <a href="#" class="dokan-feat-image-btn dokan-btn">{{ _e('Upload Product Image', 'dokan-lite') }}</a>
      </div>

      <div class="image-wrap {{ $hide_img_wrap }}">
        <a class="close dokan-remove-feat-image">&times;</a>
        <img src="{{ $posted_img_url }}" alt="">
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
            <a href="#" class="add-product-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </li>
        </ul>
        <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
      </div>
    </div>
  </div> <!-- .product-gallery -->

  @php do_action( 'dokan_product_gallery_image_count' ) @endphp
</div>
