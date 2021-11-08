(function ($) {
    $(document).on('ready', function () {
        const domNodes = {
            discountType: '#discount_type',
            subscriptionTrialField: '#dokan_stripe_trial_days',
        }

        // check if field exists
        if (!$(domNodes.subscriptionTrialField)) return;

        // handle discount select change
        function handleChange() {
            // set discount type
            const stripeTrialDiscount = 'dokan_subscripion_stripe_trial';

            // check if current select value is stripe trial
            const isSubscriptionDiscount = $(domNodes.discountType).val() === stripeTrialDiscount;

            // set required prop based
            $(domNodes.subscriptionTrialField).prop('required', isSubscriptionDiscount);
        }

        // trigger change on init
        handleChange();

        // handle discount type change handler
        $(domNodes.discountType).change(handleChange);
    });
})(jQuery);