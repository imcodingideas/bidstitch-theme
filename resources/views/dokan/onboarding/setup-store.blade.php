<form method="post" class="space-y-4 lg:space-y-6 onboarding__form">
  <x-form-group>
    <x-form-label for="address[street_1]" required>{{ _e('Street Addresss', 'sage') }}</x-form-label>
    <x-form-input type="text" name="address[street_1]" id="address[street_1]" value="{{ $address_street1 }}"
      required />
  </x-form-group>

  <x-form-group>
    <x-form-label for="address[street_2]">{{ _e('Street Addresss 2', 'sage') }}</x-form-label>
    <x-form-input type="text" name="address[street_2]" id="address[street_2]" value="{{ $address_street2 }}" />
  </x-form-group>

  <x-form-group>
    <x-form-label for="address[city]" required>{{ _e('City', 'sage') }}</x-form-label>
    <x-form-input type="text" name="address[city]" id="address[city]" value="{{ $address_city }}" required />
  </x-form-group>

  <x-form-group>
    <x-form-label for="address[zip]" required>{{ _e('Zip Code', 'sage') }}</x-form-label>
    <x-form-input type="text" name="address[zip]" id="address[zip]" value="{{ $address_zip }}" required />
  </x-form-group>

  <x-form-group>
    <x-form-label for="address[country]" required>{{ _e('Country', 'sage') }}</x-form-label>
    <select name="address[country]"
      class="text-sm appearance-none w-full px-3 py-2 border border-gray-300 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black onboarding__field--country"
      id="address[country]" required>
      {!! dokan_country_dropdown($countries, $address_country, false) !!}
    </select>
  </x-form-group>

  <x-form-group>
    <x-form-label for="calc_shipping_state" required>{{ _e('State', 'sage') }}</x-form-label>
    <x-form-input type="text" name="address[state]" id="calc_shipping_state" value="{{ $address_state }}"
      class="onboarding__field--state" placeholder="{{ esc_attr_e('State Name', 'sage') }}" required />
  </x-form-group>

  @php do_action('dokan_seller_wizard_store_setup_after_address_field') @endphp

  <div class="flex space-x-4 items-center">
    <input type="submit" class="btn btn--black btn--md cursor-pointer" value="{{ esc_attr_e('Next Step', 'sage') }}"
      name="save_step" />
    {!! wp_nonce_field('dokan-seller-setup') !!}
  </div>
</form>
