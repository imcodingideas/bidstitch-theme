<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class StoreListsLoop extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.store-lists-loop'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        return [
            'sellers' => $this->get_sellers(),
            'pagination' => $this->pagination(),
        ];
    }

    public function get_sellers() {
        $sellers = isset($this->data['seller_list']) ? $this->data['seller_list'] : false;
        if (!$sellers || !$sellers['users']) return false;

        $payload = [];

        foreach($sellers['users'] as $seller) {
            $vendor = dokan()->vendor->get($seller->ID);

            $store_name = $vendor->get_shop_name();
            $store_url = $vendor->get_shop_url();
            $store_avatar = $vendor->get_avatar();

            $payload[] = (object) [
                'store_name' => $store_name,
                'store_url' => $store_url,
                'store_avatar' => $store_avatar,
            ];
        }

        return $payload;
    }

    public function pagination() {
        $sellers = isset($this->data['seller_list']) ? $this->data['seller_list'] : false;
        if (!$sellers) return false;

        $limit = isset($this->data['limit']) ? $this->data['limit'] : false;
        if (!$limit) return false;

        $paged = isset($this->data['paged']) ? $this->data['paged'] : false;
        if (!$paged) return false;
        
        $pagination_base = isset($this->data['pagination_base']) ? $this->data['pagination_base'] : false;
        if (!$pagination_base) return false;

        $search_query = isset($this->data['search_query']) ? $this->data['search_query'] : false;

        $user_count = $sellers['count'];
        $num_of_pages = ceil($user_count / $limit);

        if ($num_of_pages <= 1) return false;

        $pagination_args = [
            'current' => $paged,
            'total' => $num_of_pages,
            'base' => $pagination_base,
            'add_args' => false,
            'type' => 'array',
            'prev_text' => __('&larr; Previous', 'sage'),
            'next_text' => __('Next &rarr;', 'sage'),
        ];

        if (!empty($search_query)) {
            $pagination_args['add_args'] = [
                'dokan_seller_search' => $search_query,
            ];
        }

        $links = paginate_links($pagination_args);

        return $links;
    }

}