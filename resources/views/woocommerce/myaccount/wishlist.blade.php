<div class="grid space-y-4 md:space-y-8">
  <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
    {{ esc_html_e('My Wishlist', 'sage') }}
  </h1>

  @if ($items)
    <form class="shadow rounded-sm bg-white">
      <ul role="list" class="divide-y divide-gray-200">
        @foreach ($items as $item)
          <li class="flex flex-wrap p-6 justify-between space-y-3 md:flex-nowrap md:space-y-0">
            <div class="flex space-x-4">
              <a href="{{ $item->product_link }}">
                {!! $item->product_image !!}
              </a>

              <div class="flex flex-col">
                <div class="grid min-w-0">
                  <h2 class="text-sm max-w-xs">
                    <a href="{{ $item->product_link }}" class="font-bold text-gray-700 hover:text-gray-800">
                      {{ esc_html_e($item->product_title) }}
                    </a>
                  </h2>

                  @if ($item->store_name && $item->store_link)
                    <a class="my-1 text-sm text-gray-500 flex-1 truncate"
                      href="{{ $item->store_link }}">{{ esc_html_e($item->store_name) }}</a>
                  @endif
                </div>

                @if ($item->product_purchase_status)
                  <p class="flex items-center text-sm text-gray-700 space-x-2 mt-auto">
                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                    </svg>
                    <span>{{ esc_html_e('In Stock', 'sage') }}</span>
                  </p>
                @else
                  <p class="flex items-center text-sm text-gray-700 space-x-2 mt-auto">
                    <span>{{ esc_html_e('Out of Stock', 'sage') }}</span>
                  </p>
                @endif
              </div>
            </div>

            <div class="flex flex-col text-left items-start w-full md:text-right md:items-end md:w-auto">
              <p class="text-sm font-medium text-gray-900 mb-3 md:mb-0">
                {!! $item->product_price !!}
              </p>

              <a href="{{ $item->remove_link }}" title="Remove from wishlist" class="btn btn--sm btn--black mt-auto">
                <span>{{ esc_html_e('Remove', 'sage') }}</span>
              </a>
            </div>
          </li>
        @endforeach
      </ul>
    </form>

    @if ($pagination)
      <div class="pagination-wrap">
        <ul class="pagination mt-0 mb-0">
          @foreach ($pagination as $link)
            <li>{!! $link !!}</li>
          @endforeach
        </ul>
      </div>
    @endif
  @else
    <p>{{ esc_html_e('There are no items in your wishlist.', 'sage') }}</p>
  @endif
</div>
