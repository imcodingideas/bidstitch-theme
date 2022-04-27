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
        // BACKWARDS COMPATIBILITY:
        // If there's an excerpt then that will be displayed on the top
        // and we can show the content here. No excerpt means the content
        // has already been displayed on the top.
        global $post;

        return [
            'content' => $post->post_excerpt ? get_the_content() : '',
        ];
    }
}
