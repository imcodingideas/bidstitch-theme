<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanMyOffers extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.offers.my-offers'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'offers' => [],
        ];
    }

}
