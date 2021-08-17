<div class="dokan-form-group">
  <div class="dokan-form-group dokan-clearfix dokan-price-container">
    <div class="content-half-part">
      <label for="_regular_price" class="dokan-form-label">{{ _e('Price', 'dokan-lite') }}</label>
      <div class="dokan-input-group">
        <span class="dokan-input-group-addon">{!! get_woocommerce_currency_symbol() !!}</span>
        <input type="text" class="dokan-form-control wc_input_price dokan-product-regular-price" name="_regular_price" placeholder="0.00" id="_regular_price" value="{{ dokan_posted_input('_regular_price') }}">
      </div>
    </div>

    <div class="content-half-part sale-price">
      <label for="_sale_price" class="form-label">
        {{ _e('Discounted Price', 'dokan-lite') }}
        <a href="#" class="sale_schedule">{{ _e('Schedule', 'dokan-lite') }}</a>
        <a href="#" class="cancel_sale_schedule dokan-hide">{{ _e('Cancel', 'dokan-lite') }}</a>
      </label>

      <div class="dokan-input-group">
        <span class="dokan-input-group-addon">{!! get_woocommerce_currency_symbol() !!}</span>
        <input type="text" class="dokan-form-control wc_input_price dokan-product-sales-price" name="_sale_price" placeholder="0.00" id="_sale_price" value="{{ dokan_posted_input('_sale_price') }}">
      </div>
    </div>
  </div>

  <div class="dokan-hide sale-schedule-container sale_price_dates_fields dokan-clearfix dokan-form-group">
    <div class="content-half-part from">
      <div class="dokan-input-group">
        <span class="dokan-input-group-addon">{{ _e('From', 'dokan-lite') }}</span>
        <input type="text" name="_sale_price_dates_from" class="dokan-form-control datepicker sale_price_dates_from" maxlength="10" value="{{ dokan_posted_input('_sale_price_dates_from') }}" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="{{ _e('YYYY-MM-DD', 'dokan-lite') }}">
      </div>
    </div>

    <div class="content-half-part to">
      <div class="dokan-input-group">
        <span class="dokan-input-group-addon">{{ _e('To', 'dokan-lite') }}</span>
        <input type="text" name="_sale_price_dates_to" class="dokan-form-control datepicker sale_price_dates_to" value="{{ dokan_posted_input('_sale_price_dates_to') }}" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="{{ _e('YYYY-MM-DD', 'dokan-lite') }}">
      </div>
    </div>
  </div><!-- .sale-schedule-container -->
</div>
