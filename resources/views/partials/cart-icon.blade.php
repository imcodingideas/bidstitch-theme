<li id="cart-menu-item" class="relative block">
  <a href="{{ wc_get_cart_url() }}" title="cart" class="">
    <svg class="w-5 h-5" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
      <path fill="currentColor" d="M528.12 301.319l47.273-58C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z">
      </path>
    </svg>
    <span class="-translate-y-2 absolute bg-yellow-400 flex h-4 items-center justify-center leading-none right-0 rounded-full text-xs top-0 transform translate-x-2 w-4">
      {{ WC()->cart->cart_contents_count }}
    </span>
  </a>
  <div id="cart-menu-details" class="absolute bg-white w-72 p-4 right-0 shadow-lg top-6 z-10 rounded hidden">
    @php
      woocommerce_mini_cart();
    @endphp
  </div>
</li>