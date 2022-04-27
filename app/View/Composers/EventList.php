<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class EventList extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['archive-event'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $my_account_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
        $login_url = esc_url(add_query_arg('redirect_to', get_permalink(), $my_account_url));
        $signup_url = esc_url($my_account_url.'#register');

        return [
            'loggedIn' => is_user_logged_in(),
            'loginUrl' => $login_url,
            'signupUrl' => $signup_url,
            'events' => $this->get_events(),
        ];
    }

    protected function get_events() {
        $all_events = [];

        while (have_posts()) {
            the_post();

            // Basic vars
            $event_type = get_field('event_type');
            $title = get_the_title();
            $description = $event_type === 'partnered' ? get_the_excerpt() : get_the_content();
            $location = get_field('location');
            $link = $event_type === 'partnered' ? get_permalink() : get_field('event_link');
            $bg_image = $event_type === 'partnered' ? get_the_post_thumbnail_url(null, 'large') : false;

            // Date / date info
            $date_type = get_field('date_type');

            if ($date_type === 'date') {
                $date = get_field('date');
                $date_ymd = \DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
            } else {
                $date = $date_ymd = get_field('date_info');
            }

            // Collate into event object
            $all_events[] = (object)[
                'type' => $event_type,
                'title' => $title,
                'description' => $description,
                'date_type' => $date_type,
                'date' => $date,
                'date_ymd' => $date_ymd,
                'location' => $location,
                'link' => $link,
                'has_external_link' => (bool)get_field('event_link'),
                'has_form' => (bool)get_field('registration_form'),
                'bg_image' => $bg_image,
            ];
        }

        // Custom ordering to keep recurring events at the top
        usort($all_events, function($a, $b) {
            if ($a->date_type === 'text' && $b->date_type === 'date') {
                return -1;
            }

            if ($a->date_type === 'text' && $b->date_type === 'text') {
                return 0;
            }

            if ($a->date_type === 'date' && $b->date_type === 'text') {
                return 1;
            }

            if ($a->date_type === 'date' && $b->date_type === 'date') {
                return $a->date_ymd > $b->date_ymd;
            }
        });

        // Segregate partnered from external
        $events = [
            'partnered' => [],
            'external' => [],
        ];

        foreach ($all_events as $event) {
            $events[$event->type][] = $event;
        }

        return $events;
    }
}
