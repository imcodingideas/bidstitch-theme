import 'jquery';
import 'slick-carousel'

export default function () {
  jQuery(document).ready(function ($) {
    // http://kenwheeler.github.io/slick/
    const runSlick = () => {
      jQuery('.home-slider__slider').slick({
        autoplay: true,
        speed: 3000,
        dots: false,
        arrows: false,
        infinite: true,
        autoplaySpeed: 4000,
        slidesToShow: 1,
        slidesToScroll: 1
      });
    };

    runSlick();
  });
}
