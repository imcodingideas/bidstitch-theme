<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class AuctionsEndingSoon extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.auctions-ending-soon'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'args' => $this->args(),
        ];
    }

    public function args()
    {
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 5,
            'orderby' => 'meta_value_num',
            'meta_key' => '_auction_dates_to',
            'order' => 'asc',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_auction_current_bid',
                    'compare' => 'EXISTS',
                ],
                [
                    'key' => '_auction_closed',
                    'compare' => 'NOT EXISTS',
                ],
            ],
        ];
        return $args;
    }
}
