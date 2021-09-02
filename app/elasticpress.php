<?php

add_action('widgets_init', function () {
    register_widget('App\Widgets\ElasticpressSearchWidget');
});
