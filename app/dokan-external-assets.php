<?php

// TODO: don't enqueue ALL, it's heavy

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'name', // name
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css',
        [], // dependencies
        null, // version
        'screen' // media
    );
});
