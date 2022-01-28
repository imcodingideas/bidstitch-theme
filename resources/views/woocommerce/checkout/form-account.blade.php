  <div class="grid space-y-3 p-4 lg:p-6">
    @php do_action('woocommerce_before_checkout_registration_form', $checkout) @endphp

    @if ($fields)
      @foreach ($fields as $key => $field)
        @php woocommerce_form_field($key, $field, $checkout->get_value($key)) @endphp
      @endforeach
    @endif

    @php do_action('woocommerce_after_checkout_registration_form', $checkout) @endphp
  </div>
