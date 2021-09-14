<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SingleProductDetails extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.single-product-accordion-details'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'content' => get_the_content(),
        ];
    }
}
