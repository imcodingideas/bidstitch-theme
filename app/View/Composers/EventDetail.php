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
        return $this->get_event();
    }

    protected function get_event()
    {
        // Basic vars
        $title = get_the_title();
        $description = get_the_content();
        $location = get_field('location');
        $bg_image = get_the_post_thumbnail_url();

        // Date / date info
        $date_type = get_field('date_type');

        if ($date_type === 'date') {
            $event_date = get_field('date');
            $date = \DateTime::createFromFormat('m/d/Y', $event_date)->format('F d Y');
            $date_ymd = \DateTime::createFromFormat('m/d/Y', $event_date)->format('Y-m-d');
        } else {
            $date = $date_ymd = get_field('date_info');
        }

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

        $form = gravity_form($form_id, false, false, false, $form_values, true, 1, false);

        return [
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