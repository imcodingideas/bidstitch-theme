<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WeDevs\Dokan\Walkers\TaxonomyDropdown;

class NewProductFieldCategory extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-field-category'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            /* 'category_args' => $this->category_args(), */
            /* 'sub_category' => $this->sub_category(), */
        ];
    }

    /* function sub_category() */
    /* { */
    /*     include_once DOKAN_LIB_DIR . '/class.taxonomy-walker.php'; */

    /*     $selected_cat = dokan_posted_input('product_cat', true); */
    /*     $selected_cat = empty($selected_cat) ? [] : $selected_cat; */

    /*     $sub_category = wp_dropdown_categories( */
    /*         apply_filters('dokan_product_cat_dropdown_args', [ */
    /*             'show_option_none' => __('', 'dokan-lite'), */
    /*             'hierarchical' => 1, */
    /*             'hide_empty' => 0, */
    /*             'name' => 'product_cat[]', */
    /*             'id' => 'product_cat', */
    /*             'taxonomy' => 'product_cat', */
    /*             'title_li' => '', */
    /*             'class' => 'product_cat dokan-form-control dokan-select2', */
    /*             'exclude' => '', */
    /*             'selected' => $selected_cat, */
    /*             'echo' => 0, */
    /*             'walker' => new TaxonomyDropdown(), */
    /*         ]) */
    /*     ); */
    /*     return $sub_category; */
    /* } */
}
