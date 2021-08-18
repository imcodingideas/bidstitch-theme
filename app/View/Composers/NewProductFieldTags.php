<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NewProductFieldTags extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-field-tags'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $can_create_tags = dokan_get_option(
            'product_vendors_can_create_tags',
            'dokan_selling'
        );
        return [
            'tags_placeholder' =>
                'on' === $can_create_tags
                    ? __('Select tags/Add tags', 'dokan-lite')
                    : __('Select product tags', 'dokan-lite'),
        ];
    }
}
