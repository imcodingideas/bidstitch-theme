<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CommentsSingle extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.comments-single'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'comment_item' => $this->handle_comment()
        ];
    }

    public function get_comment_data() {
        $args = isset($this->data['args']) ? $this->data['args'] : false;
        if (empty($args)) return false;

        $comment = isset($this->data['comment']) ? $this->data['comment'] : false;
        if (empty($comment)) return false;

        $depth = isset($this->data['depth']) ? $this->data['depth'] : false;

        return (object) [
            'args' => $args,
            'comment' => $comment,
            'depth' => $depth
        ];
    }

    public function handle_comment_class($comment_data) {
        if (empty($comment_data)) return false;

        $class_list = ['relative block'];

        if (!empty($comment_data->args['has_children'])) {
            $class_list[] = 'parent';
        }

        if ($comment_data->depth > 1) {
            $class_list[] = 'ml-8';
        }

        return comment_class(implode(" ", $class_list), null, null, false);
    }

    public function handle_comment_avatar($comment_data) {
        if (empty($comment_data)) return false;

        $avatar_size = !empty($comment_data->args['avatar_size'] ) ? $comment_data->args['avatar_size'] : 32;

        return get_avatar($comment_data->comment, $avatar_size, '',  '', ['class' => 'h-8 w-8 rounded-full']);
    }

    public function handle_comment_date() {
        return human_time_diff(get_comment_time('U'), current_time('timestamp'));
    }

    public function handle_comment_reply_link($comment_data) {
        if (empty($comment_data)) return false;

        $comment_reply_args = [
            'add_below' => 'comment',
            'depth' => $comment_data->depth,
            'max_depth' => $comment_data->args['max_depth'],
        ];

        return get_comment_reply_link(array_merge($comment_data->args, $comment_reply_args));
    }

    public function handle_comment() {
        $comment_data = $this->get_comment_data();
        if (empty($comment_data)) return false;
        
        return (object) [
            'reply_link' => $this->handle_comment_reply_link($comment_data),
            'date' => $this->handle_comment_date($comment_data),
            'class' => $this->handle_comment_class($comment_data),
            'depth' => $comment_data->depth,
            'has_children' => $comment_data->args['has_children'],
            'id' => get_comment_ID(),
            'link' => get_comment_link(),
            'text' => get_comment_text(),
            'element' => $comment_data->args['style'],
            'type' => $comment_data->comment->comment_type,
            'author_link' => get_comment_author_link(),
            'author_name' => get_comment_author(),
            'author_avatar' => $this->handle_comment_avatar($comment_data),
            'edit_link' => get_edit_comment_link(),
            'approved' => $comment_data->comment->comment_approved != '0'
        ];
    }
}
