{{--
  Template Name: Typography
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
  <div class="prose">
    @include('partials.content-page')
  </div>
  @endwhile
@endsection
