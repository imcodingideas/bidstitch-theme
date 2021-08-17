<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NewProductFieldColor extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-field-color'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'terms_color' => get_terms([
                'taxonomy' => 'product_color',
                'hide_empty' => false,
            ]),
        ];
    }
}
