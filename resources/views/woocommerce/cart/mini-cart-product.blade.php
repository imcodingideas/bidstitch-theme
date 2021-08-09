<li class="border-b flex justify-between mb-2 mini_cart_item pb-2 woocommerce-mini-cart-item {{ $product['woocommerce_mini_cart_item_class'] }}">
  <div class="w-3/12">
    @if (empty($product['product_permalink']))
      {!! $product['thumbnail'] !!}
    @else
      <a href="{{ $product['product_permalink'] }}">
        {!! $product['thumbnail'] !!}
      </a>
    @endif
  </div>
  <div class="flex flex-col space-y-1 w-7/12 px-2">
    <div class="leading-tight">
      {!! $product['sanitized_product_name'] !!}
    </div>
    <div class="font-bold text-gray-600 text-xs uppercase variation">
      {!! $product['formatted_cart_item_data_cart_item'] !!}
      <div class="text-sm font-bold text-gray-900">
        {!! $product['filtered_quantity'] !!}
      </div>
    </div>
  </div>
  <div class="">
    {!! $product['remove_link'] !!}
  </div>
</li>
