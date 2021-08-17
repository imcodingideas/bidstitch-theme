<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NewProductFieldSize extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-field-size'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'terms_size' => get_terms([
                'taxonomy' => 'product_size',
                'hide_empty' => false,
            ]),
        ];
    }
}
