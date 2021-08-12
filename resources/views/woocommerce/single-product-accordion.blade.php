<div class="single-product-accordion__tab-wrapper">
  <div class="single-product-accordion__tab-item" id="tab-content">
    <div class="single-product-accordion__tab-top text-lg uppercase border-b pb-2 mb-2 font-bold tracking-widest cursor-pointer" data-tab="#tab-content">
      <p>{{ _e('Item Details', 'sage') }}</p>
    </div>
    {{-- content --}}
    <div class="single-product-accordion__tab-content hidden prose py-3">
      @php
        the_content();
      @endphp
    </div>
  </div>
  {{-- shipping --}}
  @include('woocommerce.single-product-accordion-shipping')
  {{-- offers --}}
  {{-- todo: I need an example to debug this: --}}
  {{-- @include('woocommerce.single-product-accordion-offers') --}}
</div>
