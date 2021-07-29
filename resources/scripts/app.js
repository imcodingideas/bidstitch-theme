/**
 * External Dependencies
 */
import 'jquery';

$(() => {
  console.log('Hello world');
  // header-avatar
  $('#header-avatar').mouseenter(() => {
    $('#header-avatar-menu').removeClass('hidden');
  }).mouseleave(() => {
    $('#header-avatar-menu').addClass('hidden');
  });
});
