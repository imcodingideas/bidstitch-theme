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
  // fetch notifications
  const fetchNotifications = () => {
    $('#header-notifications').html('loading...');
    $.post(
      // localized global variable
      bidstitchSettings.ajaxUrl,
      {
        'action': 'fetch_notifications',
      },
      function (response) {
        $('#header-notifications').html(response)
      }
    );
  }

  // on hover
  const registerIconHover = () => {
    let timeout;
    $("#header-notifications-icon").hover(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        $('#header-notifications').slideDown('fast');
        fetchNotifications();
      }, 50);
    }, () => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        $('#header-notifications').slideUp('fast');
      }, 500);
    });
  }

  // load
  registerIconHover();
  fetchNotificationsCount();

  // fetch notifications every x seconds
  // localized var app/setup.php
  if (bidstitchSettings && bidstitchSettings.isLoggedIn)
    window.setInterval(fetchNotificationsCount, 30000);
}

