<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SingleProductShortDescription extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.single-product.short-description'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'short_description' => $this->get_short_description(),
        ];
    }

    public function get_short_description() {
        global $post;

        $short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);
        if (empty($short_description) || !$short_description) return false;

        return $short_description;
    }
}
