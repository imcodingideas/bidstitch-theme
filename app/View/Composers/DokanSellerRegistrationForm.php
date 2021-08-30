<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanSellerRegistrationForm extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.seller-registration-form'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'role' => $this->get_role(),
            'store_base_url' => $this->store_base_url(),
            'terms' => $this->terms(),
        ];
    }

    public function get_role() {
        $postdata = wc_clean($_POST);

        return isset( $postdata['role'] ) ? $postdata['role'] : 'customer';
    }

    public function store_base_url() {
        return esc_url(home_url() . '/' . dokan_get_option('custom_store_url', 'dokan_general', 'store'));
    }

    public function terms() {
        $show_terms_condition = dokan_get_option('enable_tc_on_reg', 'dokan_general');
        $terms_condition_url = dokan_get_terms_condition_url();

        if ('on' === $show_terms_condition && $terms_condition_url) {
            return esc_url($terms_condition_url);
        }

        return false;
    }
}
