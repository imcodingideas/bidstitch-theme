<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanListingFilter extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.products.listing-filter'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'search' => $this->search(),
        ];
    }

    public function search() {
        $get_data = wp_unslash($_GET);

        $field_name = 'product_search_name';

        return (object) [
            'name' => $field_name,
            'label' => 'Search',
            'value' => isset($get_data[$field_name]) ? esc_attr($get_data[$field_name]) : '',
            'active_query' => isset($get_data[$field_name])
        ];
    }
}
