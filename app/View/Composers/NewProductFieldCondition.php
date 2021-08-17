<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NewProductFieldCondition extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-field-condition'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'terms_condition' => get_terms([
                'taxonomy' => 'product_condition',
                'hide_empty' => false,
            ]),
        ];
    }
}
