@if ($product)
  <tr class="transition-colors bg-white hover:bg-gray-50 grid gap-y-4 p-4 sm:table-row sm:p-0">
    <td class="whitespace-nowrap grid sm:table-cell sm:px-6 sm:py-4">
      <div class="flex items-center">
        <a class="flex flex-shrink-0 h-16 w-16 mr-2 overflow-hidden shadow-sm sm:mr-4" href="{{ $product->url }}">
          @if ($product->thumbnail)
            {!! $product->thumbnail !!}
          @endif
        </a>
        <div class="grid items-center">
          <a class="text-sm font-bold text-gray-900 truncate" href="{{ $product->url }}">
            {!!  $product->title  !!}
          </a>
          <div class="text-sm font-medium text-gray-600">
            {{ $product->date }}
          </div>
        </div>
      </div>
    </td>
    <td class="whitespace-nowrap text-sm text-gray-500 grid sm:table-cell sm:px-6 sm:py-4">
      <div class="grid">
        @if (!$is_auction)
          {!! $product->price !!}
        @endif
        @if ($product->highest_offer)
          <div class="text-sm font-medium text-gray-500">
            <span>{{ _e('Best Offer', 'sage') }}: </span>
            <span>{!! $product->highest_offer !!}</span>
          </div>
        @endif
        @if ($product->highest_bid)
          <div class="text-sm font-medium text-gray-500">
            <span>{{ _e('Current Bid', 'sage') }}: </span>
            <span>{!! $product->highest_bid !!}</span>
          </div>
        @else
          @if ($product->starting_bid)
            <div class="text-sm font-medium text-gray-500">
              <span>{{ _e('Starting Bid', 'sage') }}: </span>
              <span>{!! $product->starting_bid !!}</span>
            </div>
          @endif
        @endif
      </div>
    </td>
    <td
      class="whitespace-nowrap text-sm text-gray-500 text-right grid grid-cols-2 gap-x-2 gap-y-2 sm:table-cell sm:px-6 sm:py-4">
      @if (current_user_can($is_auction ? 'dokan_edit_auction_product' : 'dokan_edit_product'))
        <a class="btn btn--black btn--sm justify-center" href="{{ $edit_url }}">{{ _e('Edit', 'sage') }}</a>
      @endif
      @if (current_user_can($is_auction ? 'dokan_delete_auction_product' : 'dokan_delete_product'))
        <a onClick="return confirm('{{ _e('Are you sure you want to delete?', 'sage') }}');"
          class="btn btn--white btn--sm justify-center" href="{!! $delete_url !!}">{{ _e('Delete', 'sage') }}</a>
      @endif
      @if (current_user_can($is_auction ? 'dokan_delete_auction_product' : 'dokan_delete_product'))
        <a onClick="return confirm('{{ _e('Are you sure you want to mark as sold?', 'sage') }}');"
          class="btn btn--white btn--sm bg-green-600 hover:bg-green-600 text-white justify-center col-span-2" href="{!! $sold_url !!}">{{ _e('Sold', 'sage') }}</a>
      @endif
    </td>
  </tr>
@endif
