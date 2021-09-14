@extends('layouts.wide')

@section('content')
  @while(have_posts()) @php(the_post())
  @include('partials.home-banner')
  @include('partials.shop-by-category')
  @include('partials.most-favorited-products')
  @include('partials.auctions-ending-soon')
  @include('partials.best-selling-products')
  @include('partials.top-rated')
  @include('partials.single-product-notice')
  @endwhile
@endsection
