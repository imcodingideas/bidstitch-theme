import 'jquery';

export default function() {
    // check if Talkjs is enabled
    window.Talk && 
    window.Talk.ready.then(function() {
        const domNodes = {
            messageButton: '.message__compose__button'
        };

        // create talk user from user data
        function createTalkUser(userData) {
            if (!userData) return;

            const talkUser = new Talk.User({
                ...userData,
                // email is not required and should not be public
                email: `user-${userData.id}@bidstitch.com`,
                configuration: 'vendor',
            });

            return talkUser;
        }

        $(domNodes.messageButton).click(function() {
            // since Talkjs is initialized on every page, just check for existing session
            if (!window.talkSession) return;

            // set message receiver as chat user
            const receiverData = $(this).data('message-receiver');
            if (!receiverData) return;
            const receiver = createTalkUser(receiverData);

            // set sender receiver as chat user
            const senderData = window.talkSession.me;
            if (!senderData) return;
            const sender = createTalkUser(senderData);

            // create conversation
            const conversation = talkSession.getOrCreateConversation(Talk.oneOnOneId(sender, receiver));
            conversation.setParticipant(sender);
            conversation.setParticipant(receiver);

            // create inbox history
            talkSession.createInbox({selected: conversation});

            // open popup
            const popup = talkSession.createPopup(conversation);
            popup.mount();
        });
    });
}