<h3 class="sr-only">
  {{ _e('Order placed on', 'sage') }}
  <time datetime="{{ $order_date->attribute }}">{{ $order_date->label }}</time>
</h3>
<div
  class="bg-gray-50 rounded-lg py-6 px-4 sm:px-6 sm:flex sm:items-center sm:justify-between sm:space-x-6 lg:space-x-8">
  <dl
    class="divide-y divide-gray-200 space-y-6 text-sm text-gray-600 flex-auto sm:divide-y-0 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-x-6 lg:w-1/2 lg:flex-none lg:gap-x-8">
    <div class="flex justify-between sm:block">
      <dt class="font-medium text-gray-900">{{ _e('Date placed', 'sage') }}</dt>
      <dd class="sm:mt-1">
        <time datetime="{{ $order_date->attribute }}">{{ $order_date->label }}</time>
      </dd>
    </div>
    <div class="flex justify-between pt-6 sm:block sm:pt-0">
      <dt class="font-medium text-gray-900">{{ _e('Order number', 'sage') }}</dt>
      <dd class="sm:mt-1">
        {!! esc_html(_x('#', 'hash before order number', 'woocommerce') . $order_number) !!}
      </dd>
    </div>
    <div class="flex justify-between pt-6 font-medium text-gray-900 sm:block sm:pt-0">
      <dt>{{ _e('Total Amount', 'sage') }}</dt>
      <dd class="sm:mt-1">
        {!! $order_total !!}
      </dd>
    </div>
  </dl>
  <a href="{{ esc_url($order_link) }}" class="flex items-center justify-center btn btn--black btn--sm mt-6 sm:mt-0">
    {{ _e('View Order', 'sage') }}
    <span class="sr-only">{{ _e('for order', 'sage') }} {{ $order_number }}</span>
  </a>
</div>