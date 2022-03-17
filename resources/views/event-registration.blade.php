<main id="main" class="main container py-8">
  <h2 class="mb-4 text-center text-xl font-bold text-gray-900">Sign Up</h2>
  <form method="post" class="space-y-4 lg:space-y-6 register">
    <x-form-group>
      <x-form-label for="reg_email" required>{{ _e('Email address', 'sage') }}</x-form-label>
      <x-form-input type="email" name="email" id="reg_email" defaultValue="email" required />
    </x-form-group>

    <x-form-group>
      <x-form-label for="reg_password" required>{{ _e('Password', 'sage') }}</x-form-label>
      <x-form-input type="password" name="password" id="reg_password" required />
    </x-form-group>

    <div class="hidden">
      @php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce') @endphp
    </div>

    <button type="submit" class="btn btn--black w-full py-2 justify-center" name="register"
      value="{{ esc_attr_e('Register', 'sage') }}">{{ _e('Register', 'sage') }}</button>
  </form>
</main>
