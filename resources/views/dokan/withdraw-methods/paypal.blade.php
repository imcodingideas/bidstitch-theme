<x-form-group>
  <x-form-label for="settings[paypal][email]" required>{{ _e('PayPal Email', 'sage') }}</x-form-label>
  <x-form-input type="email" name="settings[paypal][email]" id="settings[paypal][email]"
    value="{{ esc_attr($email) }}" required />
</x-form-group>
