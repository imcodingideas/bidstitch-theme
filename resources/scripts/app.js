/**
 * External Dependencies
 */
import Alpine from 'alpinejs'
import headerNavigation from './header-navigation';
import dropdownNavigation from './dropdown-navigation';
import homeSlider from './home-slider';
import woocommerceMiniCart from './woocommerce-mini-cart';
import woocommerceShopSidebar from './woocommerce-shop-sidebar';
import woocommerceAccountTabs from './woocommerce-account-tabs';
import woocommerceCheckout from './woocommerce-checkout';
import woocommerceProductsFilter from './woocommerce-products-filter'
import singleProductAccordion from './single-product-accordion';
import shippingRatesEditor from './shipping-rates-editor';
import newProductForm from './new-product-form';
import productFieldCategorySubcategorySize from './product-field-category-subcategory-size';
import headerNotifications from './header-notifications';
import notificationsPage from './notifications-page';
import elasticpressSearchWidget from './elasticpress-search-widget';
import vendorOnboardingForm from './vendor-onboarding-form';
import talkjsMessageUser from './talkjs-message-user'

headerNavigation();
dropdownNavigation();
homeSlider();
woocommerceMiniCart();
woocommerceShopSidebar();
woocommerceAccountTabs();
woocommerceCheckout();
woocommerceProductsFilter();
singleProductAccordion();
shippingRatesEditor();
newProductForm();
productFieldCategorySubcategorySize();
headerNotifications();
notificationsPage();
elasticpressSearchWidget();
vendorOnboardingForm();
talkjsMessageUser();

// load alpine at the end
Alpine.start();
