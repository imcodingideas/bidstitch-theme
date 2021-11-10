<?php
namespace App;

use App\OffersHelpers;

class OffersFormRequest {
    protected $input_data; 

    public function handle_submit() {
        // check if can submit offers
        $user_can_submit = $this->current_user_can_submit();
        if (!$user_can_submit)
            return $this->handle_error_response('You cannot create offers');

        // get the offer request type
        $request_type = $this->get_offer_request_type();

        // check if is valid offer request type
        if (empty($request_type))
            return $this->handle_error_response('Invalid offer request');

        // get the form input data
        $input_data = $this->get_offer_input_data();

        // set input data
        $this->input_data = $input_data;

        // handle request
        $this->handle_request($request_type);
    }

    protected function handle_request($request_type = '') {
        if (empty($request_type)) return $this->handle_error_response();

        // get input data
        $input_data = $this->input_data;

        // get offer id
        $offer_id = $input_data['offer_id'];

        // get product id
        $offer_product_id = $input_data['offer_product_id'];

        switch ($request_type) {
            case 'countered-offer':
                // check if current user can counteroffer
                $user_can_counteroffer = OffersHelpers::current_user_can_counteroffer($offer_id);
                if (!$user_can_counteroffer) 
                    return $this->handle_error_response('You cannot send a counter offer');

                $this->set_vendor_request_data($request_type);
                $this->handle_vendor_request();
                break;
            case 'buyercountered-offer':
                // check if current user can buyer counteroffer
                $user_can_buyer_counteroffer = OffersHelpers::current_user_can_buyer_counteroffer($offer_id);
                if (!$user_can_buyer_counteroffer) 
                    return $this->handle_error_response('You cannot send a counter offer');
        
                $this->set_customer_request_data();
                $this->handle_customer_request();
                break;
            case 'publish':
                // check if user can create offer
                $user_can_create_offer = OffersHelpers::current_user_can_create_offer($offer_product_id);
                if (!$user_can_create_offer)
                    return $this->handle_error_response('You cannot send a new offer');
        
                $this->set_customer_request_data();
                $this->handle_customer_request();
                break;
        }
    }

    protected function handle_customer_request() {
        $ofc_instance = \Angelleye_Offers_For_Woocommerce::get_instance();
        $ofc_instance->new_offer_form_submit();
    }

    protected function handle_vendor_request() {
        $input_data = $this->input_data;
        $offer_id = $input_data['offer_id'];

        $offer_form = new \Angelleye_OFW_Dokan_Offer_Form(OFWC_DOKAN_PLUGIN_NAME, OFWC_DOKAN_VERSION);
        $response_data = $offer_form->save_offer($offer_id);

        if (empty($response_data)) return $this->handle_error_response();

        $this->handle_success_response();
    }

    protected function current_user_can_submit() {
        // check if user can offer
        $current_user_can_offer = OffersHelpers::current_user_can_offer();
        if (!$current_user_can_offer)
            return false;
        
        // check if nonce empty
        if (!isset($_POST['nonce'])) 
            return false;

        // get nonce
        $nonce = wc_clean($_POST['nonce']);  

        // check if valid nonce
        if (!wp_verify_nonce($nonce, 'bidstitch-offer-form-submit')) 
            return false;
            
        return true;
    }

    protected function get_offer_request_type() {
        if (!isset($_POST['offer_action'])) return false;
        if (empty($_POST['offer_action'])) return false;

        $action = wc_clean($_POST['offer_action']);

        $actionable_statuses = [
            'publish',
            'buyercountered-offer',
            'countered-offer'
        ];

        // check if action is valid
        if (!in_array($action, $actionable_statuses)) return false;

        return $action;
    }

    protected function validate_offer_price_input($offer_price = '') {
        // check if price value is empty
        if (empty($offer_price)) 
            return $this->handle_error_response('Please enter a valid price');

        // check if price value is numeric
        if (!is_numeric($offer_price)) 
            return $this->handle_error_response('Please enter a valid price');

        // check if price value is greater than minimum allowed value
        if ($offer_price <= 0)
            return $this->handle_error_response('Please enter a price greater than 0');

        // check if price length is greater than maximum allowed length
        if (strlen($offer_price) > 15)
            return $this->handle_error_response('Please enter a smaller price');

        return $offer_price;
    }

    protected function validate_offer_notes_input($offer_notes = '') {
        if (empty($offer_notes)) return $offer_notes;

        // check if note length is greater than maximum allowed length
        if (strlen($offer_notes) > 250)
            return $this->handle_error_response('Please enter a shorter description');

        return $offer_notes;
    }

    protected function validate_offer_product_input($offer_product_id = '') {
        if (empty($offer_product_id)) return $offer_product_id;

        // check if offers enabled on product
        $offers_enabled = OffersHelpers::get_offers_enabled_status_by_product_id($offer_product_id);
        if (!$offers_enabled)
            return $this->handle_error_response('You cannot create offers for this listing');

        return $offer_product_id;
    }

