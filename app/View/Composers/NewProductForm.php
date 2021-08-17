<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WeDevs\Dokan\Walkers\TaxonomyDropdown;

class NewProductForm extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.new-product-form'];

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
        $tags_placeholder =
            'on' === $can_create_tags
                ? __('Select tags/Add tags', 'dokan-lite')
                : __('Select product tags', 'dokan-lite');
        $post_content = isset($post_data['post_content'])
            ? $post_data['post_content']
            : '';

        $dokan_is_seller_enabled = dokan_is_seller_enabled(
            get_current_user_id()
        );
        $category_args = $this->category_args();
        $drop_down_category = $this->drop_down_category();
        $display_create_and_add_new_button = $this->display_create_and_add_new_button();

        return compact(
            'can_create_tags',
            'tags_placeholder',
            'post_content',
            'dokan_is_seller_enabled',
            'category_args',
            'display_create_and_add_new_button'
        );
    }
    function category_args()
    {
        $selected_cat = dokan_posted_input('product_cat');
        $category_args = [
            'show_option_none' => __('- Select a category -', 'dokan-lite'),
            'hierarchical' => 1,
            'hide_empty' => 0,
            'name' => 'product_cat',
            'id' => 'product_cat',
            'taxonomy' => 'product_cat',
            'title_li' => '',
            'class' => 'product_cat dokan-form-control dokan-select2',
            'exclude' => '',
            'selected' => $selected_cat,
            'walker' => new TaxonomyDropdown(),
        ];
        return $category_args;
    }
    function drop_down_category()
    {
        include_once DOKAN_LIB_DIR . '/class.taxonomy-walker.php';

        $selected_cat = dokan_posted_input('product_cat', true);
        $selected_cat = empty($selected_cat) ? [] : $selected_cat;

        $drop_down_category = wp_dropdown_categories(
            apply_filters('dokan_product_cat_dropdown_args', [
                'show_option_none' => __('', 'dokan-lite'),
                'hierarchical' => 1,
                'hide_empty' => 0,
                'name' => 'product_cat[]',
                'id' => 'product_cat',
                'taxonomy' => 'product_cat',
                'title_li' => '',
                'class' => 'product_cat dokan-form-control dokan-select2',
                'exclude' => '',
                'selected' => $selected_cat,
                'echo' => 0,
                'walker' => new TaxonomyDropdown(),
            ])
        );
        return $drop_down_category;
    }
    function display_create_and_add_new_button()
    {
        $display_create_and_add_new_button = true;
        if (
            function_exists('dokan_pro') &&
            dokan_pro()->module->is_active('product_subscription')
        ) {
            if (
                \DokanPro\Modules\Subscription\Helper::get_vendor_remaining_products(
                    dokan_get_current_user_id()
                ) === 1
            ) {
                $display_create_and_add_new_button = false;
            }
        }
        return $display_create_and_add_new_button;
    }
}
