@if ($content)
  <div class="single-product-accordion__tab-item" id="tab-content">
    <div class="single-product-accordion__tab-top text-lg uppercase border-b pb-2 mb-2 font-bold tracking-widest cursor-pointer" data-tab="#tab-content">
      <p>{{ _e('Item Details', 'sage') }}</p>
    </div>
    <div class="single-product-accordion__tab-content hidden prose py-3">
      {!! $content !!}
    </div>
  </div>
@endif
