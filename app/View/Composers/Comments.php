<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Comments extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.comments'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'password_required' => post_password_required(),
            'has_comments' => have_comments(),
            'comment_list_args' => $this->get_comment_list_args(),
            'comments_open_status' => $this->get_comments_open_status(),
            'pagination' => $this->pagination(),
            'comment_form_args' => $this->get_comment_form_args(),
        ];
    }

    private function get_comment_type() {
        if (!isset($this->data['comment_type'])) return false;
        if (empty($this->data['comment_type'])) return false;

        return $this->data['comment_type'];
    }

    private function handle_comment_type_nonce($args) {
        $comment_type = $this->get_comment_type();
        if (empty($comment_type)) return $args;

        $nonce_action = 'bidstitch_comment_type_' . $comment_type;
        $nonce_name = $nonce_action . '_nonce';

        $args['comment_field'] .= wp_nonce_field($nonce_action, $nonce_name, true, false);

        return $args;
    }

    public function pagination() {
        $page_comments_enabled = get_option('page_comments');
        if (!$page_comments_enabled) return false;

        $comment_page_count = get_comment_pages_count();
        if ($comment_page_count <= 1) return false;

        $prev_comments_link = get_previous_comments_link();
        $nev_comments_link = get_next_comments_link();
        
        return (object) [
            'prev_link' => $prev_comments_link ? get_previous_comments_link(__('&larr; Older comments', 'sage')) : false,
            'next_link' => $nev_comments_link ? get_next_comments_link(__('Newer comments &rarr;', 'sage')) : false,
        ];
    }

    public function get_comments_open_status() {
        if (!comments_open()) return false;
        if (!post_type_supports(get_post_type(), 'comments')) return false;

        return true;
    }

    public function get_comment_list_args() {
        $args = [
            'style' => 'div', 
            'short_ping' => true, 
            'callback' => [$this, 'comments_callback']
        ];

        $comment_type = $this->get_comment_type();
        if (empty($comment_type)) return $args;

        $args['type'] = $comment_type;

        return $args;
    }

    public function comments_callback($comment, $args, $depth) {
        $view_args = [
            'comment' => $comment,
            'args' => $args,
            'depth' => $depth,
        ];
    
        echo \Roots\view('partials.comments-single', $view_args)->render();
    }

    public function get_comment_form_args() {
        $args = [
            'comment_field' => '<textarea id="comment" name="comment" rows="4" class="block text-sm appearance-none w-full px-3 py-2 border border-gray-300 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black" aria-required="true"></textarea>',
            'must_log_in' => sprintf(__('<p class="p-3 text-sm"><a class="btn btn--sm btn--black" href="%s">Login to Comment</a></p>'), esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')))),
            'title_reply_before' => __('<div class="flex items-center space-x-2 p-3 border-b border-gray-300 justify-between uppercase font-bold min-w-0"><span class="min-w-0 truncate flex-1 comment-reply-title" id="reply-title">'),
            'title_reply_after' => __('</div>'),
            'title_reply' => __('Leave a Reply'),
            'title_reply_to' => __('Leave a Reply to %s'),
            'cancel_reply_before' => '</span>',
            'cancel_reply_after' => '',
        ];

        $args = $this->handle_comment_type_nonce($args);

        return $args;
    }
}
