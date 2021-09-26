<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ContentSinglePost extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.content-single-post'];

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
            'avatar' => get_avatar(get_the_author_meta('ID'), 36),
            'author' => get_the_author(),
            'thumbnail' => $this->get_archive_thumbnail(),
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

    public function get_archive_thumbnail() {
        if (!has_post_thumbnail()) return false;

        return get_the_post_thumbnail(null, 'large', ['class' => 'object-cover object-center']);
    }
}
