{{-- @see https://docs.woocommerce.com/document/template-structure/
@author  WooThemes
@package WooCommerce/Templates
@version 4.1.0 --}}

<div class="mx-auto w-full max-w-md py-8 lg:py-16 space-y-4">
  @include('woocommerce.notices')
  <div class="bg-white rounded shadow-md overflow-hidden">
    <div class="grid grid-cols-2 text-center">
      <a class="block p-3 font-bold account__tabs__toggle bg-white" href="#login">{{ _e('Log In', 'sage') }}</a>
      <a class="block p-3 font-bold account__tabs__toggle bg-gray-100" href="#register">{{ _e('Sign Up', 'sage') }}</a>
    </div>

    <div class="p-4 lg:p-6 account__tabs__content">
      {{-- Login --}}
      <div id="login" class="account__tabs__item block">
        <div class="space-y-4 lg:space-y-6">
          <h2 class="text-center text-xl font-bold text-gray-900">{{ _e('Sign in to your account', 'sage') }}</h2>
          <form class="space-y-4 lg:space-y-6 login" method="post">
            <x-form-group>
              <x-form-label for="username" required>{{ _e('Username or Email', 'sage') }}</x-form-label>
              <x-form-input type="text" name="username" id="username" defaultValue="username" required />
            </x-form-group>

            <x-form-group>
              <x-form-label for="password" required>{{ _e('Password', 'sage') }}</x-form-label>
              <x-form-input type="password" name="password" id="password" defaultValue="password" required />
            </x-form-group>

            @php do_action('woocommerce_login_form') @endphp

            <div class="grid gap-y-4 sm:gap-y-0 sm:flex justify-between items-center">
              <x-form-label class="flex items-center space-x-2 leading-none row-start-2 sm:row-auto">
                <x-form-checkbox name="rememberme" id="rememberme" value="forever" />
                <span>{{ _e('Remember me', 'woocommerce') }}</span>
              </x-form-label>
              <a href="{{ esc_url(wp_lostpassword_url()) }}" class="text-sm leading-none"
                target="_blank">{{ _e('Lost your password?', 'sage') }}</a>
            </div>

            <div class="hidden">
              {!! wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce') !!}
            </div>

            <button type="submit" class="btn btn--black w-full py-2 justify-center" name="login"
              value="{{ esc_attr_e('Login', 'sage') }}">{{ _e('Log in', 'sage') }}</button>
          </form>
          <div class="space-y-4 lg:space-y-6 grid justify-center">
            <a href="#register" class="text-sm text-center account__tabs__toggle">
              <span>{{ _e('Don\'t have an account?', 'sage') }}</span>
              <span class="underline">{{ _e('Sign Up', 'sage') }}</span>
            </a>
          </div>
        </div>
      </div>
      {{-- Register --}}
      <div id="register" class="account__tabs__item hidden">
        <div class="space-y-4 lg:space-y-6">
          <h2 class="text-center text-xl font-bold text-gray-900">{{ _e('Create an account', 'sage') }}</h2>
          <form method="post" class="space-y-4 lg:space-y-6 register">

            @if (!$auto_generate_username)
              <x-form-group>
                <x-form-label for="reg_username" required>{{ _e('Username', 'sage') }}</x-form-label>
                <x-form-input type="text" name="username" id="reg_username" defaultValue="username" required />
              </x-form-group>
            @endif

            <x-form-group>
              <x-form-label for="reg_email" required>{{ _e('Email address', 'sage') }}</x-form-label>
              <x-form-input type="email" name="email" id="reg_email" defaultValue="email" required />
            </x-form-group>

            @if (!$auto_generate_password)
              <x-form-group>
                <x-form-label for="reg_password" required>{{ _e('Password', 'sage') }}</x-form-label>
                <x-form-input type="password" name="password" id="reg_password" required />
              </x-form-group>
            @endif

            @php do_action('woocommerce_register_form') @endphp

            <div class="hidden">
              @php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce') @endphp
            </div>

            <button type="submit" class="btn btn--black w-full py-2 justify-center" name="register"
              value="{{ esc_attr_e('Register', 'sage') }}">{{ _e('Register', 'sage') }}</button>
          </form>
          <div class="space-y-4 lg:space-y-6 grid justify-center">
            <a href="#login" class="text-sm account__tabs__toggle">
              <span>{{ _e('Already have an account?', 'sage') }}</span>
              <span class="underline">{{ _e('Log in', 'sage') }}</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
