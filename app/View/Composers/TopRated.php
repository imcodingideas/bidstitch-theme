<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class TopRated extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.top-rated'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'products' => $this->products(),
            'title' => 'Top rated',
        ];
    }

    public function products()
    {
        return do_shortcode('[top_rated_products limit=5 columns=5]');
    }
}
