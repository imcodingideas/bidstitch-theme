@extends('layouts.wide')

@section('content')
  @while(have_posts()) @php(the_post())
  @include('partials.home-banner')
  @include('partials.ss-shop-by-category')
  {{-- @include('partials.ss-products-by-category') --}}
  @include('partials.singe_product_notice')
  @endwhile
@endsection
