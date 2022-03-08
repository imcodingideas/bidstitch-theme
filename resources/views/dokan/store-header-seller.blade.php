<div class="row header-seller">
  <p class="text-center sm:text-left">{{ $count_product }} {{ _e('Listings', 'sage') }} | {{ $store_total_sales }} {{ _e($store_total_sales == 1 ? 'Sale' : 'Sales', 'sage') }}</p>
  {{-- <form class="dokan-ordering-product ajaxfilterform" method="get">
    <select name="orderby" class="orderby" aria-label="{{ _e('Shop order', 'woocommerce') }}">
      @foreach ($catalog_orderby_options as $id => $name)
        <option value="{{ $id }}" {{ selected($orderby, $id) }}>{{ $name }}</option>
      @endforeach
    </select>
    <input type="hidden" name="store_user_id" value="{{ $store_user->get_id() }}" />
    <input type="hidden" name="paged" value="1" />
    @php
      wc_query_string_form_fields(null, ['orderby', 'submit', 'paged', 'product-page']);
    @endphp
  </form> --}}
</div>
