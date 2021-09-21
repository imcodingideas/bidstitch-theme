import 'jquery';

export default function() {
    jQuery(document).ready(function() {
        function handleModal () {
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
        }

        function handleSubmitLink() {
            // if the function does not exist, then return 
            if (woof_get_submit_link === 'undefined') return;

            // get the default link function
            const handleInitialLink = woof_get_submit_link

            // override function to include search
            // by default, search is removed from query
            woof_get_submit_link = function() {
                let link = handleInitialLink();

                // check if is reset action
                if (woof_reset_btn_action) return link;

                // get search
                const queryString = window.location.search;
                if (!queryString) return link;
    
                const urlParams = new URLSearchParams(queryString);
    
                const searchParam = urlParams.get('s');
                if (!searchParam) return link;
    
                // add search param to link
                link = new URL(link);
                link.searchParams.set('s', searchParam);
                
                return link.toString();
            }
        }
    
        handleSubmitLink();
        handleModal();
    });
}