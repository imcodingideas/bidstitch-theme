<div id="header-notifications" class="absolute bg-white w-72 p-4 right-0 shadow-lg top-6 z-10 rounded hidden">
  <ul class="flex flex-col space-y-2">
    @if (!empty($user_notifications))
      @foreach ($user_notifications as $user_notification)
        <li class="border-b flex justify-between mb-2 pb-2">
          <div class="w-3/12">
            <a href="{{ $user_notification['link'] }}">
              <img src="{!! $user_notification['thumbnail'] !!}" alt="thumbnail" />
            </a>
          </div>
          <div class="flex flex-col space-y-2 w-7/12 px-2">
            <div class="font-semibold tracking-wide"> {!! $user_notification['title'] !!} </div>
            <div class="mt-2 text-sm"> {!! $user_notification['text'] !!} </div>
            @if ($user_notification['isOffer'])
              <div class="flex">
                <button type="button" class="inline-flex items-center px-3 py-1 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Accept
                </button>
                <button type="button" class="ml-3 inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Decline
                </button>
              </div>
            @endif
          </div>
          <div class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
        </li>
      @endforeach
    @endif
  </ul>
</div>
