@php
$loop = new WP_Query($args);
@endphp
@if ($loop->have_posts())
  <div class="auctions-ending-soon py-6 xl:py-12">
    <div class="container mx-auto">
      <div class="auctions-ending-soon__title">
        <h2 class="font-bold md:text-3xl singe_product_notice_content text-lg uppercase">Auctions ending soon</h2>
      </div>
      <div class="woocommerce mt-6">
        <ul class="auctions-ending-soon__products products">
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
