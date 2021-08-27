<?php

/* use Illuminate\Support\Facades\Log; */

// see: public/class-offers-for-woocommerce.php
add_action(
    'angelleye_offer_for_woocommerce_before_email_send',
    function ($offer_args, $offersClass) {
        /* debug: */
        /* Log::debug('-----------offer args-----------'); */
        /* Log::debug(var_export($offer_args, true)); */
        /* Log::debug('-----------offer emails-----------'); */
        /* Log::debug(var_export($offersClass, true)); */

        // email templates
        $themePath = get_theme_file_path('resources/views/notifications/');

        // define email template/path (html)
        $offersClass->template_html = "woocommerce-offer-received.php";
        $offersClass->template_html_path = $themePath;

        // define email template/path (plain)
        $offersClass->template_plain = "woocommerce-offer-received.php";
        $offersClass->template_plain_path = "$themePath/plain";
        $offersClass->send(
            $offersClass->get_recipient(),
            $offersClass->get_subject(),
            $offersClass->get_content(),
            $offersClass->get_headers(),
            $offersClass->get_attachments()
        );
        die();
    },
    10,
    2
);
