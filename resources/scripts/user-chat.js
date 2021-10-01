import 'jquery';
import Talk from 'talkjs';

import {
    getInitialSession,
    createInitialInbox,
    createInitialPopup
} from './user-chat-utils';

import handleMessageButton from './user-chat-button';
import handleInbox from './user-chat-inbox';

export default function() {
    // check if user is logged in before initilizing
    if (!bidstitchSettings.isLoggedIn) return;

    Talk.ready.then(function() {
        // get the chat session
        getInitialSession()
        .then(() => {
            // setup inbox
            createInitialInbox();
            // show popup if new message
            createInitialPopup();
            // handle chat init on button click
            handleMessageButton();
            // handle inbox widget on dashboad
            handleInbox();
        })
        .catch((e) => {
            console.log(e);
        });
    });
}