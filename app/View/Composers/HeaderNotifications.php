<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HeaderNotifications extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.header-notifications'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'products' => [
                [
                    'title' => 'Offer declined',
                    'text' =>
                        'MSI Radeon RX Vega 56 8G Reference Graphics Card',
                    'thumbnail' =>
                        'https://bidstitchprod.s3.amazonaws.com/uploads/2021/07/9020_1024x1024@2x-220x220.jpg',
                    'link' => '#',
                    'isOffer' => false,
                ],
                [
                    'title' => 'Offer accepted',
                    'text' =>
                        'Deadstock Toy Story 2 & 1 Double Feature 3D Movie Promo Disney Pixar T Shirt XL',
                    'thumbnail' =>
                        'https://bidstitchprod.s3.amazonaws.com/uploads/2021/07/9020_1024x1024@2x-220x220.jpg',
                    'link' => '#',
                    'isOffer' => false,
                ],
                [
                    'title' => 'Offer declined ',
                    'text' => 'Buffy the Vampire Slayer Tee',
                    'thumbnail' =>
                        'https://bidstitchprod.s3.amazonaws.com/uploads/2021/07/9020_1024x1024@2x-220x220.jpg',
                    'link' => '#',
                    'isOffer' => true,
                ],
            ],
        ];
    }
}
