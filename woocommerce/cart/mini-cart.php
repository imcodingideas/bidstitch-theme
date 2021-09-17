<?php 
$view_args = [
    'args' => $args
];

echo \Roots\view('woocommerce.cart.mini-cart', $view_args)->render();