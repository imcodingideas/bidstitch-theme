{{-- My Account page

This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.5.0 --}}

<div class="bg-gray-100">
  <div class="lg:container">
    <div class="flex flex-wrap lg:flex-nowrap min-h-screen">
      <div class="w-full lg:w-72 lg:border-r relative">
        <div class="hidden lg:block bg-white right-0 w-screen h-screen absolute"></div>
        <div class="relative">
          @if (is_user_logged_in())
            @include('woocommerce.myaccount.navigation')
          @endif
        </div>
      </div>
      <div class="w-full mx-auto sm:max-w-screen-sm md:max-w-screen-md lg:max-w-full lg:mx-0 p-8">
        @php do_action('woocommerce_account_content') @endphp
      </div>
    </div>
  </div>
</div>
