<section class="ss-products-by-category" id="home_products_most_favorited">
  <div class="wrapper-section">
    <div class="inner-section">
      <div class="heading">
        <h2 class="title">
          <a href="<?php the_field('link_most_favorited'); ?>"><?php the_field('tittle_most_favorited'); ?></a>
        </h2>
        <div class="wap-see-all"></div>
      </div>
      <div class="container">
        <div class="wap-products-by-category">
          <ul class="lists">
           <?php
           global  $wpdb;
           $result_product_id = $wpdb->get_col("SELECT prod_id FROM `{$wpdb->prefix}yith_wcwl`  Group by prod_id order by count(prod_id) DESC ");
           $all_ids = get_posts( array(
            'post_type' => 'product',
            'numberposts' => 5,
            'post_status' => 'publish',
            'fields' => 'ids',
            'meta_query' => array(
              array(
                'key' => '_stock_status',
                'value' => 'instock'
              ),
            ),
          ));
           $product_favorites_array = array_unique (array_merge($result_product_id,$all_ids));
           $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
             // 'ignore_sticky_posts'   => 1,
            'post__in' => $product_favorites_array,
            'posts_per_page'        => 5,
            'orderby' => 'post__in',
            'meta_query' => array(
              array(
                'key' => '_stock_status',
                'value' => 'instock'
              ),
            ),
          );
           $args['tax_query']       = array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => array('auction', 'product_pack'),  'operator'  => 'NOT IN'));
           $loop = new WP_Query( $args );
          // do_action( 'woocommerce_before_shop_loop' );
           //echo apply_filters( 'woocommerce_product_loop_start', ob_get_clean() );
           while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            $classes   = array();
            $classes[] = 'has-hover';
            $classes[] = 'item';
            do_action( 'woocommerce_shop_loop' );
            $product_id = $product->get_id();
            $result_product_id = $wpdb->get_col("SELECT ID FROM `wp_yith_wcwl` WHERE `prod_id` = '$product_id' ");
            $count_wishlish = count($result_product_id);
            $vendor_id = get_post_field( 'post_author', get_the_id() );
            // Get the WP_User object (the vendor) from author ID
            $vendor = new WP_User($vendor_id);
            $store_info  = dokan_get_store_info( $vendor_id ); // Get the store data
            
            ?>

            <li <?php wc_product_class( $classes, $product ); ?> >
              <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
              <div class="wap-image">
                <a href="<?php echo get_the_permalink();  ?>" class="link-to ">
                </a>
                <div class="image-tools is-small top right show-on-hover">
                </div>
                <div class="image-tools is-small hide-for-small bottom left show-on-hover">
                  <?php do_action( 'flatsome_product_box_tools_bottom' ); ?>
                </div>
                <div class="image-tools <?php echo flatsome_product_box_actions_class(); ?>">
                  <?php do_action( 'flatsome_product_box_actions' ); ?>
                </div>
              </div>
              <div class="description">
                <a href="<?php echo get_the_permalink();  ?>" class="link-to ">
                  <?php 
                  do_action( 'woocommerce_before_shop_loop_item_title' );
                  ?>
                  <div class="wrapper-wishlist">
                    <h4 class="product-name"><?php the_title(); ?></h4>
            <!-- <div class="wishlist-a">
            <span class="count"><?php echo $count_wishlish; ?></span>
            <span class="icon"><i class="far fa-heart"></i></span>
          </div> -->
        </div>
      </a>
      <a href="<?php echo dokan_get_store_url( $vendor_id ); ?>" class="link-to ">
        <p class="name-store"><?php
        $store_name  = $store_info['store_name'];  
        echo $store_name;
        ?></p>
      </a>  
      <a href="<?php echo get_the_permalink();  ?>" class="link-to ">       
        <div class="price-product-bid">    
          <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
        </div>
      </a>
    </div>
  </li>
<?php endwhile;
            // woocommerce_product_loop_end();
            // do_action( 'woocommerce_after_shop_loop' );
wp_reset_query();
?>
</ul>
<div class="wap-arrows"></div>
<div class="see-all-product">
  <a href="<?php the_field('link_most_favorited');  ?>">
    <span><?php the_field('content_link_most_favorited'); ?></span>
  </a>
</div>
</div>
</div>
</div>
</div>
</section>
