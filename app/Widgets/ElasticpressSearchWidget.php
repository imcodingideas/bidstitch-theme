<?php

namespace App\Widgets;

class ElasticpressSearchWidget extends \WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'elasticpress-search-widget', // Base ID
            'Elasticpress custom search widget', // Name
            [
                'description' =>
                    'Search via elasticpress custom proxy in /wp-content/themes/bidstitch/elasticproxy/search.php?s=thesearch',
            ]
        );
    }

    public function widget($args, $instance)
    {
        echo \Roots\view('widgets/elasticpress-search-widget')->render();
    }
}
