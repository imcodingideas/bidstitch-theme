import 'jquery';
export default function () {
  jQuery(document).ready(($) => {
    let timeout;
    $("#header-notifications-icon").hover(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        $('#header-notifications').slideDown('fast');
      }, 50);
    }, () => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        $('#header-notifications').slideUp('fast');
      }, 500);
    });
  });
}

