import jQuery from 'jquery';

import handleShipping from './woocommerce-checkout-shipping';
import handleCoupon from './woocommerce-checkout-coupon';
import handlePayment from './woocommerce-checkout-payment';

export default function () {
    jQuery(document).ready(function() {
        // handle shipping method change
        handleShipping();
        // handle coupon input
        handleCoupon();
        // handle payment method change
        handlePayment();
    })
}

