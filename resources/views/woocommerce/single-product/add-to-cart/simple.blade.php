@if ($product->is_purchasable())
  {!! wc_get_stock_html($product) !!}

  @if ($product->is_in_stock())
    <div class="grid space-y-4 my-6">
      @php do_action('woocommerce_before_add_to_cart_form') @endphp

      <form class="cart" action="{!! esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())) !!}" method="post" enctype='multipart/form-data'>
        @php do_action('woocommerce_before_add_to_cart_button') @endphp

        <div class="hidden">
          @php do_action('woocommerce_before_add_to_cart_quantity') @endphp

          {!! woocommerce_quantity_input($quantity_input_params) !!}

          @php do_action('woocommerce_after_add_to_cart_quantity') @endphp
        </div>

        <button type="submit" name="add-to-cart" value="{!! esc_attr($product->get_id()) !!}"
          class="btn btn--black flex font-bold justify-center py-2 text-lg uppercase w-full">{!! esc_html($product->single_add_to_cart_text()) !!}</button>

        @php do_action('woocommerce_after_add_to_cart_button') @endphp
      </form>

      @php do_action('woocommerce_after_add_to_cart_form') @endphp

      @include('woocommerce.single-product.add-to-cart.offer')
    </div>
  @endif
@endif
