<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BestSelling extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.best-selling-products'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'products' => $this->products(),
            'title' => 'Best Selling',
        ];
    }

    public function products()
    {
        return do_shortcode('[best_selling_products limit=5 columns=5]');
    }
}
