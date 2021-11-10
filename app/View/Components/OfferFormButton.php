<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class OfferFormButton extends Component
{
    /**
     * The id of the offer
     *
     * @var string
     */
    public $offer_id;

    /**
     * The offer's product id
     *
     * @var string
     */
    public $offer_product_id;

    /**
     * The the default offer price
     *
     * @var string
     */
    public $offer_price;

    /**
     * The offer action type.
     *
     * @var string
     */
    public $offer_action;

    /**
     * The offer action types.
     *
     * @var array
     */
    public $offer_actions = [
        'publish',
        'countered-offer',
        'buyercountered-offer'
    ];

    /**
     * Create the component instance.
     *
     * @param string $offer_action
     * @param string $offerId
     * @param string $offer_product_Id
     * @param string $offer_price
     * @return void
     */
    public function __construct($offerAction = '', $offerId = '', $offerProductId = '', $offerPrice = '')
    {
        // set action type
        $this->offer_action = $this->get_offer_action($offerAction);

        // set offer product
        $this->offer_product_id = $offerProductId;

        // set offer id
        $this->offer_id = $offerId;

        // set offer price
        $this->offer_price = $offerPrice;
    }

    /**
     * Get the view contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('components.offer-form-button');
    }

    private function get_offer_action($offer_action = '') {
        if (empty($offer_action)) return '';

        // check if is valid action
        if (!in_array($offer_action, $this->offer_actions)) return '';
    
        return $offer_action;
    }
}
