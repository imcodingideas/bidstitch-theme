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
        $display_create_and_add_new_button = $this->display_create_and_add_new_button();

        return compact(
            'dokan_is_seller_enabled',
            'display_create_and_add_new_button'
        );
    }
    function display_create_and_add_new_button()
    {
        $display_create_and_add_new_button = true;
        if (
            function_exists('dokan_pro') &&
            dokan_pro()->module->is_active('product_subscription')
        ) {
            if (
                \DokanPro\Modules\Subscription\Helper::get_vendor_remaining_products(
                    dokan_get_current_user_id()
                ) === 1
            ) {
                $display_create_and_add_new_button = false;
            }
        }
        return $display_create_and_add_new_button;
    }
}
