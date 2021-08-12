  <div class="single-product-accordion__tab-item" id="tab-shipping">
    <div class="single-product-accordion__tab-top text-lg uppercase border-b pb-2 mb-2 font-bold tracking-widest cursor-pointer" data-tab="#tab-shipping">
      <p>{{ _e('Shipping', 'sage') }}</p>
    </div>
    <div class="single-product-accordion__tab-content hidden prose py-3">
      <table class="dokan-table shipping-zone-table shipping-custom">
        <thead>
          <tr>
            <th>{{ _e('Zone Name', 'sage') }}</th>
            <th>{{ _e('Shipping Method', 'sage') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($zones as $key => $value)
            @php
              $shipping_methods = $value['shipping_methods'];
              $count = 0;
            @endphp
            <tr>
              <td>
                {{ $value['formatted_zone_location'] }}
              </td>
              <td>
                @foreach ($shipping_methods as $shipping_method)
                  @php
                    $count++;
                  @endphp
                  <span class="{{ $shipping_method['enabled'] == 'yes' ? 'is-enabled' : 'is-disabled' }}">
                    {{ $shipping_method['settings']['title'] }}
                    ( {{ $shipping_method['settings']['cost'] }} {!! get_woocommerce_currency_symbol() !!} )
                  </span>{{ $count < count($shipping_methods) ? ',' : '' }}
                @endforeach
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
