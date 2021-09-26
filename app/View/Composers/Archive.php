<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Archive extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['archive'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'archive_title' => $this->get_archive_title(),
            'archive_description' => $this->get_archive_description(),
            'pagination' => $this->pagination(),
            'featured_layout' => $this->get_featured_layout()
        ];
    }

    public function get_archive_title() {
        if (is_archive()) return single_term_title('', false);

        $search_results = $this->get_search_title();
        if ($search_results) {
            return 'Showing results for: ' . esc_html(get_search_query(false));
        }

        return false;
    }

    public function get_archive_description() {
        if (is_archive()) {
            $term_id = get_queried_object()->term_id;
            if (empty($term_id)) return;

            $term = get_term($term_id);
            if (empty($term)) return;

            return $term->description;
        }

        return false;
    }

    public function pagination() {
        $pagination_args = [
            'prev_text' => __('&larr; Previous', 'sage'),
            'next_text' => __('Next &rarr;', 'sage'),
            'type' => 'array',
        ];

        $links = paginate_links($pagination_args);

        return $links;
    }

    public function get_search_title() {
        $search_query = get_search_query(false);
        if (empty($search_query)) return false;

        return $search_query;
    }

    public function get_featured_layout() {
        // never show featured posts past first page
        if (is_paged()) return false;

        return true;
    }
}
