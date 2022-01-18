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
        $events = [
            'partnered' => [],
            'external' => [],
        ];

        while (have_posts()) {
            the_post();

            // Basic vars
            $allow_registration = get_field('allow_registration');
            $title = get_the_title();
            $description = $allow_registration ? get_the_excerpt() : get_the_content();
            $date = get_field('date');
            $date_ymd = \DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
            $location = get_field('location');
            $link = $allow_registration ? get_permalink() : get_field('event_link');
            $bg_image = $allow_registration ? get_the_post_thumbnail_url(null, 'large') : false;

            $key = $allow_registration ? 'partnered' : 'external';

            // Collate into event object
            $events[$key][] = (object)[
                'title' => $title,
                'description' => $description,
                'date' => $date,
                'date_ymd' => $date_ymd,
                'location' => $location,
                'allow_registration' => $allow_registration,
                'link' => $link,
                'bg_image' => $bg_image,
            ];
        }

        return $events;
    }
}