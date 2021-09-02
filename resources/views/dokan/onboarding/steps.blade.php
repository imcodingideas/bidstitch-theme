@if ($steps)
  <div class="md:border-b md:border-gray-200">
    <div
      class="px-0 mx-auto max-w-full md:px-8 md:max-w-screen-md lg:max-w-screen-lg xl:max-w-screen-xl 2xl:max-w-screen-2xl">
      <nav aria-label="Progress">
        <ol role="list" class="overflow-hidden md:flex md:border-l md:border-r md:border-gray-200">
          @foreach ($steps as $step_key => $step)
            <li class="relative overflow-hidden md:flex-1">
              <div class="border-b border-gray-200 overflow-hidden md:rounded-t-md md:border-b-0">
                <div class="group">
                  <span
                    class="absolute top-0 left-0 w-1 h-full md:w-full md:h-1 md:bottom-0 md:top-auto {{ $step->current ? 'bg-black' : 'bg-transparent' }}"
                    aria-hidden="true"></span>
                  <span class="px-6 py-5 flex items-center text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="w-10 h-10 flex items-center justify-center rounded-full border-2 {{ $step->complete ? 'bg-black' : '' }} {{ $step->complete || $step->current ? 'border-black' : '' }}">
                        @if ($step->complete)
                          <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z
                            clip-rule=" evenodd" />
                          </svg>
                        @else
                          <span
                            class="{{ $step->current ? 'text-black' : 'text-gray-500' }}">{{ $loop->iteration < 10 ? "0$loop->iteration" : $loop->iteration }}</span>
                        @endif
                      </span>
                    </span>
                    <span class="ml-4 min-w-0 flex flex-col">
                      <span class="text-xs font-semibold tracking-wide uppercase">{{ $step->name }}</span>
                      <span
                        class="text-xs font-medium text-gray-500 leading-none md:text-sm md:leading-none">{{ $step->description }}</span>
                    </span>
                  </span>
                </div>
                @if (!$loop->first)
                  <div class="hidden absolute top-0 left-0 w-3 inset-0 md:block" aria-hidden="true">
                    <svg class="h-full w-full text-gray-200" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                      <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke" />
                    </svg>
                  </div>
                @endif
              </div>
            </li>
          @endforeach
        </ol>
      </nav>
    </div>
  </div>
@endif