    protected function validate_offer_id_input($offer_id = '') {
        if (empty($offer_id)) return $offer_id;

        // check if offer exists
        $offer = OffersHelpers::get_offer_by_id($offer_id);
        if (empty($offer))
            return $this->handle_error_response('Invalid offer');

        return $offer_id;
    }

    protected function get_offer_input_data() {
        // check if posted values exist
        if (!isset($_POST))
            return $this->handle_error_response();

        // set default form data
        $input_data = [
            'offer_price' => '',
            'offer_notes' => '',
            'offer_product_id' => '',
            'offer_product_price' => '',
            'offer_id' => '',
            'offer_uid' => '',
            'offer_name' => '',
            'offer_email' => ''
        ];

        // get offer id
        if (
            isset($_POST['offer_id'])
            && !empty($_POST['offer_id'])
        ) {
            $offer_id = (int) wc_clean($_POST['offer_id']);
            $input_data['offer_id'] = $this->validate_offer_id_input($offer_id);
        }

        // get offer uid
        if (
            isset($input_data['offer_id'])
            && !empty($input_data['offer_id'])
        ) {
            $offer_uid = OffersHelpers::get_offer_uid($input_data['offer_id']);
                if (!empty($offer_uid))
                    $input_data['offer_uid'] = $offer_uid;
        }
        
        // get price input
        if (
            isset($_POST['offer_price'])
            && !empty($_POST['offer_price'])
        ) {
            $offer_price = (int) wc_clean($_POST['offer_price']);
            $input_data['offer_price'] = self::validate_offer_price_input($offer_price);
        }

        // get product input
        if (
            isset($_POST['offer_product_id'])
            && !empty($_POST['offer_product_id'])
        ) {
            $offer_product_id = (int) wc_clean($_POST['offer_product_id']);
            $input_data['offer_product_id'] = self::validate_offer_product_input($offer_product_id);
        }

        // get product price
        if (
            isset($input_data['offer_product_id'])
            && !empty($input_data['offer_product_id'])
        ) {
            $product = wc_get_product($offer_product_id);
            $input_data['offer_product_price'] = $product->get_price();
        }

        // get offer notes
        if (
            isset($_POST['offer_notes'])
            && !empty($_POST['offer_notes'])
        ) {
            $offer_notes = wc_clean($_POST['offer_notes']);
            $input_data['offer_notes'] = self::validate_offer_notes_input($offer_notes);
        }

        // get current user
        $current_user = wp_get_current_user();

        // get offer name
        $input_data['offer_name'] = $current_user->display_name;

        // get offer email
        $input_data['offer_email'] = $current_user->user_email;
        
        return $input_data;
    }
    
    protected function set_customer_request_data() {
        $input_data = $this->input_data;

        $form_data = [
            'offer_variation_id' => '',
            'offer_quantity' => 1,
            'offer_product_id' => $input_data['offer_product_id'],
            'offer_product_price' => $input_data['offer_product_price'],
            'offer_total' => $input_data['offer_price'],
            'offer_price_each' => $input_data['offer_price'],
            'parent_offer_id' => $input_data['offer_id'],
            'parent_offer_uid' => $input_data['offer_uid'],
            'offer_notes' => $input_data['offer_notes'],
            'offer_email' => $input_data['offer_email'],
            'offer_name' => $input_data['offer_name'],
            'join_our_mailing_list' => '',
        ];

        $payload = [];

        foreach($form_data as $key => $value) {
            $payload[] = [
                'name' => $key,
                'value' => $value
            ];
        }

        $_POST['value'] = $payload;
    }

    protected function set_vendor_request_data($request_type = '') {
        if (empty($request_type)) $this->handle_error_response();

        $input_data = $this->input_data;

        $offer_id = $input_data['offer_id'];
        $offer_notes = $input_data['offer_notes'];
        $offer_price = $input_data['offer_price'];    

        $offer_status = get_post_status($offer_id);

        $form_data = [
            'post_status' => $request_type,
            'post_previous_status' => $offer_status,
            'offer_quantity' => 1,
            'offer_price_per' => $offer_price,
            'angelleye_woocommerce_offer_status_notes' => $offer_notes,
        ];

        foreach($form_data as $key => $value) {
            $_POST[$key] = $value;
        }
    }

    public static function handle_success_response($message = 'Your offer has been sent!') {
        // response structure from plugin: offers for woocommerce
        $payload = [
            'statusmsg' => 'success',
            'statusmsgDetail' => __($message, 'sage')
        ];

        wp_send_json($payload);
    }

    public static function handle_error_response($message = 'Something went wrong! Please try again.') {
        // response structure from plugin: offers for woocommerce
        $payload = [
            'statusmsg' => 'failed',
            'statusmsgDetail' => __($message, 'sage')
        ];

        wp_send_json($payload);
    }
}