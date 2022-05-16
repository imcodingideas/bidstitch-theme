<section id="home_banner">
  <div
    class="">
    @if ($slides)
      <div class="home-slider__slider relative">
        @foreach ($slides as $slide)
          {{-- Empty wrapping element for slick slider --}}
          <div style="background-image:url('{{ $slide['image']['url'] }} ');">
            <div class="container items-center">
              <div
                class="col-span-8 row-start-2 lg:row-start-auto lg:col-span-5 flex flex-col justify-center items-center space-y-5 p-8 md:px-0">
                <div class="grid space-y-3">
                  {!! $slide['content'] !!}
                </div>
                @if ($slide['button'])
                  <a href="{{ esc_attr($slide['link']) }}" class="btn btn--white btn--md capitalize font-400">
                    {{ $slide['button'] }}</a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
