@php
$loop = new WP_Query($args);
@endphp
@if ($loop->have_posts())
  <div class="most-favorited-products bg-gray-100 py-6 xl:py-12">
    <div class="container mx-auto">
      <div class="most-favorited-products__title">
        <h2 class="font-bold md:text-3xl singe_product_notice_content text-lg uppercase">Most favorited</h2>
      </div>
      <div class="woocommerce mt-6">
        <ul class="most-favorited-products__products products">
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
