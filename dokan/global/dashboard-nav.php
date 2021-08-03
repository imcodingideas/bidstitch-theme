<?php
$home_url = home_url();
$active_class = ' class="active"'

?>

<div class=" dokan-dash-sidebar-left" >
    <h4 class="main-title-my-profile"><?php _e('MY PROFILE','flatsome-child'); ?></h4>
    <ul class="list-title-a list-profile-account-dokan ">
       <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
        <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
            <?php if($endpoint == 'dashboard'){ ?>
              <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint )); ?>"><?php echo esc_html( $label ); ?></a>
              <!-- empty -->
          <?php } else { ?>
              <a href="<?php echo esc_url( wc_get_endpoint_url( $endpoint, '', wc_get_page_permalink( 'myaccount' )) ); ?>"><?php echo esc_html( $label ); ?></a>
          <?php } ?>
      </li>
  <?php endforeach; ?>
</ul>
<h4 class="main-title-my-shop"><?php the_field('title_my_shop','option'); ?></h4>
<?php
global $allowedposttags;
        // These are required for the hamburger menu.
if ( is_array( $allowedposttags ) ) {
    $allowedposttags['input'] = [
        'id'      => [],
        'type'    => [],
        'checked' => []
    ];
}
$nav_menu          = dokan_get_dashboard_nav();
$active_menu_parts = explode( '/', $active_menu );
if ( isset( $active_menu_parts[1] )
    && ( $active_menu_parts[1] === 'settings' || $active_menu_parts[0] === 'settings' )
    && isset( $nav_menu['settings']['sub'] )
    && ( array_key_exists( $active_menu_parts[1], $nav_menu['settings']['sub'] ) || array_key_exists( $active_menu_parts[2], $nav_menu['settings']['sub'] ) )
){
   $urls = $nav_menu['settings']['sub'];
   ?>
   <!-- menu in setting -->
   <ul class="list-title-a list-profile-account list-dokan-dashboard">
      <?php 
      foreach ( $urls as $key => $item ) {
          $class = ( $active_menu === $key ) ? 'active ' . $key : $key;
          //hide verification
            if($key !='verification'){
               echo sprintf( '<li class="%s"><a href="%s">%s %s</a></li>', $class, $item['url'],$item['icon'], $item['title'] );
            }
          //
      }
      ?>
    </ul> 
<!-- menu in setting -->
<?php }else{ 
            // echo dokan_dashboard_nav_menu();
    ?>
    <ul class="list-title-a list-profile-account list-dokan-dashboard dokan-dashboard-menu ">
        <li class="title">
            <a href="<?php echo dokan_get_navigation_url( '' ) ?>">Dashboard</a>
        </li>
        <li class="title">
            <a href="<?php echo dokan_get_navigation_url( 'reports' ) ?>"><?php the_field('title_reports','option'); ?></a>
        </li>
        <li class="title <?php if($active_menu == 'orders'){echo 'active';}  ?>">
            <a href="<?php echo dokan_get_navigation_url( 'orders' ) ?>"><?php the_field('title_sales_history','option'); ?></a>
        </li>
        <li class="title <?php if($active_menu == 'products'){echo 'active';}  ?>">
            <a href="<?php echo dokan_get_navigation_url( 'products' ); ?>"><?php the_field('title_my_listings','option'); ?></a>
        </li>
        <li class="title">
            <a href="<?php echo dokan_get_navigation_url( 'auction' ) ?>"><?php the_field('title_auction','option'); ?></a>
        </li>
        <li class="title">
            <a href="<?php echo dokan_get_navigation_url( 'coupons' ) ?>"><?php the_field('title_coupons','option'); ?></a>
        </li>
        <li class="title <?php if($active_menu == 'subscription'){echo 'active';}  ?>">
            <a href="<?php echo dokan_get_navigation_url( 'subscription' ) ?>"><?php the_field('title_subscription','option'); ?></a>
        </li>
        <li class="inbox title <?php if($active_menu == 'inbox'){echo 'active';}  ?>">
            <a href="<?php echo dokan_get_navigation_url( 'inbox' ) ?>"><?php the_field('title_inbox','option') ?></a>
        </li>
        <li class="title <?php if($active_menu == 'settings/store'){echo 'active';}  ?>">
            <a href="<?php echo dokan_get_navigation_url( 'settings/store' ); ?>"><?php the_field('title_shop_settings','option'); ?></a>
        </li>
        <li class="title <?php if($active_menu == 'settings/shipping'){echo 'active';}  ?>">
            <a href="<?php echo dokan_get_navigation_url( 'settings/shipping' ); ?>"><?php echo _e('Shipping','flatsome-child'); ?></a>
        </li>
		    <li class="title <?php if($active_menu == 'support'){echo 'active';}  ?>">
            <a href="<?php echo dokan_get_navigation_url( 'support' ); ?>"><?php echo _e('Support','flatsome-child'); ?></a>
        </li>
    </ul> 
<?php }
        // echo wp_kses( dokan_dashboard_nav( $active_menu ), $allowedposttags );
         // echo wp_kses( dokan_dashboard_nav_menu( $active_menu ), $allowedposttags );
?>


</div>
