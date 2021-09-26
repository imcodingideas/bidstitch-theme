<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ContentArchivePost extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.content-archive-post'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'title' => get_the_title(),
            'category' => $this->get_primary_category(),
            'avatar' => get_avatar(get_the_author_meta('ID'), 36, '', '', ['class' => 'h-6 w-6 md:h-8 md:w-8 object-cover object-center']),
            'author' => get_the_author(),
            'featured' => $this->get_featured_status(),
            'link' => get_permalink(),
            'thumbnail' => $this->get_archive_thumbnail(),
            'excerpt' => get_the_excerpt(),
        ];
    }

    public function get_primary_category() {
        // if is archive page use the archive term
        if (is_archive()) {
            $term_name = single_term_title('', false);
            if (empty($term_name)) return;

            return $term_name;
        }

        // if has primary category
        if (function_exists('the_seo_framework')) {
            $primary_category = the_seo_framework()->get_primary_term(get_the_ID(), 'category');

            if (!empty($primary_category)) {
                return $primary_category->name;
            }
        }

        // show first category
        $categories = get_the_category();
        if (empty($categories)) return false;
        
        return $categories[0]->name;
    }

    public function get_featured_status() {
        // if not featured layout
        if (!isset($this->data['featured_layout'])) return false;
        $featured_layout = $this->data['featured_layout'];
        if (empty($featured_layout)) return false;

        // if no iteration exists
        if (!isset($this->data['iteration'])) return false;
        $iteration = $this->data['iteration'];
        if (empty($iteration)) return false;

        // if is not first item
        if ($iteration != 1) return false;

        return true;
    }

    public function get_archive_thumbnail() {
        if (!has_post_thumbnail()) return false;

        $size = $this->get_featured_status() ? 'large' : 'medium';

        return get_the_post_thumbnail(null, $size, ['class' => 'object-cover object-center']);
    }
}
