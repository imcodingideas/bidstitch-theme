<?php

// read https://weichie.com/blog/curl-api-calls-with-php/

error_reporting(E_ERROR | E_PARSE);

function callUrl($method, $url, $data)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // EXECUTE:
    $result = curl_exec($curl);
    if (!$result) {
        die('Connection Failure');
    }
    curl_close($curl);
    return $result;
}

function searchProduct($search)
{
    $rawResponse = callUrl(
        'POST',
        'http://localhost:9200/_search?pretty ',
        json_encode([
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'multi_match' => [
                                'query' => $search,
                                'type' => 'phrase',
                                'fields' => ['post_title'],
                            ],
                        ],
                    ],
                    'filter' => [
                        [
                            'match' => [
                                'post_type.raw' => 'product',
                            ],
                        ],
                    ],
                ],
            ],
        ])
    );

    $response = json_decode($rawResponse);

    $products = [];
    foreach ($response->hits->hits as $item) {
        /* $products[] = $item->_source; */
        $price = '';
        if (count($item->_source->meta->_price) > 0) {
            $price = '$'.$item->_source->meta->_price[0]->value;
        } else {
            continue;
        }
        $products[] = [
            'id' => $item->_source->ID,
            'title' => $item->_source->post_title,
            'url' => $item->_source->permalink,
            'price' => $price,
        ];
    }

    return $products;
}

function searchVendor($search)
{
    $rawResponse = callUrl(
        'POST',
        'http://localhost:9200/_search?pretty ',
        json_encode([
            'query' => [
                'match' => [
                    'meta.dokan_store_name.value' => [
                        'query' => $search,
                    ],
                ],
            ],
        ])
    );

    $response = json_decode($rawResponse);
    $vendors = [];
    foreach ($response->hits->hits as $item) {
        $store_name = '';
        if (count($item->_source->meta->dokan_store_name) > 0) {
            $store_name = $item->_source->meta->dokan_store_name[0]->value;
        } else {
            continue;
        }
        /* $vendors[]= $item->_source; */
        $vendors[] = [
            'id' => $item->_source->ID,
            'title' => $store_name,
            'url' => $item->_source->user_nicename,
        ];
    }

    return $vendors;
}

if (empty($_GET['s'])) {
    die('parameter s missing');
}

$search = $_GET['s'];

$products = searchProduct($search);
$vendors = searchVendor($search);

// return json
header('Content-type: application/json');
echo json_encode([
    'products' => $products,
    'vendors' => $vendors,
]);
die();
