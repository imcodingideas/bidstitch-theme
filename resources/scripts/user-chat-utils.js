import Talk from 'talkjs';

// create conversation participant
export const createUser = (userData) => {
    if (!userData) return;

    const talkUser = new Talk.User({
        ...userData,
        // email is not required and should not be public
        email: `user-${userData.id}@bidstitch.com`,
        configuration: 'vendor',
    });

    return talkUser;
}

// get current session
export const getCurrentSession = () => {
    const { talkSession } = window;

    if (!talkSession) return false;
    
    return talkSession;
}

// create new session
export const createSession = () => {
    return new Promise((resolve, reject) => {
        const endpoint = `/wp-json/chat/v1/session/`;

        fetch(endpoint, {
            method: 'GET',
            headers: {
                'X-WP-Nonce': bidstitchSettings.restNonce
            }
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            resolve(data.data);
        })
        .catch((e) => {
            reject(e);
        });
    });
}

// set conversation on popup
export const setPopupConversion = (conversation) => {
    const session = window.talkSession;

    if (!session) return;
    
    const popupList = session.getPopups();

    // if no popups exist, then create one
    if (popupList.length === 0) {
        const targetPopup = session.createPopup(conversation);
        targetPopup.mount();

        return targetPopup;
    }

    // if there are multiple popups, remove them
    // only 1 popup is needed. 
    // switch conversation instead of creating new popups
    if (popupList.length > 1) {
        popupList.forEach((popup, index) => {
            if (index > 0) popup.destroy();
        });
    }

    const targetPopup = popupList[0];
    targetPopup.select(conversation);
    targetPopup.show();

    return targetPopup;
}

// set inbox conversation
export const setInboxConversation = (conversation) => {
    const session = getCurrentSession();
    if (!session) return;

    const inboxList = session.getInboxes();

    // If no inbox exists, then create one
    // only 1 inbox is needed. 
    // switch conversation instead of creating new inboxes
    if (inboxList.length === 0) {
        const targetInbox = session.createInbox();

        return targetInbox;
    }

    if (inboxList.length > 1) {
        inboxList.forEach((inbox, index) => {
            if (index > 0) inbox.destroy();
        });
    }

    const targetInbox = inboxList[0];
    targetInbox.select(conversation);

    return targetInbox;
}

// get initial session
export const getInitialSession = () => {
    return new Promise((resolve, reject) => {
        const session = getCurrentSession();

        if (session) resolve(session);

        createSession()
        .then((sessionData) => {
            const session = new Talk.Session({
                ...sessionData,
                me: createUser(sessionData.me)
            });

            window.talkSession = session;

            resolve(session);
        })
        .catch((e) => {
            reject(e);
        });
    });
}

// create initial inbox widget
export const createInitialInbox = () => {
    const session = getCurrentSession();
    if (!session) return;

    setInboxConversation();
}

// create initial popup widget
export const createInitialPopup = () => {
    const session = getCurrentSession();
    if (!session) return;

    session.unreads.on('change', function(unreadConversation) {
        // if conversation has been read, don't open poopup
        if (!unreadConversation.read) return;

        setPopupConversion(unreadConversation.conversation);
    });
}