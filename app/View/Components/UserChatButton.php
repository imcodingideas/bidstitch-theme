<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

use App\UserChat;

class UserChatButton extends Component
{
    /**
     * The auth status for messaging capability
     *
     * @var boolean
     */
    public $user_can_message;

    /**
     * The message receiver data
     *
     * @var string
     */
    public $receiver_data;

    /**
     * The button label
     *
     * @var string
     */
    public $message;

    /**
     * Create the component instance.
     *
     * @param string $receiver
     * @param string $message
     * @return void
     */
    public function __construct($receiver = '', $message = 'Chat Now')
    {
        $user_can_message = is_user_logged_in();

        $this->user_can_message = $user_can_message;
        $this->receiver_data = $user_can_message ? UserChat::get_receiver_data($receiver) : false;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('components.user-chat-button');
    }
}
