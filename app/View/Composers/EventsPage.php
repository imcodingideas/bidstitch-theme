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
            'loggedIn' => is_user_logged_in(),
            'loginUrl' => esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))),
            'signupUrl' => esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '#register'),
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
                // Basic vars
                $title = get_the_title($event);
                $description = get_the_content(null, false, $event);
                $date = get_field('date', $event);
                $date_ymd = \DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
                $location = get_field('location', $event);

                // Get relevant GF for this event & populate if possible
                $form_id = get_field('registration_form', $event);

                if (is_user_logged_in()) {
                    $user = wp_get_current_user();

                    $form_values = [
                        'first_name' =>  $user->user_firstname,
                        'last_name' => $user->user_lastname,
                        'email' => $user->user_email,
                        'phone' => $user->billing_phone,
                    ];
                } else {
                    $form_values = false;
                }

                $form = gravity_form($form_id, false, false, false, $form_values, false, 1, false);

                // Collate into event object
                $events[] = (object)[
                    'title' => $title,
                    'description' => $description,
                    'date' => $date,
                    'date_ymd' => $date_ymd,
                    'location' => $location,
                    'form' => $form,
                ];
            }
        }

        wp_reset_postdata();

        return $events;
    }
}