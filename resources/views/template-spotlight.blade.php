{{--
  Template Name: Spotlight
--}}

@extends('layouts.spotlight')

@section('content')
  @while(have_posts()) @php(the_post())
  <div class="">
    @include('partials.content-page')
  </div>
  @endwhile
@endsection