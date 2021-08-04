<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ShortDescriptionInfoTable extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.single-product.short-description-info-table',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'terms_size' => get_the_terms(get_the_ID(), 'product_size'),
            'terms_color' => get_the_terms(get_the_ID(), 'product_color'),
            'terms_condition' => get_the_terms(
                get_the_ID(),
                'product_condition'
            ),
            'tees_tip' => get_field('tees_tip'),
            'tees_length' => get_field('tees_length'),
            'tees_tag_type' => get_field('tees_tag_type'),
            'tees_stitchig' => get_field('tees_stitching'),
        ];
    }
}
