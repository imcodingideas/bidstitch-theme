@php
/**
* Mini-cart
*
* Contains the markup for the mini-cart, used by the cart widget.
*
* This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 5.2.0
*/
@endphp
<div class="widget_shopping_cart_content">
  @php do_action( 'woocommerce_before_mini_cart' ) @endphp

  @if ($cart_empty)

    <p class="woocommerce-mini-cart__empty-message">{{ _e('No products in the cart.', 'woocommerce') }}</p>

  @else

    <ul class="woocommerce-mini-cart cart_list flex flex-col space-y-2 {{ $args['list_class'] }}">
      @php do_action( 'woocommerce_before_mini_cart_contents' ) @endphp
      @foreach ($products as $product)
        @include('woocommerce.cart.mini-cart-product')
      @endforeach
      @php do_action( 'woocommerce_mini_cart_contents' ) @endphp
    </ul>

    <p class="border-b px-2 py-1 text-gray-800 text-lg text-right total woocommerce-mini-cart__total">
      @php do_action( 'woocommerce_widget_shopping_cart_total' ) @endphp
    </p>

    @php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ) @endphp

    <p class="woocommerce-mini-cart__buttons buttons flex flex-col items-center mt-3 space-y-2">@php do_action( 'woocommerce_widget_shopping_cart_buttons' )@endphp</p>

    @php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ) @endphp

  @endif

  @php do_action( 'woocommerce_after_mini_cart' ) @endphp
</div>