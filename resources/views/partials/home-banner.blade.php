<section id="home_banner">
  <div
    class="px-0 mx-auto max-w-full lg:py-8 sm:px-8 sm:max-w-screen-sm md:max-w-screen-md lg:max-w-screen-lg xl:max-w-screen-xl">
    @if ($slides)
      <div class="home-slider__slider relative">
        @foreach ($slides as $slide)
          {{-- Empty wrapping element for slick slider --}}
          <div>
            <div class="grid grid-cols-12 gap-x-8 items-center">
              <div
                class="col-span-12 row-start-2 lg:row-start-auto lg:col-span-5 flex flex-col justify-center items-start space-y-5 p-8 sm:p-0">
                <div class="grid space-y-3">
                  {!! $slide['content'] !!}
                </div>
                @if ($slide['button'])
                  <a href="{{ esc_attr($slide['link']) }}" class="btn btn--white btn--md">
                    {{ $slide['button'] }}</a>
                @endif
              </div>
              <div
                class="col-span-12 row-start-1 lg:row-start-auto lg:col-span-7 overflow-hidden relative w-full h-64 lg:h-96">
                @if ($slide['image'])
                  <img class="absolute top-0 left-0 h-full object-cover w-full" src="{{ $slide['image']['url'] }}"
                    alt="slide" />
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
