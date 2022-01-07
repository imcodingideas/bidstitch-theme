@extends('layouts.app')

@section('content')
  @if ($events)
    <h1 class="mb-4 text-xl text-center font-bold">Upcoming Events</h1>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
      <ul role="list" class="divide-y divide-gray-200">
        @foreach ($events as $event)
          <li x-data="eventRegistration()" x-init="init()">
            <a x-on:click.prevent="openModal" href="#" class="block hover:bg-gray-50">
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
                      <time datetime="{{ $event->date_ymd }}">{{ $event->date }}</time>
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

            <div x-cloak x-show="modalOpen" class="bidstitch-event-modal">
              <div class="fixed z-40 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                  <!-- Background overlay, show/hide based on modal state. -->
                  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                  <!-- This element is to trick the browser into centering the modal contents. -->
                  <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                  <!-- Modal panel, show/hide based on modal state. -->
                  <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6">
                    <div>
                      <h1 class="mb-4 pb-1 text-lg text-center border-b border-gray-300">{{ $event->title }}</h1>
                    </div>

                    @if ($loggedIn)
                      <div x-ref="registrationForm">
                        {!! $event->form !!}
                      </div>
                    @else
                      <p>Please <a class="underline" href="{{ $loginUrl }}">sign in</a> to your BidStitch account to register for this event. If you don't have one, you can <a class="underline" href="{{ $signupUrl }}">sign up here</a>.</p>
                    @endif

                    <div class="flex space-x-2 mt-5 sm:mt-6">
                      @if ($loggedIn)
                        <button x-on:click="submitForm" type="button" class="flex-grow rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                          Register
                        </button>
                      @else
                        <a href="{{ $loginUrl }}" class="flex-grow rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white text-center hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                          Log In
                        </a>
                      @endif
                      <button x-on:click="closeModal" type="button" class="flex-grow rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                        Cancel
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  @else
    <h1 class="text-xl text-center font-bold">No Upcoming Events</h1>
    <p class="text-center">Check back soon!</p>
  @endif
@endsection
