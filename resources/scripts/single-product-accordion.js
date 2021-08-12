import 'jquery';
export default function () {
  jQuery(document).ready(($) => {
    $(".single-product-accordion__tab-top").click(function () {
      const tab = $(this).data('tab');
      $(this).toggleClass('open');
      $(tab).find('.single-product-accordion__tab-content').slideToggle('fast');
    });
  });
}

