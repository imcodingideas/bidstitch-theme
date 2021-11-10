<?php

use App\OffersFormRequest;

add_action('wp_ajax_bidstitch-offer-form-submit', function() {
    try {
        $form_request = new OffersFormRequest();
        $form_request->handle_submit();
    } catch (Exception $e) {
        OffersFormRequest::handle_error_response();
    }

    wp_die();
});