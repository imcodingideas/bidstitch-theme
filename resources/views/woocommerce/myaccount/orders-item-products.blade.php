@if ($products)
  <table class="w-full text-gray-500">
    <caption class="sr-only">
      {{ _e('Products', 'sage') }}
    </caption>
    <thead class="sr-only text-sm text-gray-500 text-left sm:not-sr-only">
      <tr>
        <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">{{ _e('Product', 'sage') }}</th>
        <th scope="col" class="hidden w-1/5 pr-8 py-3 font-normal sm:table-cell">{{ _e('Price', 'sage') }}</th>
        <th scope="col" class="hidden pr-8 py-3 font-normal sm:table-cell">{{ _e('Sold by', 'sage') }}</th>
        <th scope="col" class="w-0 py-3 font-normal text-right">{{ _e('Info', 'sage') }}</th>
      </tr>
    </thead>
    <tbody class="border-b border-gray-200 divide-y divide-gray-200 text-sm sm:border-t">
      @if ($products)
        @foreach ($products as $product)
          <tr>
            <td class="py-6 pr-3 md:pr-8">
              <div class="flex items-center">
                {!! $product->thumbnail !!}
                <div>
                  <div class="font-medium text-gray-900">{{ $product->name }}</div>
                  <div class="mt-1 sm:hidden">
                    {!! $product->total !!}
                  </div>
                </div>
              </div>
            </td>
            <td class="hidden py-6 pr-8 sm:table-cell">
              {!! $product->total !!}
            </td>
            <td class="hidden py-6 pr-8 sm:table-cell">
              <a href="{{ esc_url($product->store_link) }}">{{ $product->store_name }}</a>
            </td>
            <td class="py-6 font-medium text-right whitespace-nowrap">
              <div class="grid space-y-2">
                <a href="{{ esc_url($product->link) }}"
                  class="btn btn--white text-xs text-center p-1 justify-center tracking-wider">
                  <span>{{ _e('View Product', 'sage') }}</span>
                  <span class="sr-only">, {{ $product->name }}</span>
                </a>
                @if ($product->store_id)
                  <x-user-chat-button receiver="{{ $product->store_id }}"
                    class="btn btn--white text-xs text-center p-1 justify-center tracking-wider" />
                @endif
              </div>
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
@endif
