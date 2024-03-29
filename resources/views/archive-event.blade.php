@extends('layouts.app')

@section('content')
  @if ($events['partnered'] || $events['external'])

    <div x-cloak x-data="{ tab: 'partnered' }">
      <div class="mb-8 flex border-b border-gray-300">
        <div x-on:click="tab = 'partnered'" class="w-1/2 sm:w-auto border border-gray-300 border-b-0 border-r-0 px-8 py-2 text-center leading-tight cursor-pointer" :class="tab === 'partnered' ? 'bg-white text-black' : 'bg-gray-100 text-gray-500'">
          Partnered Events
        </div>
        <div x-on:click="tab = 'external'" class="w-1/2 sm:w-auto border border-gray-300 border-b-0 px-8 py-2 text-center leading-tight cursor-pointer" :class="tab === 'external' ? 'bg-white text-black' : 'bg-gray-100 text-gray-500'">
          Featured Events
        </div>
      </div>

      <div x-show="tab === 'partnered'">
        <h1 class="mb-6 text-xl text-center font-bold">BIDSTITCH Partner Events</h1>

        @if ($events['partnered'])
          <div class="bg-white overflow-hidden sm:rounded-md">
            <ul role="list" class="space-y-4">
              @foreach ($events['partnered'] as $event)
                <li class="partnered-event">
                  @include('partials.archive-events-item')
                </li>
              @endforeach
            </ul>
          </div>
        @else
          <p class="text-center">Nothing lined up yet - check back soon!</p>
        @endif
      </div>

      <div x-cloak x-show="tab === 'external'">
        <h1 class="mb-6 text-xl text-center font-bold">Featured Events</h1>

        @if ($events['external'])
          <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul role="list" class="divide-y divide-gray-200">
              @foreach ($events['external'] as $event)
              <li class="external-event">
                  @include('partials.archive-events-item')
                </li>
              @endforeach
            </ul>
          </div>
        @else
        <p class="text-center">Nothing lined up yet - check back soon!</p>
        @endif
      </div>
    </div>
  @else
    <h1 class="text-xl text-center font-bold">No Upcoming Events</h1>
    <p class="text-center">Check back soon!</p>
  @endif
@endsection
