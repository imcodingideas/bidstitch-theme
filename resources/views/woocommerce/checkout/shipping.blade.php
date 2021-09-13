@if ($needs_shipping)
  <div class="p-4 lg:p-6 border-b">
    @php do_action('woocommerce_review_order_before_shipping') @endphp

    @if ($packages)
      <div class="grid gap-y-3 woocommerce-shipping-totals shipping">
        @foreach ($packages as $option)
          <div class="grid space-y-3">
            <span class="text-sm font-medium text-gray-700">{{ _e('Delivery method', 'sage') }}</span>

            @if ($option->available_methods)
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-4 woocommerce-shipping-methods"
                id="shipping_method">
                @foreach ($option->available_methods as $method)
                  <div class="space-x-1">
                    @if (count($option->available_methods) > 1)
                      <label
                        for="shipping_method_{{ esc_attr($option->index) }}_{{ esc_attr(sanitize_title($method->id)) }}"
                        class="cursor-pointer bg-white rounded border flex focus:outline-none items-center text-sm leading-none px-2 py-4 space-x-2 lg:space-x-4 lg:px-4">
                        <x-form-radio name="shipping_method[{{ esc_attr($option->index) }}]"
                          data-index="{{ esc_attr($option->index) }}"
                          id="shipping_method_{{ esc_attr($option->index) }}_{{ esc_attr(sanitize_title($method->id)) }}"
                          class="shipping_method" value="{{ esc_attr($method->id) }}"
                          isChecked="{{ $method->id === $option->chosen_method ? 'checked' : '' }}" />

                        <span>{!! wc_cart_totals_shipping_method_label($method) !!}</span>
                      </label>
                    @else
                      <x-form-input type="hidden" name="shipping_method[{{ esc_attr($option->index) }}]"
                        data-index="{{ esc_attr($option->index) }}"
                        id="shipping_method_{{ esc_attr($option->index) }}_{{ esc_attr(sanitize_title($method->id)) }}"
                        class="shipping_method" value="{{ esc_attr(sanitize_title($method->id)) }}" />

                      <label class="text-sm"
                        for="shipping_method_{{ esc_attr($option->index) }}_{{ esc_attr(sanitize_title($method->id)) }}">
                        {!! wc_cart_totals_shipping_method_label($method) !!}
                      </label>
                    @endif

                    @php do_action('woocommerce_after_shipping_rate', $method, $option->index) @endphp
                  </div>
                @endforeach
              </div>
            @else
              <div class="bg-red-50 text-red-800 p-2">
                @if (empty($option->has_calculated_shipping) || empty($option->formatted_destination))
                  {{ _e('Enter your address to view shipping options', 'sage') }}
                @else
                  {{ _e('There are no shipping options available for your address', 'sage') }}
                @endif
              </div>
            @endif
          </div>
        @endforeach
      </div>
    @else
      <p>{{ _e('There are no shipping options available', 'sage') }}</p>
    @endif
    @php do_action('woocommerce_review_order_after_shipping') @endphp
  </div>
@endif
