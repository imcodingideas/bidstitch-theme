<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FeaturedProduct extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.featured-product'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */

    public function with()
    {
        return [
            'product_id' => $this->data['product_id'],
            'featured' => $this->is_featured(),
        ];
    }

    protected function is_featured()
    {
        return (bool)get_post_meta($this->data['product_id'], '_bidstitch_featured_product', true);
    }
}
