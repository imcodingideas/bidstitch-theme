<div class="">
  <label for="_regular_price" class="form-label">
    {{ _e('Price', 'dokan-lite') }}
    <span class="text-red-500">(required)</span>
  </label>
  <div class="dokan-input-group">
    <span class="dokan-input-group-addon">{!! get_woocommerce_currency_symbol() !!}</span>
    <input class="dokan-form-control wc_input_price dokan-product-regular-price" name="_regular_price" placeholder="0.00" id="_regular_price" value="{{ $_regular_price }}">
  </div>
</div>
