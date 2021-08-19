import 'jquery';
export default function() {
  jQuery(document).on('ready', function() {
    const domNodes = {
      sidenav: '.sidenav',
      sidenavToggle: '.sidenav__toggle',
      sidenavToggleOpen: '.sidenav__toggle--open',
      sidenavDropdownToggle: '.sidenav__dropdown__toggle',
      sidenavDropdownMenu: '.sidenav__dropdown__menu',
      navigationDropdown: '.navigation__dropdown',
      navigationDropdownMenu: '.navigation__dropdown__menu',
      navigationDropdownToggle: '.navigation__dropdown__toggle'
    };

    let isMobile = () => window.innerWidth < 1024

    // Handle sidenav display click toggle
    $(domNodes.sidenavToggle).click(function() {
      $(domNodes.sidenavToggleOpen).toggleClass('opacity-0');
      $(domNodes.sidenav).fadeToggle('fast');
    });

    // Handle sidenav dropdown click toggle
    $(domNodes.sidenavDropdownToggle).click(function() {
      $(this).next(domNodes.sidenavDropdown).slideToggle('fast');
    });

    // Handle navigation dropdown click toggle
    $(domNodes.navigationDropdownToggle).click(function() {
      // Only add click event listener for mobile devices
      isMobile() &&
      $(this).next(domNodes.navigationDropdownMenu).fadeToggle('fast');
    });

    // Handle navigation dropdown hover toggle
    $(domNodes.navigationDropdown).hover(
      function() {
        // Only add hover event listener for desktop devices
        !isMobile() && 
        $(this).find(domNodes.navigationDropdownMenu).fadeIn('fast')
      },
      function() {
        // Only add hover event listener for desktop devices
        !isMobile() && 
        $(this).find(domNodes.navigationDropdownMenu).fadeOut('fast')
      }
    );
  });
}

