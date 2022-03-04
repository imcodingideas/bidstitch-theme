<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ArchiveSidebar extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.archive-sidebar'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'categories' => $this->get_parent_categories(),
            'page_for_posts' => $this->get_page_for_posts(),
        ];
    }

    public function get_active_term_id() {
        if (!is_archive()) return '';

        $term_id = get_queried_object()->term_id;
        if (empty($term_id)) return '';

        return $term_id;
    }

    public function get_parent_categories() {
        // Exclude "Dealer Spotlight"
        $dealer_spotlight = get_term_by('slug', 'dealer-spotlight', 'category');

        $query_args = [
            'taxonomy' => 'category',
            'hide_empty' => false,
            'exclude' => $dealer_spotlight->term_id,
            'parent' => 0,
        ];

        $term_list = get_terms($query_args);
        if (empty($term_list)) return false;

        $payload = [];

        // default topic as post listing page
        $posts_page_id = $this->get_page_for_posts();
        if (!empty($posts_page_id)) {
            $payload[] = (object) [
                'name' => 'All Topics',
                'link' => get_permalink(get_option('page_for_posts')),
                'active' => is_home(),
            ];
        }

        $active_term_id = $this->get_active_term_id();

        foreach($term_list as $term) {
            $payload[] = (object) [
                'name' => $term->name,
                'link' => get_term_link($term->term_id),
                'active' => !empty($active_term_id) && $active_term_id == $term->term_id,
            ];
        }

        return $payload;
    }

    public function get_page_for_posts() {
        $posts_page_id = get_option('page_for_posts');
        if (empty($posts_page_id)) return false;

        return $posts_page_id;
    }
}
