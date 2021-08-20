<table class="w-full text-gray-500">
  <caption class="sr-only">
    {{ _e('Products', 'sage') }}
  </caption>
  <thead class="sr-only text-sm text-gray-500 text-left sm:not-sr-only">
    <tr>
      <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">{{ _e('Product', 'sage') }}</th>
      <th scope="col" class="hidden w-1/5 pr-8 py-3 font-normal sm:table-cell">{{ _e('Price', 'sage') }}</th>
      <th scope="col" class="hidden pr-8 py-3 font-normal sm:table-cell">{{ _e('Sold by', 'sage') }}</th>
      <th scope="col" class="w-0 py-3 font-normal text-right">{{ _e('Info', 'sage') }}</th>
    </tr>
  </thead>
  <tbody class="border-b border-gray-200 divide-y divide-gray-200 text-sm sm:border-t">
    @foreach ($order->get_items() as $item_id => $item)
      @php
        $item_name = $item->get_name();
        $item_total = wc_price($item->get_total());
        
        $product = $item->get_product();
        
        $vendor_id = $product->post->post_author;
        
        $store = dokan_get_store_info($vendor_id);
        $store_name = $store['store_name'];
        $store_url = dokan_get_store_url($vendor_id);
      @endphp
      <tr>
        <td class="py-6 pr-8">
          <div class="flex items-center">
            {!! $product->get_image('thumbnail', ['class' => 'object-center object-cover rounded mr-6 order__product__img'], true) !!}
            <div>
              <div class="font-medium text-gray-900">{{ $item_name }}</div>
              <div class="mt-1 sm:hidden">{!! $item_total !!}</div>
            </div>
          </div>
        </td>
        <td class="hidden py-6 pr-8 sm:table-cell">
          {!! $item_total !!}
        </td>
        <td class="hidden py-6 pr-8 sm:table-cell">
          <a href="{{ esc_url($store_url) }}" class="">
            {{ $store_name }}
          </a>
        </td>
        <td class="py-6 font-medium text-right whitespace-nowrap">
          <a href="{{ esc_url($product->get_permalink()) }}"
            class="text-black underline tracking-wider">{{ _e('View', 'sage') }}<span class="hidden lg:inline">
              {{ _e('Product', 'sage') }}</span>
            <span class="sr-only">, {{ $item_name }}</span>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
