{{-- 
    Template Name: Dashboard 
--}}

@extends('layouts.dashboard')
@section('content')
  @while (have_posts()) @php(the_post())
    <div class="">
      @include('partials.content-page')
    </div>
  @endwhile
@endsection
