{{-- Lost password form

This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

 @see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.5.2 --}}

<div class="mx-auto w-full max-w-md py-8 lg:py-16 space-y-4">
  @include('woocommerce.notices')

  <div class="bg-white rounded shadow-md overflow-hidden p-4 lg:p-8 space-y-4 lg:space-y-8">
    <h2 class="text-center text-xl font-bold text-gray-900">{{ _e('Reset Password', 'sage') }}</h2>
    <p>
      {{ _e('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'sage') }}
    </p>
    <form method="post" class="space-y-4 lg:space-y-6 lost_reset_password">
      <x-form-group>
        <x-form-label for="user_login" required>{{ _e('Username or email', 'sage') }}</x-form-label>
        <x-form-input type="text" name="user_login" id="user_login" required autocomplete="username" />
      </x-form-group>

      @php do_action('woocommerce_lostpassword_form') @endphp

      <input type="hidden" name="wc_reset_password" value="true" />
      <button type="submit" class="btn btn--black w-full py-2 justify-center"
        value="{{ esc_attr_e('Reset password', 'sage') }}">{{ _e('Reset password', 'sage') }}</button>

      <div class="hidden">
        @php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce') @endphp
      </div>

    </form>
    <div class="grid gap-y-4">
      <a href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) }}"
        class="text-sm text-center account__tabs__toggle">
        <span>{{ _e('Remember your password?', 'sage') }}</span>
        <span class="underline">{{ _e('Log In', 'sage') }}</span>
      </a>
    </div>
  </div>
</div>
