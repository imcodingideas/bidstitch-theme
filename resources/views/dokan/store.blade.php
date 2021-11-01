{{-- The Template for displaying all single posts. --}}
{{-- example: store/storename --}}

@php
  function nd_dosth_theme_setup() {

        // Adds <title> tag support
        add_theme_support( 'title-tag' );

}
add_action( 'after_setup_theme', 'nd_dosth_theme_setup');
@endphp
@php get_header('shop') @endphp

<div class="dokan-store-wrap layout-{{ $layout }}">

  <div id="dokan-primary" class="dokan-single-store">
    <div id="dokan-content" class="store-page-wrap woocommerce" role="main">
      @php dokan_get_template_part( 'store-header' ) @endphp
      @include('dokan.store-header-seller')
      @php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ) @endphp
      @if (have_posts())
        <div class="seller-items">
          @php woocommerce_product_loop_start() @endphp
          @while (have_posts())
            @php the_post() @endphp
            @php wc_get_template_part( 'content', 'product' ) @endphp
          @endwhile
          @php woocommerce_product_loop_end() @endphp
        </div>
        @php dokan_content_nav( 'nav-below' ) @endphp
      @else
        @include('dokan.store-no-listings')
      @endif
      {!! \Roots\view('partials.single-product-notice')->render() !!}
    </div>
  </div>

  @if ('right' === $layout)
    @php
      dokan_get_template_part('store', 'sidebar', [
          'store_user' => $store_user,
          'store_info' => $store_info,
          'map_location' => $map_location,
      ]);
    @endphp
  @endif
</div>
@php do_action( 'woocommerce_after_main_content' ) @endphp
@php get_footer( 'shop' ) @endphp
