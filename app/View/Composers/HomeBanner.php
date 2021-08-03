<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class HomeBanner extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.home-banner'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'slides' => $this->slides(),
        ];
    }

    public function slides()
    {
        $rows = [];
        if (have_rows('content_slider')) {
            $i = 1;
            while (have_rows('content_slider')) {
                the_row();
                $link = get_sub_field('content_slider_link_button');
                if ($link == 4) {
                    if (!is_user_logged_in()) {
                        $link = wp_login_url();
                    } else {
                        if (dokan_is_seller_enabled(get_current_user_id())) {
                            $link = get_field('link_new_my_listing', 'option');
                        } else {
                            $link = get_field('page_create_shop', 'option');
                        }
                    }
                }
                $rows[] = [
                    'image' => get_sub_field('content_slider_image'),
                    'image_mobile' => get_sub_field('content_slider_image_mobile'),
                    'content' => get_sub_field('content_slider_content'),
                    'button' => get_sub_field('content_slider_button'),
                    'link' => $link,
                    'index' => $i,
                ];
                $i++;
            }
            return $rows;
        }
    }
}
