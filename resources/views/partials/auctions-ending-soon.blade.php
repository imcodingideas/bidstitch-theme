@php
$loop = new WP_Query($args);
@endphp
@if ($loop->have_posts())
  <div class="auctions-ending-soon py-8 lg:py-16">
    <div class="container">
      <div class="auctions-ending-soon__title">
        <h2 class="text-xl md:text-3xl font-bold uppercase">Auctions ending soon</h2>
      </div>
      <div class="woocommerce mt-8">
        <ul class="auctions-ending-soon__products products columns-4">
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
