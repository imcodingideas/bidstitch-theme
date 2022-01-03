<div class="grid grid-cols-2 gap-x-2 lg:gap-x-4 user-role">
  <label
    class="rounded border flex focus:outline-none items-center text-sm leading-none px-2 py-4 space-x-2 lg:space-x-4 lg:px-4">
    <input type="radio" name="role" value="customer" class="h-4 w-4 text-black border-gray-300 focus:ring-gray-500"
      {{ checked($role, 'customer') }}>
    <span>{{ _e('I\'m a buyer', 'sage') }}</span>
  </label>
  <label
    class="rounded border flex focus:outline-none items-center text-sm leading-none px-2 py-4 space-x-2 lg:space-x-4 lg:px-4">
    <input type="radio" name="role" value="seller" class="h-4 w-4 text-black border-gray-300 focus:ring-gray-500"
      {{ checked($role, 'seller') }}>
    <span>{{ _e('I\'m a seller', 'sage') }}</span>
  </label>
</div>

@php do_action('dokan_registration_form_role', $role) @endphp

<div class="show_if_seller space-y-4 lg:space-y-6" style="{{ $role === 'customer' ? 'display:none;' : '' }}">
  <div class="grid grid-cols-2 gap-x-2 lg:gap-x-4">
    <x-form-group>
      <x-form-label for="first-name" required>{{ _e('First name', 'sage') }}</x-form-label>
      <x-form-input type="text" name="fname" id="first-name" defaultValue="fname" required />
    </x-form-group>
    <x-form-group>
      <x-form-label for="last-name" required>{{ _e('Last name', 'sage') }}</x-form-label>
      <x-form-input type="text" name="lname" id="last-name" defaultValue="lname" required />
    </x-form-group>
  </div>

  <x-form-group>
    <x-form-label for="company-name" required>{{ _e('Shop name', 'sage') }}</x-form-label>
    <x-form-input type="text" name="shopname" id="company-name" defaultValue="shopname" required />
  </x-form-group>

  <x-form-group>
    <div class="flex items-center">
      <x-form-label for="seller-url" required>{{ _e('Shop URL', 'sage') }}</x-form-label>
      <span
        class="ml-2 font-bold inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-gray-100 text-gray-800"
        id="url-alart-mgs"></span>
    </div>
    <div class="space-y-1">
      <x-form-input type="text" name="shopurl" id="seller-url" defaultValue="shopurl" required />
      <span class="text-xs">{{ $store_base_url }}/<strong id="url-alart"></strong></span>
    </div>
  </x-form-group>

  @php do_action('dokan_seller_registration_after_shopurl_field') @endphp

  <x-form-group>
    <x-form-label for="shop-phone" required>{{ _e('Phone number', 'sage') }}</x-form-label>
    <x-form-input type="text" name="phone" id="shop-phone" defaultValue="phone" required />
  </x-form-group>

  @if ($subscription_packs)
    <div class="space-y-2">
      <legend class="text-sm text-gray-700">{{ _e('Choose a Subscription Plan', 'sage') }}</legend>
      <div class="grid gap-y-2">
        @foreach ($subscription_packs as $pack)
          <label
            class="rounded border flex focus:outline-none items-center text-sm leading-none px-2 py-4 space-x-2 lg:space-x-4 lg:px-4"
            for="subscription-pack-{{ esc_attr_e($pack->id, 'sage') }}">
            <input type="radio" name="dokan-subscription-pack"
              id="subscription-pack-{{ esc_attr_e($pack->id, 'sage') }}"
              value="{{ esc_attr_e($pack->id, 'sage') }}"
              class="h-4 w-4 text-black border-gray-300 focus:ring-gray-500"
              {{ $loop->first ? 'checked="checked"' : '' }}>
            <div class="flex w-full items-center justify-between space-x-2 text-sm leading-none">
              <span class="w-half">{{ $pack->title }}</span>
              @if ($pack->price)
                <span class="text-right">
                  <span>{!! $pack->price !!}</span>
                  @if ($pack->is_recurring)
                    <span>{{ $pack->recurring_label }}</span>
                  @endif
                </span>
              @else
                <span class="text-right">{{ _e('Free', 'sage') }}</span>
              @endif
            </div>
          </label>
        @endforeach
      </div>
    </div>
  @endif

  @if ($terms)
    <x-form-label class="flex items-center space-x-2">
      <x-form-checkbox name="tc_agree" id="tc_agree" value="forever" required />
      <span>
        <span>{{ _e('I have read and agree to the ', 'sage') }}</span>
        <a class="underline" href="{{ $terms }}"
          target="_blank">{{ _e('Terms & Conditions.', 'sage') }}</a>
      </span>
    </x-form-label>
  @endif
</div>

@php do_action('dokan_reg_form_field') @endphp
