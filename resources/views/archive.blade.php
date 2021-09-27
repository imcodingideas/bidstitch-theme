@extends('layouts.archive')

@section('sidebar')
  @include('partials.archive-sidebar')
@endsection

@section('content')
  <div class="grid gap-y-4 content-start items-start md:gap-y-8">
    @include('partials.archive-header')

    @if (have_posts())
      <div class="grid grid-cols-2 gap-4 md:gap-12 md:grid-cols-3">
        {{-- Loop iteration --}}
        @php $iteration = 0 @endphp
        @while (have_posts())
          {{-- Increment iteration --}}
          @php $iteration++; @endphp
          @php the_post() @endphp

          @includeFirst(['partials.content-archive-' . get_post_type(), 'partials.content-archive'],
          ['iteration' => $iteration, 'featured_layout' => $featured_layout])
        @endwhile
      </div>

      @if ($pagination)
        <div class="pagination-wrap">
          <ul class="pagination mt-0 mb-0">
            @foreach ($pagination as $link)
              <li>{!! $link !!}</li>
            @endforeach
          </ul>
        </div>
      @endif
    @else
      <x-alert type="warning">
        {!! __('Sorry, no results were found.', 'sage') !!}
      </x-alert>
    @endif
  </div>
@endsection
