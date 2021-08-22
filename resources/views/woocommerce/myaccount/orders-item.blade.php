@if ($order)
  <div class="grid gap-4 sm:gap-6">
    @include('woocommerce.myaccount.orders-item-header')
    @include('woocommerce.myaccount.orders-item-products')
  </div>
@endif