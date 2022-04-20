<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FeaturedArticles extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.featured-articles'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'articles' => $this->get_articles(),
        ];
    }

    protected function get_articles()
    {
        $articles = [];

        $posts = get_posts([
            'numberposts' => 3,
        ]);

        foreach ($posts as $post) {
            $categories = get_the_category($post->ID);

            $articles[] = (object)[
                'category' => $categories[0]->name,
                'title' => $post->post_title,
                'image_url' => get_the_post_thumbnail_url($post),
                'link' => get_permalink($post),
            ];
        }

        return $articles;
    }
}
