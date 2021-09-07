import 'jquery';

export default function() {
    $(document.body).on('payment_method_selected', function() {
        const domNodes = {
            wrapper: '.checkout__paymentmethod__wrapper',
            input: '.checkout__paymentmethod__input',
            content: '.checkout__paymentmethod__content'
        };
    
        const classList = {
            contentActive: 'flex',
            contentInactive: 'hidden'
        };

        // scroll to active element
        function handleScroll () {
            const scrollPos = $(this).offset().top;
            const headerHeight = $('header').height();

            $('html, body').animate({ scrollTop: scrollPos - headerHeight }, 300);
        }
    
        function handleInputChange() {
            const dataTarget = $(this).attr('id');
    
            const targetContentNode = $(`.${dataTarget}`);
            
            $(targetContentNode).removeClass(classList.contentInactive);
            $(targetContentNode).addClass(classList.contentActive);
    
            
            $(domNodes.content).not($(targetContentNode)).removeClass(classList.contentActive);
            $(domNodes.content).not($(targetContentNode)).addClass(classList.contentInactive);
    
            
            handleScroll.bind(this)();
        }
    
        handleInputChange.bind($(`${domNodes.input}:checked`))();
    });
}