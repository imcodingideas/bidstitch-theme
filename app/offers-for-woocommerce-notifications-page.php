<?php

namespace App;

// notifications shortcode
add_shortcode('bidstitch_notifications', function () {
    return \Roots\view('partials.notifications-page')->render();
});
