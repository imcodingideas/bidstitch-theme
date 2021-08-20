@php $order = wc_get_order($customer_order) @endphp
<div class="grid gap-4 sm:gap-6">
  @include('woocommerce.myaccount.orders-item-header')
  @include('woocommerce.myaccount.orders-item-products')
</div>
