<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class DokanNavMenu extends Composer {
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.admin.nav-menu'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with() {
        return [
            'store_url' => $this->get_store_url(),
            'endpoints' => $this->get_endpoints(),
        ];
    }

    public function get_store_url() {
        if (!isset($this->data['store_url'])) return false;
        if (empty($this->data['store_url'])) return false;

        return $this->data['store_url'];
    }

    public function get_endpoints() {
        if (!isset($this->data['endpoints'])) return false;
        if (empty($this->data['endpoints'])) return false;

        return $this->data['endpoints'];
    }
}
