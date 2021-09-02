@if ($steps)
  <div class="lg:border-b lg:border-gray-200">
    <div class="container">
      <nav aria-label="Progress">
        <ol role="list"
          class="rounded-md overflow-hidden lg:flex lg:border-l lg:border-r lg:border-gray-200 lg:rounded-none">
          @foreach ($steps as $step_key => $step)
            <li class="relative overflow-hidden lg:flex-1">
              <div class="border border-gray-200 overflow-hidden border-b-0 rounded-t-md lg:border-0">
                <div class="group">
                  <span
                    class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto {{ $step->current ? 'bg-black' : 'bg-transparent' }}"
                    aria-hidden="true"></span>
                  <span class="px-6 py-5 flex items-start text-sm font-medium">
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
                    <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                      <span class="text-xs font-semibold tracking-wide uppercase">{{ $step->name }}</span>
                      <span class="text-sm font-medium text-gray-500">{{ $step->description }}</span>
                    </span>
                  </span>
                </div>
                @if (!$loop->first)
                  <div class="hidden absolute top-0 left-0 w-3 inset-0 lg:block" aria-hidden="true">
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
