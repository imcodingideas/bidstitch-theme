<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
{{-- changed: --}}
<div class="price-wrapper font-bold text-lg tracking-wider uppercase text-black">
  <p class="price product-price-title">{{ _e('Price', 'sage') }}</p>
  <p class="price product-page-price {{ $classes }}">
    {!! $price_html !!}
    <span class="woocommerce-price-chart">{{ $currency }}</span>
  </p>
</div>
