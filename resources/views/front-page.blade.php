@extends('layouts.wide')

@section('content')
  @while(have_posts()) @php(the_post())
  @include('partials.home-banner')
  @include('partials.shop-by-category')
  @include('partials.listings-of-the-week')
  @include('partials.sellers-of-the-week')
  @include('partials.featured-articles')
  @include('partials.single-product-notice')
  @endwhile
@endsection
