import 'jquery';
export default function() {
  jQuery(document).on('ready', function() {
    const domNodes = {
      sidenav: '.sidenav',
      sidenavToggle: '.sidenav__toggle',
      sidenavToggleOpen: '.sidenav__toggle--open',
      sidenavDropdownToggle: '.sidenav__dropdown__toggle',
      sidenavDropdownMenu: '.sidenav__dropdown__menu',
    };
    
    // Handle sidenav display click toggle
    $(domNodes.sidenavToggle).click(function() {
      $(domNodes.sidenavToggleOpen).toggleClass('opacity-0');
      $(domNodes.sidenav).fadeToggle('fast');
    });

    // Handle sidenav dropdown click toggle
    $(domNodes.sidenavDropdownToggle).click(function() {
      $(this).next(domNodes.sidenavDropdown).slideToggle('fast');
    });
  });
}

