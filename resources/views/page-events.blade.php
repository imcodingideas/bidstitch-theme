@extends('layouts.app')

@section('content')
  @if ($events)
    <h1 class="mb-4 text-xl text-center font-bold">Upcoming Events</h1>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
      <ul role="list" class="divide-y divide-gray-200">
        @foreach ($events as $event)
          <li>
            <a href="#" class="block hover:bg-gray-50">
              <div class="px-4 py-4 sm:px-6">
                <div class="font-bold truncate">
                  {{ $event->title }}
                </div>
                <div>
                  {{ $event->description }}
                </div>
                <div class="mt-2 sm:flex sm:justify-between">
                  <div class="sm:flex sm:space-x-2">
                    <p class="flex items-center text-sm text-gray-500">
                      <!-- Heroicon name: solid/calendar -->
                      <svg class="flex-shrink-0 mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                      </svg>
                      {{ $event->date }}
                    </p>
                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                      <!-- Heroicon name: solid/location-marker -->
                      <svg class="flex-shrink-0 mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                      </svg>
                      {{ $event->location }}
                    </p>
                  </div>
                </div>
              </div>
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  @else
    <h1 class="text-xl text-center font-bold">No Upcoming Events</h1>
    <p class="text-center">Check back soon!</p>
  @endif
@endsection
