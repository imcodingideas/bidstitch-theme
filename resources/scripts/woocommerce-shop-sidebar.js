import 'jquery';
export default function () {
  jQuery(document).ready(($) => {
    $(".cat-item").click(function () {
      $(this).find('.children').slideToggle('fast');
      $(this).toggleClass('current-cat-parent');
    });
  });
}

