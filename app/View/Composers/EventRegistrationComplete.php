<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class EventRegistrationComplete extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['events.registration-complete'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'email' => $this->get_email(),
        ];
    }

    protected function get_email()
    {
        return $_GET['email'];
    }
}
