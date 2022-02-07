<ul class="flex space-x-4 h-full justify-center items-center">

  @if ($inbox)
    <li class="relative lg:flex">
      <a href="{{ $inbox }}" title="inbox">
        <svg class="w-5 h-5" aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z">
          </path>
        </svg>
        <span id="header-inbox-count-wrapper" class="hidden -translate-y-2 absolute  right-0 top-0 transform translate-x-2">
          <span id="header-inbox-count" class="bg-yellow-400 rounded-full text-xs w-4 flex h-4 items-center justify-center leading-none"></span>
        </span>
      </a>
    </li>
  @endif

  @if ($favorites)
    <li class="hidden lg:flex">
      <a href="{{ $favorites }}" title="favorites">
        <svg class="w-5 h-5" aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z">
          </path>
        </svg>
      </a>
    </li>
  @endif

  @if ($notifications)
    <li id="header-notifications-icon" class="relative">
      <a href="{{ $notifications }}" title="notifications" class="relative block">
        <svg class="w-5 h-5" aria-hidden="true" focusable="false" data-prefix="far" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
          <path fill="currentColor" d="M439.39 362.29c-19.32-5.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71zM67.53 368c21.22-27.97 44.42-74.33 44.53-159.42 0-.2-.06-.38-.06-.58 0-61.86 50.14-112 112-112s112 50.14 112 112c0 .2-.06.38-.06.58.11 85.1 23.31 131.46 44.53 159.42H67.53zM224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64z">
          </path>
        </svg>
        <span id="header-notifications-count-wrapper" class="-translate-y-2 absolute  right-0 top-0 transform translate-x-2 hidden">
          <span id="header-notifications-count" class="bg-yellow-400 rounded-full text-xs w-4 flex h-4 items-center justify-center leading-none"></span>
        </span>
      </a>
      {{-- rendered with ajax, see resources/scripts/header-notifications.js --}}
      <div id="header-notifications" class="absolute hidden top-6 right-0 w-72 z-10 bg-white p-4 shadow-lg rounded overflow-y-auto">
        {{-- @include('partials.header-notifications') --}}
      </div>
    </li>
  @endif

  @include('partials.cart-icon')

</ul>
