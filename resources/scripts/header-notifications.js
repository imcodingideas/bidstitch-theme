import 'jquery';
export default function () {

  // fetch count, hide if none
  const fetchNotificationsCount = () => {
    $.post(
      // localized global variable
      bidstitchSettings.ajaxUrl,
      {
        'action': 'fetch_notifications_count',
      },
      function (response) {
        if (response == 0) {
          $('#header-notifications-count-wrapper').hide();
        }
        else {
          $('#header-notifications-count-wrapper').fadeIn();
          $('#header-notifications-count').html(response)
        }

      }
    );
  }
  const setAsLoading = () => {
    $('#header-notifications').html('loading...');
  }
  // fetch notifications
  const fetchNotificationsContent = () => {
    setAsLoading();
    $.post(
      // localized global variable
      bidstitchSettings.ajaxUrl,
      {
        'action': 'fetch_notifications',
      },
      function (response) {
        $('#header-notifications').html(response);
        // this has to be registered here, doesn't exist on first render
        registerMarkNotificationAsReadOnClick();
        registerAccept();
        registerDecline();
      }
    );
  }

  // on hover
  let timeout;
  let isVisible = false;
  const registerIconHover = () => {
    $("#header-notifications-icon").hover(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        if (!isVisible) {
          isVisible = true;
          fetchNotificationsContent();
          $('#header-notifications').slideDown('fast');
        }
      });
    }, () => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        if (isVisible) {
          isVisible = false;
          $('#header-notifications').slideUp('fast');
        }
      }, 500);
    });
  }

  // on mark as read
  const markAsReadAjax = (id) => {
    // mark as read
    $.post(
      // localized global variable
      bidstitchSettings.ajaxUrl,
      {
        'action': 'notification_mark_as_read',
        'id': id,
      }).then(() => {
        fetchNotificationsCount()
      })
  }


  // register event on click
  const registerMarkNotificationAsReadOnClick = () => {
    $('.header-notifications__mark-as-read').click(
      (event) => {
        const id = $(event.currentTarget).data('id');
        // remove item from list
        $(`#header-notifications__item-${id}`).fadeOut('slow');
        // send post request
        markAsReadAjax(id)
      }
    )
  }

  // accept
  const registerAccept = () => {
    $('.header-notifications__accept').click(
      (event) => {
        setAsLoading();
        const target = $(event.currentTarget).data('target')
        $.post(
          // localized global variable
          bidstitchSettings.ajaxUrl,
          {
            'action': 'approveOfferFromGrid',
            'targetID': target
          },
          function (response) {
            fetchNotificationsContent();
          }
        );
      }
    )
  }

  // decline
  const registerDecline = () => {
    $('.header-notifications__decline').click(
      (event) => {
        setAsLoading();
        const target = $(event.currentTarget).data('target')
        $.post(
          // localized global variable
          bidstitchSettings.ajaxUrl,
          {
            'action': 'declineOfferFromGrid',
            'targetID': target
          },
          function (response) {
            fetchNotificationsContent();
          }
        );
      }
    )
  }

  // fetch notifications every x seconds
  // localized var app/setup.php
  if (bidstitchSettings && bidstitchSettings.isLoggedIn){

  // load
  registerIconHover();
  fetchNotificationsCount();

    window.setInterval(fetchNotificationsCount, 30000);
  }
}

