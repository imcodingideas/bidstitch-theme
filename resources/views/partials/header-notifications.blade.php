<ul class="flex flex-col space-y-2 relative">
  @if (!empty($user_notifications))
    @foreach ($user_notifications as $user_notification)
      <li class="border-b flex justify-between mb-2 pb-2" id="header-notifications__item-{{ $user_notification['id'] }}">
        <div class="w-3/12">
          <a href="{{ $user_notification['link'] }}">
            <img src="{!! $user_notification['thumbnail'] !!}" alt="thumbnail" />
          </a>
        </div>
        <div class="flex flex-col space-y-2 w-7/12 px-2">
          <div class="font-semibold tracking-wide"> {!! $user_notification['title'] !!} </div>
          <div class="mt-2 text-sm"> {!! $user_notification['text'] !!} </div>
          @if ($user_notification['isOffer'])
            <a href="{{ $offers_link }}" class="header-notifications__decline ml-3 inline-flex justify-center items-center px-3 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Manage offers
            </a>
          @endif
        </div>
        <div class="cursor-pointer header-notifications__mark-as-read" data-id="{{ $user_notification['id'] }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
      </li>
    @endforeach
  @endif
</ul>
