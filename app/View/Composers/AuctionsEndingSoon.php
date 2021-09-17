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
        // check auctions with dates between
        // and not closed
        $local_date = date_i18n('Y-m-d H:i');
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'orderby' => 'meta_value',
            'meta_key' => '_auction_dates_to',
            'order' => 'asc',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_auction_closed',
                    'compare' => 'NOT EXISTS',
                ],
                [
                    'key' => '_auction_dates_from',
                    'value' => $local_date,
                    'compare' => '<',
                ],
                [
                    'key' => '_auction_dates_to',
                    'value' => $local_date,
                    'compare' => '>',
                ]
            ],
        ];
        return $args;
    }
}
