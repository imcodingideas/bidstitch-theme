import jQuery from 'jquery';
export default function () {
  jQuery(document).ready(function($) {
    const domNodes = {
      tabsItem: '.account__tabs__item',
      tabsToggle: '.account__tabs__toggle',
      tabsContent: '.account__tabs__content'
    };

    const classList = {
      activeItemClass: 'block',
      inactiveItemClass: 'hidden',
      activeToggleClass: 'bg-white',
      inactiveToggleClass: 'bg-gray-100',
    };

    function handleHashChange() {
      // scroll to top
      $('html, body').animate({ scrollTop: 0 }, 300);

      const sectionId = window.location.hash;
  
      if (sectionId) {
        $(domNodes.tabsToggle).each(function() {
          if ($(this).attr('href') === sectionId) {
            return handleTabChange.bind(this)();
          }
        });
      }
    }

    function handleTabChange (e) {
      if (e) e.preventDefault();

      const targetSelector = $(this).attr('href');
      const targetItemNode = $(`${targetSelector}${domNodes.tabsItem}`);

      // do nothing if same tab is clicked
      if (targetItemNode.hasClass(classList.activeItemClass)) return;

      targetItemNode.siblings()
        .removeClass(classList.activeItemClass)
        .addClass(classList.inactiveItemClass);
      targetItemNode
        .removeClass(classList.inactiveItemClass)
        .addClass(classList.activeItemClass);
      
      $(this).siblings()
        .addClass(classList.inactiveToggleClass)
        .removeClass(classList.activeToggleClass);
      $(this)
        .addClass(classList.activeToggleClass)
        .removeClass(classList.inactiveToggleClass);
    }

    // set active tab on click
    $(domNodes.tabsToggle).click(function(e) {
      e.preventDefault();
      window.location.hash = $(this).attr('href');
    });

    // set default tab based on hash
    handleHashChange();

    // change tabs on hash change
    $(window).on('hashchange', handleHashChange);
  });
}
