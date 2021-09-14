<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use Angelleye_OFW_Dokan_Offers_Controller;

class DokanOffers extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.offers.offers'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'offers' => $this->display_offers(),
        ];
    }

    public function display_offers() {
        $ofw_dokan_offer_controller = new Angelleye_OFW_Dokan_Offers_Controller(OFWC_DOKAN_PLUGIN_NAME, OFWC_DOKAN_VERSION);

        return $ofw_dokan_offer_controller->display();
    }
}
