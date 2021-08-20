{{-- Variables injected in home-banner composer --}}
<section class="home-banner" id="home_banner">
  <div class="full-width">
    <div class="wrapper-section">
      <div class="inner-section">
        @if ($slides)
          <div class="home-slider__slider">
            @foreach ($slides as $slide)
              @if ($slide['image'])
              <div class="slider-home-page relative slider-{{ $slide['index'] }}" style="background-image: url('{{ $slide['image']['url'] }}');">
                <img class="absolute h-full object-fill w-full" src="{{ $slide['image']['url'] }}" alt="slide" />
                <div class="flex h-80 items-center justify-center relative">
                  <div class="contents">
                    {!! $slide['content'] !!}
                  </div>
                  @if ($slide['button'])
                    <div class="">
                      <a href="{{ $slide['link'] }}" class="btn btn--white px-8 py-1">{{ $slide['button'] }}</a>
                    </div>
                  @endif
                </div>
              </div>
              @endif
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
