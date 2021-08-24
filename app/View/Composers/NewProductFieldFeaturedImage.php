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
    protected static $views = ['dokan.new-product-field-imagesxxx'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $feat_image_id = dokan_posted_input('feat_image_id');
        if (!empty($feat_image_id)) {
            $feat_image_url = wp_get_attachment_url($feat_image_id);
        }

        $gallery_items = $this->gallery();
        return compact(
            'hide_instruction',
            'feat_image_id',
            'feat_image_id_url',
            'hide_feat_image',
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
