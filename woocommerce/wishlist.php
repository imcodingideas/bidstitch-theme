<?php

$view_args = [
    'wishlist' => $wishlist,
    'wishlist_items' => $wishlist_items
];
echo \Roots\view('woocommerce.wishlist.items', $view_args)->render();
