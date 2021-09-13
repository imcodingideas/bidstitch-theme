import 'jquery';

export default function() {
    jQuery(document).ready(function() {
        const domNodes = {
            wrapper: '.woof_redraw_zone',
            overlay: '.product__filters__overlay',
            toggle: '.product__filters__toggle',
        };

        const classList = {
            openToggle: 'product__filters__toggle--open',
            closeToggle: 'product__filters__toggle--close',
            preventBodyScroll: 'overflow-hidden h-screen',
        };

        function handleOpen() {
            $('body').addClass(classList.preventBodyScroll);
            $(domNodes.overlay).fadeIn('fast');
            $(domNodes.wrapper).fadeIn('fast');
        }
        
        function handleClose() {
            $('body').removeClass(classList.preventBodyScroll);
            $(domNodes.overlay).fadeOut('fast');
            $(domNodes.wrapper).fadeOut('fast');
        }
    
        $(domNodes.toggle).click(function() {
            if ($(this).hasClass(classList.openToggle)) handleOpen();
            if ($(this).hasClass(classList.closeToggle)) handleClose();
        });

        $(domNodes.overlay).click(function() {
            handleClose();
        });
    });
}