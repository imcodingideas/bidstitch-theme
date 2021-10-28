<?php

$view_args = [
    'wishlist' => $wishlist,
];
echo \Roots\view('woocommerce.wishlist.items', $view_args)->render();
