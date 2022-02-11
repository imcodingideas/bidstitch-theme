<div class="grid gap-y-8">
  <div class="grid grid-cols-2 shadow rounded-sm overflow-hidden">
    <a class="flex w-full items-center justify-center text-center uppercase font-bold py-4 px-2 relative text-sm sm:text-base {{ !$is_auction ? 'bg-white' : 'bg-gray-50' }}"
      href="{{ dokan_get_navigation_url('products') }}">
      {{ _e('Buy it Now', 'sage') }}
      <span aria-hidden="true"
        class="bg-gray-400 absolute inset-x-0 bottom-0 {{ !$is_auction ? 'h-0.5' : '' }}"></span>
    </a>
    <a class="flex w-full items-center justify-center text-center uppercase font-bold py-4 px-2 relative text-sm sm:text-base {{ $is_auction ? 'bg-white' : 'bg-gray-50' }}"
      href="{{ dokan_get_navigation_url('auction') }}">
      {{ _e('Auctions', 'sage') }}
      <span aria-hidden="true"
        class="bg-gray-400 absolute inset-x-0 bottom-0 {{ $is_auction ? 'h-0.5' : '' }}"></span>
    </a>
  </div>

  <div class="flex justify-between">
    @include('dokan.products.listing-filter')
    @if (dokan_is_seller_enabled(dokan_get_current_user_id()))
      <a class="btn btn--black h-10 px-4 hidden sm:inline-flex"
        href="{{ $add_url }}">{{ _e('New Listing', 'sage') }}</a>
    @endif
  </div>

  @php dokan_product_dashboard_errors() @endphp

  <form method="POST" class="shadow-sm overflow-hidden border-b border-gray-200 rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50 hidden md:table-header-group">
        <tr>
          <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">
            {{ _e('Product', 'sage') }}</th>
          <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">
            {{ _e('Price', 'sage') }}</th>
          <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
            {{ _e('Actions', 'sage') }}</th>
        </tr>
      </thead>

      @if ($show_info_message)
        <div class="my-4 dokan-alert dokan-alert-info">
          Mark your items as "Sold" here if they have been sold on another platform.
        </div>
      @elseif ($show_sold_message)
        <div class="my-4 dokan-alert dokan-alert-success">
          Item marked as sold!
        </div>
      @endif

      <tbody class="bg-white divide-y divide-gray-200">
        @if ($products->have_posts())
          @while ($products->have_posts())
            @php $products->the_post() @endphp
            @include('dokan.products.products-listing-row', ['is_auction' => $is_auction])
          @endwhile
        @else
          <tr class="bg-white">
            <td class="px-6 py-4 whitespace-nowrap" colspan="3">
              {{ _e('No products found', 'sage') }}
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </form>

  @php wp_reset_postdata() @endphp

  @if ($pagination)
    <div class="pagination-wrap">
      <ul class="pagination mt-0 mb-0">
        @foreach ($pagination as $link)
          <li>{!! $link !!}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
