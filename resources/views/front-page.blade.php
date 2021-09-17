@extends('layouts.wide')

@section('content')
  @while(have_posts()) @php(the_post())
  @include('partials.home-banner')
  @include('partials.shop-by-category')
  @include('partials.most-favorited-products')
  @include('partials.auctions-ending-soon')
  @include('partials.highest-bids')
  @include('partials.single-product-notice')
  @endwhile
@endsection
