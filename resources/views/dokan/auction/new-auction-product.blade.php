<?php
// overwrites: dokan-pro/modules/simple-auction/templates/auction/new-auction-product.php
// version:  3.3.3

do_action( 'dokan_dashboard_wrap_start' );

use WeDevs\Dokan\Walkers\TaxonomyDropdown;

?>
<div class="dokan-dashboard-wrap">
    <?php
    do_action( 'dokan_dashboard_content_before' );
    do_action( 'dokan_new_auction_product_content_before' );
    ?>

    <div class="dokan-dashboard-content space-y-2">
        <h1 class="text-center text-2xl">Auctions are temporarily offline.</h1>
        <p class="text-center">Please list your products as "Buy it Now" as our development team looks towards optimizing auctions to improve the user experience!</p>
    </div>
</div>