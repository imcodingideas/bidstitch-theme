<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NewProductFieldFeaturedImage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-field-images'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $posted_img = dokan_posted_input('feat_image_id');
        $posted_img_url = $hide_instruction = '';
        $hide_img_wrap = 'dokan-hide';
        $gallery_items = $this->gallery();

        if (!empty($posted_img)) {
            $posted_img = empty($posted_img) ? 0 : $posted_img;
            $posted_img_url = wp_get_attachment_url($posted_img);
            $hide_instruction = 'dokan-hide';
            $hide_img_wrap = '';
        }
        return compact(
            'hide_instruction',
            'posted_img',
            'posted_img_url',
            'hide_img_wrap',

            'gallery_items'
        );
    }

    function gallery()
    {
        $items = [];
        if (isset($post_data['product_image_gallery'])) {
            $product_images = $post_data['product_image_gallery'];
            $gallery = explode(',', $product_images);

            if ($gallery) {
                foreach ($gallery as $image_id) {
                    if (empty($image_id)) {
                        continue;
                    }

                    $attachment_image = wp_get_attachment_image_src(
                        $image_id,
                        'thumbnail'
                    );
                    $items[] = [
                        'id' => $image_id,
                        'url' => $attachment_image[0],
                    ];
                }
            }
        }
        return $items;
    }
}
