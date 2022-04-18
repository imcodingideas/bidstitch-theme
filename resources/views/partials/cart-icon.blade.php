<li id="cart-menu-item" class="relative block">
  <a href="{{ wc_get_cart_url() }}" title="cart" class="">  
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M8 8L8 7C8 4.79086 9.79086 3 12 3V3C14.2091 3 16 4.79086 16 7L16 8" stroke="black" stroke-width="2" stroke-linecap="round"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M3.58579 7.58579C3 8.17157 3 9.11438 3 11V14C3 17.7712 3 19.6569 4.17157 20.8284C5.34315 22 7.22876 22 11 22H13C16.7712 22 18.6569 22 19.8284 20.8284C21 19.6569 21 17.7712 21 14V11C21 9.11438 21 8.17157 20.4142 7.58579C19.8284 7 18.8856 7 17 7H7C5.11438 7 4.17157 7 3.58579 7.58579ZM10 12C10 11.4477 9.55228 11 9 11C8.44772 11 8 11.4477 8 12V14C8 14.5523 8.44772 15 9 15C9.55228 15 10 14.5523 10 14V12ZM16 12C16 11.4477 15.5523 11 15 11C14.4477 11 14 11.4477 14 12V14C14 14.5523 14.4477 15 15 15C15.5523 15 16 14.5523 16 14V12Z" fill="black"/>
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