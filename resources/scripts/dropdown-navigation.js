import 'jquery';
export default function() {
  jQuery(document).on('ready', function() {
    const domNodes = {
      navigationDropdown: '.navigation__dropdown',
      navigationDropdownMenu: '.navigation__dropdown__menu',
      navigationDropdownToggle: '.navigation__dropdown__toggle'
    };

    const isMobile = () => window.innerWidth < 1024;

    // Handle dropdown close on outside click
    const handleDropdownOutsideClick = (e) => {
      const targetNode = $('.navigation__dropdown__menu--active');
      const parentNode = $(targetNode).parent(domNodes.navigationDropdown);

      if (!parentNode.is(e.target) && parentNode.has(e.target).length === 0) {
        targetNode.fadeOut('fast');
        targetNode.removeClass('navigation__dropdown__menu--active');

        // Make sure to remove event listener
        return document.removeEventListener('click', handleDropdownOutsideClick);
      }
    };

    // Handle navigation dropdown click toggle
    $(domNodes.navigationDropdownToggle).click(function() {
      // Only add click event listener for mobile devices
      if (isMobile()) {
        const targetNode = $(this).next(domNodes.navigationDropdownMenu);

        // Hide other open dropdowns
        const currentNodes = $('.navigation__dropdown__menu--active').not(targetNode);
        currentNodes.fadeOut('fast');
        currentNodes.removeClass('navigation__dropdown__menu--active');

        if (targetNode.hasClass('navigation__dropdown__menu--active')) {
          targetNode.fadeOut('fast');
          targetNode.removeClass('navigation__dropdown__menu--active');
        } else {
          targetNode.fadeIn('fast');
          targetNode.addClass('navigation__dropdown__menu--active');

          // Add close event listeners
          document.addEventListener('click', handleDropdownOutsideClick);
        }
      }
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

