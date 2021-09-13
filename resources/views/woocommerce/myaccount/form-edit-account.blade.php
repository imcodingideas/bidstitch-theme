@php do_action('woocommerce_before_edit_account_form') @endphp

<div class="grid space-y-8">
  <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
    {{ esc_html_e('Account Settings', 'sage') }}
  </h2>

  <form class="grid space-y-8 shadow rounded-sm p-8 bg-white woocommerce-EditAccountForm edit-account" action=""
    method="post" {{ do_action('woocommerce_edit_account_form_tag') }}>

    @php do_action('woocommerce_edit_account_form_start') @endphp

    <x-form-group>
      <x-form-label for="account_first_name" required>{{ _e('First Name', 'sage') }}</x-form-label>
      <x-form-input type="text" name="account_first_name" id="account_first_name"
        value="{{ esc_attr($user->first_name) }}" required />
    </x-form-group>

    <x-form-group>
      <x-form-label for="account_last_name" required>{{ _e('Last Name', 'sage') }}</x-form-label>
      <x-form-input type="text" name="account_last_name" id="account_last_name"
        value="{{ esc_attr($user->last_name) }}" required />
    </x-form-group>

    <x-form-group>
      <x-form-label for="account_display_name" required>{{ _e('Display Name', 'sage') }}</x-form-label>
      <x-form-input type="text" name="account_display_name" id="account_display_name"
        value="{{ esc_attr($user->display_name) }}" required />
    </x-form-group>

    <x-form-group>
      <x-form-label for="account_email" required>{{ _e('Email Address', 'sage') }}</x-form-label>
      <x-form-input type="email" name="account_email" id="account_email" value="{{ esc_attr($user->user_email) }}"
        required />
    </x-form-group>

    <div class="grid space-y-8">
      <h2 class="font-bold">{{ esc_html_e('Password Change', 'sage') }}</h2>

      <x-form-group>
        <x-form-label for="password_current">{{ _e('Current password (leave blank to leave unchanged)', 'sage') }}
        </x-form-label>
        <x-form-input type="password" name="password_current" id="password_current" autocomplete="off" />
      </x-form-group>

      <x-form-group>
        <x-form-label for="password_1">{{ _e('New password (leave blank to leave unchanged)', 'sage') }}
        </x-form-label>
        <x-form-input type="password" name="password_1" id="password_1" autocomplete="off" />
      </x-form-group>

      <x-form-group>
        <x-form-label for="password_2">{{ _e('Confirm new password', 'sage') }}</x-form-label>
        <x-form-input type="password" name="password_2" id="password_2" autocomplete="off" />
      </x-form-group>
    </div>

    @php do_action('woocommerce_edit_account_form') @endphp

    <div class="flex">
      @php wp_nonce_field('save_account_details', 'save-account-details-nonce') @endphp

      <button type="submit" class="btn btn--black btn--md" name="save_account_details"
        value="{{ esc_attr_e('Save changes', 'sage') }}">{{ esc_html_e('Save changes', 'sage') }}</button>

      <input type="hidden" name="action" value="save_account_details" />
    </div>

    @php do_action('woocommerce_edit_account_form_end') @endphp
  </form>
</div>

@php do_action('woocommerce_after_edit_account_form') @endphp
