<?php 
$view_args = [
    'seller_list' => $sellers,
    'per_row' => $per_row,
    'limit' => $limit,
    'search_query' => $search_query,
    'paged' => $paged,
    'pagination_base' => $pagination_base
];

echo \Roots\view('dokan.store-lists-loop', $view_args)->render();