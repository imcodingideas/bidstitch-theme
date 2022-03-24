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
    protected static $views = ['single-event-registration'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'title' => get_the_title(),
            'content' => get_the_content(),
            'main_logo' => get_field('main_logo'),
            'other_logos' => get_field('other_logos'),
            'form' => $this->get_form(),
        ];
    }

    protected function get_form()
    {
        $form_id = get_field('registration_form');
        return gravity_form($form_id, false, false, false, [], true, 1, false);
    }
}
