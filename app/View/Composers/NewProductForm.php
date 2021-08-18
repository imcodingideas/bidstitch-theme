<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NewProductForm extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-form'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $dokan_is_seller_enabled = dokan_is_seller_enabled(
            get_current_user_id()
        );

        return compact(
            'dokan_is_seller_enabled'
        );
    }
}
