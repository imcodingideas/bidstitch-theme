{{-- mobile --}}
<section class="home-banner md:hidden" id="home_banner">
  <div class="full-width">
    <div class="wrapper-section">
      <div class="inner-section">
        <?php if( have_rows('content_slider') ): ?>
          <div class="home-slider__slider">
            <?php $i = 1;
            while( have_rows('content_slider') ): the_row(); 
              // vars
              $image = get_sub_field('content_slider_image');
              $image_mobile = get_sub_field('content_slider_image_mobile');
              $content = get_sub_field('content_slider_content');
              $button = get_sub_field('content_slider_button');
              $link = get_sub_field('content_slider_link_button');
              if( $link == 4){
               if(!is_user_logged_in() ){ 
                $link = wp_login_url();
              }else{
                if ( dokan_is_seller_enabled( get_current_user_id() ) ) { 
                  $link  =  get_field('link_new_my_listing','option');
                }else{
                 $link  =  get_field('page_create_shop','option');
               }
             }
           }
           ?>
           <div class="slider-home-page slider-<?php echo $i; ?>" style="background-image: url('<?php echo $image['url']; ?>');">
	            <div class="flex h-80 items-center justify-center">
	              <div class="contents">
	                <?php echo $content; ?>
	              </div>
	              <?php if( $button ) : ?>
		              <div class="">
		                <a href="<?php echo $link; ?>" class="btn btn--white px-8 py-1"><?php echo $button; ?></a>
		              </div>
	          	  <?php endif ; ?>
	            </div>
          	</div>
          <?php $i++; endwhile;  ?>
        </div>
      <?php endif; ?>
      <div class="wap-arrows wap-arrows-desktop"></div>
    </div>
  </div>
</div>
</section>

{{-- desktop --}}
<section class="home-banner hidden md:block" id="home_banner">
  <div class="full-width">
    <div class="wrapper-section">
      <div class="inner-section">
        <?php if( have_rows('content_slider') ): ?>
          <div class="home-slider__slider">
            <?php $i = 1;
              while( have_rows('content_slider') ): the_row(); 
                // vars
                $image = get_sub_field('content_slider_image');
                $image_mobile = get_sub_field('content_slider_image_mobile');
                $content = get_sub_field('content_slider_content');
                $button = get_sub_field('content_slider_button');
                $link = get_sub_field('content_slider_link_button');
                if( $link == 4){
                if(!is_user_logged_in() ){ 
                  $link = wp_login_url();
                }else{
                  if ( dokan_is_seller_enabled( get_current_user_id() ) ) { 
                    $link  =  get_field('link_new_my_listing','option');
                  }else{
                  $link  =  get_field('page_create_shop','option');
                }
              }
            }
            ?>
            <div class="slider-home-page slider-<?php echo $i; ?>" style="background-image: url('<?php echo $image_mobile['url']; ?>');">
	             <div class="flex h-80 items-center justify-center">
	               <div class="contents">
	                <?php echo $content; ?>
	               </div>
	               <?php if( $button ) : ?>
	               <div class="">
	                 <a href="<?php echo $link; ?>" class="btn btn--white px-8 py-1"><?php echo $button; ?></a>
	               </div>
	               <?php endif ; ?>
	             </div>
          	 </div>
            <?php $i++; endwhile;  ?>
          </div>
        <?php endif; ?>
        <div class="wap-arrows wap-arrows-mb"></div>
      </div>
    </div>
  </div>
</section>

