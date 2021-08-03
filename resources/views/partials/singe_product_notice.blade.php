<div class="flex flex-col items-center justify-center py-12 singe_product_notice">
  <?php
  $singe_product_notice = get_field('singe_product_notice','option');
  $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
  ?>

  <h2 class="font-bold md:text-3xl singe_product_notice_content text-lg"><?php the_field('singe_product_notice','option') ?></h2>
  <a href="<?php echo $shop_page_url; ?>" class="btn btn--black mt-8 px-12 py-2 shop_now_btn"><?php echo _e('Shop now','flatsome-child'); ?></a>
</div>
