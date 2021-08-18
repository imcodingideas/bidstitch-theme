<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NewProductFieldDescription extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-field-description'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'post_content' => isset($post_data['post_content'])
                ? $post_data['post_content']
                : '',
        ];
    }
}
