<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class EventDetail extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['single-event'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'event' => $this->get_event(),
        ];
    }

    protected function get_event()
    {
        // Basic vars
        $title = get_the_title();
        $description = get_the_content();
        $date = get_field('date');
        $date_ymd = \DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
        $location = get_field('location');
        $bg_image = get_the_post_thumbnail_url();

        // Get relevant GF for this event & populate if possible
        $form_id = get_field('registration_form');

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

        return (object)[
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'date_ymd' => $date_ymd,
            'location' => $location,
            'bg_image' => $bg_image,
            'form' => $form,
        ];
    }
}