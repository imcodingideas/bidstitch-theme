@php
$loop = new WP_Query($args);
@endphp
@if ($loop->have_posts())
  <div class="most-favorited-products bg-gray-100 py-8 lg:py-16">
    <div class="container">
      <div class="most-favorited-products__title">
        <h2 class="text-xl md:text-3xl font-bold uppercase">Most favorited</h2>
      </div>
      <div class="woocommerce mt-8">
        <ul class="most-favorited-products__products products columns-4">
          @while ($loop->have_posts())
            @php
              $loop->the_post();
              do_action('woocommerce_shop_loop');
              wc_get_template_part('content', 'product');
            @endphp
          @endwhile
        </ul>
      </div>
    </div>
  </div>
@endif
@php
wp_reset_postdata();
@endphp
