import 'jquery';

export default function() { 
    const domNodes = {
        input: '.checkout__coupon__input',
        button: '.checkout__coupon__button',
        message: '.checkout__coupon__message',
    };

    const classList = {
        activeMessage: 'flex',
        inactiveMessage: 'hidden',
        successMessage: 'bg-green-50 text-green-800',
        errorMessage: 'bg-red-50 text-red-800',
        noticeMessage: 'bg-gray-50 text-gray-800',
        disabled: 'disabled opacity-50 cursor-not-allowed',
    };

    $(document).on('click', domNodes.button, function(e) {
        e.preventDefault();

        // prevent spam
        if ($(domNodes.input).prop('disabled') || $(this).prop('disabled')) {
            return;
        }

        // disable input
        function handleDisable() {
            $(domNodes.input).addClass(classList.disabled);
            $(domNodes.input).prop('disabled', true);

            $(domNodes.button).addClass(classList.disabled);
            $(domNodes.button).prop('disabled', true);
        }

        // enable input & reset default values
        function handleEnable() {
            $(domNodes.input).removeClass(classList.disabled);
            $(domNodes.input).prop('disabled', false);

            $(domNodes.button).removeClass(classList.disabled);
            $(domNodes.button).prop('disabled', false);
            $(domNodes.button).text('Apply');
        }

        // display notice messages
        function handleAddMessage(message = '', type = '') {
            if (!message) return;

            let messageColor

            if (type === 'error') {
                messageColor = classList.errorMessage;
            } else if (type === 'success') {
                messageColor = classList.successMessage;
            } else {
                messageColor = classList.noticeMessage;
            }

            $(domNodes.message).text(message);

            $(domNodes.message).addClass(messageColor);
            
            $(domNodes.message).removeClass(classList.inactiveMessage);
            $(domNodes.message).addClass(classList.activeMessage);
        }

        // remove notice messages
        function handleRemoveMessage() {
            $(domNodes.message).removeClass([
                classList.activeMessage,
                classList.successMessage,
                classList.errorMessage,
                classList.noticeMessage,
            ]);
            $(domNodes.message).addClass(classList.inactiveMessage);
        }

        // update WC cart and enable inputs
        function handleSuccess(couponCode = '') {
            $(document.body).trigger('applied_coupon_in_checkout', [ couponCode ]);
            $(document.body).trigger('update_checkout', { update_shipping_method: !1 });

            $(domNodes.input).val('');

            handleEnable();
        }

        // add error notice & delay user input
        function handleError(message = '') {
            handleAddMessage(message, 'error');

            setTimeout(() => {
                handleRemoveMessage();
                handleEnable();
            }, 2500);
        }

        // handle coupon input
        function handleSubmit() {
            let targetInputValue = $(domNodes.input).val();
            targetInputValue = targetInputValue.trim();
    
            if (!targetInputValue) return
    
            // disable field while submitting
            handleDisable()
    
            const formData = new FormData();
            formData.append('coupon_code', targetInputValue);
            formData.append('security', wc_checkout_params.apply_coupon_nonce);
            
            const url = wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'apply_coupon');
    
            fetch(url,
                {
                    body: formData,
                    method: 'POST'
                }
            )
            .then((response) => {
                return response.text();
            })
            .then((notice) => {
                if (!notice) throw new Error();
    
                if ($(notice).hasClass('woocommerce-error')) {
                    return handleError($(notice).text().trim());
                }
    
                handleSuccess(targetInputValue);
            })
            .catch((e) => {
                console.log(e)
                handleError('Something went wrong. Please refresh the page and try again.');
            });
        }

        handleSubmit();
    });
}