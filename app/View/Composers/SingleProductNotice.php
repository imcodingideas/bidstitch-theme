<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class SingleProductNotice extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.single-product-notice'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'singe_product_notice' => get_field(
                'singe_product_notice',
                'option'
            ),
            'shop_page_url ' => get_permalink(wc_get_page_id('shop')),
        ];
    }
}
