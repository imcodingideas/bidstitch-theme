<?php 

$view_args = [
    'ofw_dokan_template' => $ofw_dokan_template,
    'offer_list' => $get_offers,
    'results' => $resutls,
    'current_page' => $current_page,
    'ofw_dokan_controller' => $ofw_dokan_controller,
    'controller_type' => $controller_type
];
echo \Roots\view('dokan.offers.offers-view', $view_args)->render();