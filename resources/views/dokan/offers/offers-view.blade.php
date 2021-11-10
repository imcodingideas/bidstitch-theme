<div class="grid space-y-8" x-data="offerForm()">
  <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 md:text-3xl">{{ _e('Received Offers', 'sage') }}</h1>
  @php
    wc_print_notices();
  @endphp
  @if ($offer_groups)
    <div class="w-full">
      <div class="grid space-y-8">
        @foreach ($offer_groups as $key => $group)
          <div class="grid bg-white rounded-lg shadow-sm">
            <div class="p-4 lg:p-6 space-x-4 flex items-center w-full justify-between">
              <div class="space-x-4 flex items-center">
                <div class="w-20 bg-gray-100 rounded">
                  {!! $group->product_thumbnail !!}
                </div>
                <h2 class="text-lg font-bold">{{ $group->product_name }}</h2>
              </div>
              <a href="{{ esc_url($group->product_link) }}"
                class="hidden btn btn--black btn--sm justify-center lg:inline-flex">{{ _e('View Product', 'sage') }}</a>
            </div>
            <div class="border-b border-t border-gray-200">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden md:table-header-group">
                  <tr>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">
                      {{ _e('Offer Details', 'sage') }}</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">
                      {{ _e('Price', 'sage') }}</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                      {{ _e('Status', 'sage') }}</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                      {{ _e('Actions', 'sage') }}</th>
                  </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach ($group->offers as $offer)
                    <tr class="transition-colors bg-white hover:bg-gray-50 grid gap-y-4 p-4 md:table-row md:p-0">
                      {{-- Details --}}
                      <td class="whitespace-nowrap grid md:table-cell md:px-6 md:py-4">
                        <div class="flex items-center">
                          <div class="grid items-center">
                            <div class="text-sm font-medium text-gray-600">
                              <span class="font-bold">{{ _e('From:', 'sage') }}</span>
                              <span>{{ $offer->author }}<span>
                            </div>
                            <div class="text-sm font-medium text-gray-600">
                              {{ $offer->date }}
                            </div>
                            <div class="text-sm font-medium text-gray-600">
                              {{ $offer->time }}
                            </div>
                          </div>
                        </div>
                      </td>
                      {{-- Price --}}
                      <td class="whitespace-nowrap text-sm text-gray-500 grid md:table-cell md:px-6 md:py-4">
                        <div class="grid">
                          <div>
                            <span class="font-bold">{{ _e('Price Per:', 'sage') }}</span>
                            {!! wc_price($offer->price_per) !!}
                          </div>
                          <div>
                            <span class="font-bold">{{ _e('Quantity:', 'sage') }}</span>
                            {{ $offer->quantity }}
                          </div>
                          <div>
                            <span class="font-bold">{{ _e('Total:', 'sage') }}</span>
                            {!! wc_price($offer->amount) !!}
                          </div>
                        </div>
                      </td>
                      {{-- Status --}}
                      <td
                        class="whitespace-nowrap text-sm text-gray-500 grid md:table-cell md:px-6 md:py-4 text-center justify-start">
                        <span
                          class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                          {{ $offer->status->label }}
                        </span>
                      </td>
                      {{-- Actions --}}
                      <td
                        class="whitespace-nowrap text-sm text-gray-500 text-right grid grid-cols-2 gap-x-2 gap-y-2 md:table-cell md:px-6 md:py-4 {{ !$offer->actions ? 'hidden' : '' }}">
                        <div class="grid grid-cols-2 gap-x-2 gap-y-2">
                          @if ($offer->user_can_manage)
                            @if ($offer->actions)
                              @foreach ($offer->actions as $action)
                                <a class="btn btn--black text-xs p-1 justify-center"
                                  href="{!! esc_url($action->link) !!}">{{ $action->label }}</a>
                              @endforeach
                            @endif
                            <x-offer-form-button offer_id="{{ esc_attr($offer->id) }}"
                              offer_product_Id="{{ esc_attr($group->product_id) }}" offer_action="countered-offer"
                              offer_price="{{ esc_attr($offer->price_per) }}"
                              class="btn btn--black text-xs p-1 justify-center">
                              {{ _e('Counter', 'sage') }}
                            </x-offer-form-button>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endforeach
      </div>
      @if ($pagination)
        <div class="pagination-wrap">
          <ul class="pagination mt-0 mb-0">
            @foreach ($pagination as $link)
              <li>{!! $link !!}</li>
            @endforeach
          </ul>
        </div>
      @endif
      @include('forms.offer')
    </div>
  @else
    <p class="text-base">{{ _e('No offers found', 'sage') }}</p>
  @endif
</div>
