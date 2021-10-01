import 'jquery';

import {
    getCurrentSession,
    setInboxConversation,
} from './user-chat-utils';

export default function() {
    const domNodes = {
        messageInboxWrapper: '.message__inbox__wrapper',
        messageInboxLoading: '.message__inbox__loading'
    };

    // if inbox does not exist, return
    if ($(domNodes.messageInboxWrapper).length === 0) return;

    // get user session
    const session = getCurrentSession();
    if (!session) return;

    // set inbox conversation
    const inbox = setInboxConversation();

    // show the inbox widget
    inbox.mount($(domNodes.messageInboxWrapper))
    .then(() => {
        // once loaded, remove the loading dom node
        $(domNodes.messageInboxLoading).remove();
    });
}