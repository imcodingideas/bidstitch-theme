<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FooterIcons extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.footer-icons'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'instagram' => get_field('link_instagram', 'option'),
            'facebook' => get_field('link_facebook', 'option'),
            'twitter' => get_field('link_twitter', 'option'),
        ];
    }
}
