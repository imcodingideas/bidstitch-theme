<section class="ss-shop-by-category py-12" id="new_home_category_button">
  <div class="container">
    <div class="wrapper-section">
      <div class="inner-section">
        <div class="wrap-shop-by-category">
          <ul class="flex flex-col justify-center md:flex-row md:space-x-4 md:space-y-0 mx-auto space-y-4">
            <?php
            $category_list = get_field('category_list');
            if($category_list){
              $category_array = implode(",",$category_list);
              $product_categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'include' => $category_array,
                'hide_empty'  => false,
                'orderby'    => 'meta_value_num',
                'meta_key' => 'meta_value_num',
                'order'         => 'ASC',
              ));
            }
            if( !empty($product_categories) ){
              $count_tee = 0 ;
              foreach ($product_categories as $key => $category) {
                $count_tee = $count_tee + 1;
                ?>
                <li class="item">
                  <a class="btn btn-white px-8 py-1 " href="<?php echo get_term_link($category); ?>">
                    <span class="category-name"><?php echo $category->name; ?> <?php if($count_tee != count($product_categories)){
                      the_field('string_category');
                    }  ?></span>
                  </a>
                </li>

              <?php }
            }
            wp_reset_query();
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
