<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class EventsPage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['page-events'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'events' => $this->get_events(),
        ];
    }

    protected function get_events() {
        $events = [];
        $today = date('Y-m-d');

        $args = [
            'post_type' => 'event',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'date',
                    'compare' => '>',
                    'value' => $today,
                    'type' => 'DATETIME',
                ],
            ],
            'order'          => 'ASC',
            'orderby'        => 'meta_value',
            'meta_key'       => 'date',
            'meta_type'      => 'DATETIME'
        ];

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            foreach ($query->posts as $event) {
                $events[] = (object)[
                    'title' => get_the_title($event),
                    'description' => get_the_content(null, false, $event),
                    'date' => get_field('date', $event),
                    'location' => get_field('location', $event),
                ];
            }
        }

        wp_reset_postdata();

        return $events;
    }
}