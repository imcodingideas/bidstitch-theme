@php $order = wc_get_order($customer_order) @endphp
<div>
  @include('woocommerce.myaccount.orders-item-header')
  @include('woocommerce.myaccount.orders-item-products')
</div>
