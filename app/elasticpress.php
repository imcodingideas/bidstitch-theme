<?php

use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Log;

/**
 * Register Elasticpress Autosuggest Endpoint
 *
 * This is the endpoint you have to specify in the admin
 * like this: http(s)://domain.com/wp-json/elasticpress/autosuggest/
 */
add_action('rest_api_init', function () {
    register_rest_route('elasticpress', '/autosuggest/', [
        'methods' => \WP_REST_Server::CREATABLE,
        'callback' => 'ep_autosuggest',
        'permission_callback' => '__return_true',
    ]);
});

/**
 * Elasticpress Autosuggest Endpoint Callback
 *
 * gets host and index name dynamically. Otherwise,
 * if not specified, host would default to localhost:9200
 * and index name would default to 'index'
 *
 * @param \WP_REST_Request $data
 * @return array|callable
 */
function ep_autosuggest(\WP_REST_Request $data)
{
    /* Log::debug($data->get_body()); */
    $client = ClientBuilder::create();
    /* $client->setHosts(['https://bidstitchnew.localhost']); // get host dynamically */
    $client = $client->build();
    $params = [
        'index' => ep_get_index_name(), // get index dynamically
        'type' => 'post',
        'body' => $data->get_body(),
    ];
    $response = $client->search($params);
    return $response;
}
