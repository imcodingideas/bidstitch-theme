<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class MyAccountLogin extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.form-login'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'auto_generate_username' => $this->auto_generate_username(),
            'auto_generate_password' => $this->auto_generate_password()
        ];
    }

    public function auto_generate_username() {
        return 'yes' === get_option('woocommerce_registration_generate_username');
    }

    public function auto_generate_password() {
        return 'yes' === get_option('woocommerce_registration_generate_password');
    }
}
