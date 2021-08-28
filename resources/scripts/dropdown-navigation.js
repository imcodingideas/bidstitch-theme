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
      const targetNode = $('.navigation__dropdown--active');

      if (!targetNode.is(e.target) && targetNode.has(e.target).length === 0) {
        targetNode.removeClass('navigation__dropdown--active');

        // Make sure to remove event listener
        return document.removeEventListener('click', handleDropdownOutsideClick);
      }
    };

    // Handle navigation dropdown click toggle
    $(domNodes.navigationDropdownToggle).click(function() {
      // Only add click event listener for mobile devices
      if (isMobile()) {
        const targetNode = $(this).parent(domNodes.navigationDropdown);

        // Hide other open dropdowns
        const currentNodes = $('.navigation__dropdown--active').not(targetNode);
        currentNodes.removeClass('navigation__dropdown--active');

        if (targetNode.hasClass('navigation__dropdown--active')) {
          targetNode.removeClass('navigation__dropdown--active');
        } else {
          targetNode.addClass('navigation__dropdown--active');

          // Add close event listeners
          document.addEventListener('click', handleDropdownOutsideClick);
        }
      }
    });
  });
}

