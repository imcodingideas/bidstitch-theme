<div class="bg-center bg-cover bg-no-repeat" @if ($event->bg_image) style="background-image:url({{ $event->bg_image }})" @endif>
    <div class="px-4 py-4 sm:px-6 @if ($event->bg_image) text-white bg-opacity-60 bg-black @endif">
      <div class="font-bold text-lg truncate flex justify-between">
        <a target="_blank" href="{{ $event->link }}">{{ $event->title }}</a>
      </div>
      <div class="my-4 sm:my-2">
        <div class="event-description">
          {!! $event->description !!}
        </div>
      </div>
      <div class="sm:flex sm:justify-between">
        <div class="sm:flex sm:space-x-2">
          <p class="flex items-center text-sm {{ $event->bg_image ? 'text-white' : 'text-gray-500' }}">
            <!-- Heroicon name: solid/calendar -->
            <svg class="flex-shrink-0 mr-1 h-5 w-5 {{ $event->bg_image ? 'text-white' : 'text-gray-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
            </svg>
            <time datetime="{{ $event->date_ymd }}">{{ $event->date }}</time>
          </p>
          <p class="mt-2 flex items-center text-sm {{ $event->bg_image ? 'text-white' : 'text-gray-500' }} sm:mt-0 sm:ml-6">
            <!-- Heroicon name: solid/location-marker -->
            <svg class="flex-shrink-0 mr-1 h-5 w-5 {{ $event->bg_image ? 'text-white' : 'text-gray-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
            </svg>
            {{ $event->location }}
          </p>
        </div>
        @if ($event->allow_registration)
          <a class="block mt-4 sm:mt-0 bg-yellow-400 text-black sm:text-sm text-center rounded-full py-2 px-3" target="_blank" href="{{ $event->link }}">Register now</a>
        @else
          <a class="block mt-4 sm:mt-0 bg-black text-white sm:text-sm text-center py-1 px-4" target="_blank" href="{{ $event->link }}">More Info</a>
        @endif
      </div>
    </div>
  </div>