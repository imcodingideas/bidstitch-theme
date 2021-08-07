import 'jquery';
export default function () {
  jQuery(document).ready(($) => {
    let timeout;
    $("#cart-menu-item").hover(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        $('#cart-menu-details').slideDown('fast');
      }, 50);
    }, () => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        $('#cart-menu-details').slideUp('fast');
      }, 500);
    });
  });
}

