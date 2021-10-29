<div class="grid space-y-8">
  <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 md:text-3xl">{{ _e('Recent Offers', 'sage') }}</h1>
  @if ($offers)
    <div class="grid space-y-8">
      <div class="grid bg-white rounded-lg shadow-sm ">
        <div class="border-b border-t border-gray-200 overflow-x-auto">
          <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 hidden md:table-header-group">
            <tr>
              <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">
                {{ _e('Product', 'sage') }}</th>
              <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                {{ _e('Price', 'sage') }}</th>
              <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                {{ _e('Status', 'sage') }}</th>
              <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                {{ _e('Actions', 'sage') }}</th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($offers as $offer)
              <tr class="transition-colors bg-white hover:bg-gray-50 grid gap-y-4 p-4 md:table-row md:p-0">
                {{-- Details --}}
                <td class="whitespace-nowrap grid md:table-cell md:px-6 md:py-4">
                  <div class="flex items-center max-w-md">
                    <span>{!! $offer['product_title'] !!}<span>
                      <div class="text-sm font-medium text-gray-600">
                        {{ $offer['offer_date'] }}
                      </div>
                      <div class="text-sm font-medium text-gray-600">
                        {{ $offer['offer_time'] }}
                      </div>
                  </div>
                </td>
                {{-- Price --}}
                <td class="whitespace-nowrap text-sm text-gray-500 grid md:table-cell md:px-6 md:py-4">
                  <div class="grid">
                    <div>
                      <span class="font-bold">{{ _e('Price Per:', 'sage') }}</span>
                      {!! $offer['offer_price_per'] !!}
                    </div>
                    <div>
                      <span class="font-bold">{{ _e('Quantity:', 'sage') }}</span>
                      {!! $offer['offer_quantity'] !!}
                    </div>
                    <div>
                      <span class="font-bold">{{ _e('Total:', 'sage') }}</span>
                      {!! $offer['offer_amount'] !!}
                    </div>
                  </div>
                </td>
                {{-- Status --}}
                <td
                  class="whitespace-nowrap text-sm text-gray-500 grid md:table-cell md:px-6 md:py-4 text-center justify-start">
                      <span
                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        {!! $offer['offer_status'] !!}
                      </span>
                </td>
                {{-- Actions --}}
                <td
                  class="whitespace-nowrap text-sm text-gray-500 text-right grid grid-cols-2 gap-x-2 gap-y-2 md:table-cell md:px-6 md:py-4 {{ !$offer['offer_action'] ? 'hidden' : '' }}">
                  <div class="grid grid-cols-2 gap-x-2 gap-y-2">
                    @if ($offer['offer_action'])
                      {!! $offer['offer_action'] !!}
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>


    </div>
  @else
    <p class="text-base">{{ _e('No offers found', 'sage') }}</p>
  @endif
</div>
{{--@if ($pagination)--}}
{{--  <div class="pagination-wrap">--}}
{{--    <ul class="pagination mt-0 mb-0">--}}
{{--      @foreach ($pagination as $link)--}}
{{--        <li>{!! $link !!}</li>--}}
{{--      @endforeach--}}
{{--    </ul>--}}
{{--  </div>--}}
{{--@else--}}
