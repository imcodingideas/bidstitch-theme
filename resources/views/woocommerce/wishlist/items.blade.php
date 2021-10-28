<!-- This example requires Tailwind CSS v2.0+ -->
    <div class="grid space-y-8">
      <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
        {{ esc_html_e('My Wishlist', 'sage') }}
      </h2>

    <form class="grid space-y-8 shadow rounded-sm p-8 bg-white">
      <section aria-labelledby="cart-heading">
        <h2 id="cart-heading" class="sr-only">Items in your wishlist</h2>

        <ul role="list" class="border-gray-200 divide-y  divide-gray-200">

          @if($has_wishlist)
            @foreach($items as $item)
              <li class="flex py-6">
                <div class="flex-shrink-0">
                  <a href="{{ $item['product_link'] }}">
                    {!!  $item['product_image'] !!}
                  </a>
                </div>

                <div class="ml-4 flex-1 flex flex-col sm:ml-6">
                  <div>
                    <div class="flex justify-between">
                        <h4 class="text-sm max-w-xs">
                          <a href="{{ $item['product_link'] }}" class="font-bold text-gray-700 hover:text-gray-800">
                              {!! $item['product_title'] !!}
                          </a>
                        </h4>

                      @if ( $show_price || $show_price_variations )
                          <p class="ml-4 text-sm font-medium text-gray-900 text-right">
                            @if($show_price)
                              {!! $item['product_price'] !!}
                            @endif
                            @if($show_price_variations)
                              {!! $item['product_price_variation'] !!}
                            @endif
                          </p>
                      @endif
                    </div>

                    @if($item['store_name'])
                      <p class="mt-1 text-sm text-gray-500">
                        <a href="{{ $item['store_url'] }}">{!! $item['store_name'] !!}</a>
                      </p>
                    @endif

                    @if ( $show_variation && $item['is_type_variation'] )
                      <p class="mt-1 text-sm text-gray-500">
                          {!! $item['formatted_variation'] !!}
                      </p>
                    @endif

                  </div>

                  <div class="mt-4 flex-1 flex items-end justify-between">
                    @if($show_stock_status)
                      <p class="flex items-center text-sm text-gray-700 space-x-2">
                          @if($item['product_is_out_of_stock'])
                            <span>Out of stock</span>
                          @else
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span>In Stock</span>
                          @endif
                      </p>
                    @endif
                    @if ( $show_remove_product )
                      <div class="ml-4">
                        <a href="{{$item['product_remove_url']}}" title="Remove this product" class="text-sm font-medium text-red-600 hover:text-red-500">
                          <span>Remove</span>
                        </a>
                      </div>
                    @endif
                  </div>
                </div>
              </li>
            @endforeach
            @if ($pagination)
                <div class="pagination-wrap">
                  <ul class="pagination mt-0 mb-0">
                    <li>{!! $pagination !!}</li>
                  </ul>
                </div>
            @endif
          @endif
        </ul>
      </section>
    </form>
</div>

