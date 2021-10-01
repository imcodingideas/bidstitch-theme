import 'jquery';

import {
    createUser,
    getCurrentSession,
    setPopupConversion,
} from './user-chat-utils';

export default function() {
    const domNodes = {
        messageButton: '.message__compose__button',
        messageButtonLabel: '.message__compose__button__label',
        messageButtonLoading: '.message__compose__button__loading',
    };

    const classList = {
        messageButtonLabelHidden: 'opacity-0',
    };

    // disable loading
    $(domNodes.messageButtonLabel).removeClass(classList.messageButtonLabelHidden);
    $(domNodes.messageButtonLoading).fadeOut();

    $(domNodes.messageButton).click(function() {
        const session = getCurrentSession();
        if (!session) return;

        // set message receiver as chat user
        const receiverData = $(this).data('message-receiver');
        if (!receiverData) return;
        const receiver = createUser(receiverData);

        // set sender receiver as chat user
        const senderData = session.me;
        if (!senderData) return;
        const sender = createUser(senderData);

        // create conversation
        const conversation = session.getOrCreateConversation(Talk.oneOnOneId(sender, receiver));
        conversation.setParticipant(sender);
        conversation.setParticipant(receiver);

        // create inbox history
        session.createInbox({selected: conversation});

        // open popup
        setPopupConversion(conversation);
    });
}