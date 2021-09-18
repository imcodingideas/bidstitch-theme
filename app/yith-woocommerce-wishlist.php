<?php
// remove font-awesome
add_action('wp_enqueue_scripts', function() {
    wp_deregister_style('yith-wcwl-font-awesome');
    wp_dequeue_style('yith-wcwl-font-awesome');
}, 11);