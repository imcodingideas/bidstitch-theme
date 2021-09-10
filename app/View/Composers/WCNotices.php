<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class WCNotices extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.notices'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        return [
            'notice_types' => $this->get_notice_types(),
        ];
    }

    public function get_notice_types() {
        if (wc_notice_count() < 1) return false;

        $notice_types = WC()->session->get('wc_notices', []);

        // clear notices after fetching them to get new notices only
        wc_clear_notices();

        return $notice_types;
    }
}