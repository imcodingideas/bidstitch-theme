<!-- This example requires Tailwind CSS v2.0+ -->
    <div class="grid space-y-8">
      <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
        {{ esc_html_e('My Wishlist', 'sage') }}
      </h2>

    <form class="grid space-y-8 shadow rounded-sm p-8 bg-white">
      <section aria-labelledby="cart-heading">
        <h2 id="cart-heading" class="sr-only">Items in your wishlist</h2>

        <ul role="list" class="border-gray-200 divide-y  divide-gray-200">

          @if($wishlist && $wishlist->has_items())
            @foreach($wishlist_items as $index => $item)
              <li class="flex py-6">
                <div class="flex-shrink-0">
                  <a href="{{esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) )}}">
                    {!!  $payload[$index]['product']->get_image('medium', ['class' => 'w-24 h-24 rounded-md object-center object-cover sm:w-32 sm:h-32'], true) !!}
                  </a>
                </div>

                <div class="ml-4 flex-1 flex flex-col sm:ml-6">
                  <div>
                    <div class="flex justify-between">
                        <h4 class="text-sm max-w-xs">
                          <a href="{{ esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) )}}" class="font-bold text-gray-700 hover:text-gray-800">
                              {!! wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $payload[$index]['product']->get_title(), $payload[$index]['product'] ) ) !!}
                          </a>
                        </h4>

                      @if ( $show_price || $show_price_variations )
                          <p class="ml-4 text-sm font-medium text-gray-900 text-right">
                            @if($show_price)
                              {!! $item->get_formatted_product_price() !!}
                            @endif
                            @if($show_price_variations)
                              {!! $item->get_price_variation() !!}
                            @endif
                          </p>
                      @endif
                    </div>

                    @if(isset($payload[$index]['store_name']))
                      <p class="mt-1 text-sm text-gray-500">
                        <a href="{{dokan_get_store_url($payload[$index]['vendor_id'])}}">{!! $payload[$index]['store_name'] !!}</a>
                      </p>
                    @endif

                    @if ( $show_variation && $payload[$index]['product']->is_type( 'variation' ) )
                      <p class="mt-1 text-sm text-gray-500">
                          {!! wc_get_formatted_variation( $payload[$index]['product'] ) !!}
                      </p>
                    @endif

                  </div>

                  <div class="mt-4 flex-1 flex items-end justify-between">
                    @if($show_stock_status)
                      <p class="flex items-center text-sm text-gray-700 space-x-2">
                          <!-- Heroicon name: solid/check -->
                          @if('out-of-stock' === $payload[$index]['stock_status'])
                            <span>{!! esc_html( apply_filters( 'yith_wcwl_out_of_stock_label', __( 'Out of stock', 'yith-woocommerce-wishlist' ) ) ) !!}</span>
                          @else
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span>{!! esc_html( apply_filters( 'yith_wcwl_in_stock_label', __( 'In Stock', 'yith-woocommerce-wishlist' ) ) ) !!}</span>
                          @endif
                      </p>
                    @endif
                    @if ( $show_remove_product )
                      <div class="ml-4">
                        <a href="{{esc_url( add_query_arg( 'remove_from_wishlist', $item->get_product_id() ) )}}" title="{!! esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ) !!}" class="text-sm font-medium text-red-600 hover:text-red-500">
                          <span>Remove</span>
                        </a>
                      </div>
                    @endif
                  </div>
                </div>
              </li>
            @endforeach
          @endif
        </ul>
      </section>
    </form>
</div>

