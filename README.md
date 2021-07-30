# Bidstitch theme

Based in: https://github.com/roots/sage version 10

# Install

```
composer install
yarn
yarn build
```

# Development

Add your local url to webpack.mix.js and then:

```
yarn start
```

# Packages

Composer

- log1x/navi: menu
- generoi/sage-woocommerce: woocommerce

# Plugins

Install activate in this order:

### ACF

advanced-custom-fields-pro

### CPT

custom-post-type-ui

### Bidstitch tools

bidstitchtools

### Fibosearch in header

ajax-search-for-woocommerce

Add its widget in sidebar-header for ajax search capabilities

https://wordpress.org/plugins/ajax-search-for-woocommerce/#installation

### mega menu

megamenu  
megamenu-pro

### Woocommerce

woocommerce

### Dokan Lite

dokan-lite

### Dokan Pro

dokan-pro

### Offers for Woocommerce

offers-for-woocommerce

### Offers for Woocommerce Dokan

offers-for-woocommerce-dokan

### Auctions for Woocommerce

woocommerce-simple-auctions

### Paypal Woocommerce

paypal-woocommerce

### Paypal Multi Account

paypal-for-woocommerce-multi-account-management

## Wp cli

Activate in order:

```
wp plugin activate advanced-custom-fields-pro
wp plugin activate custom-post-type-ui
wp plugin activate bidstitchtools
wp plugin activate ajax-search-for-woocommerce
wp plugin activate megamenu
wp plugin activate megamenu-pro
wp plugin activate woocommerce
wp plugin activate dokan-lite
wp plugin activate dokan-pro
wp plugin activate offers-for-woocommerce
wp plugin activate offers-for-woocommerce-dokan
wp plugin activate woocommerce-simple-auctions
wp plugin activate paypal-woocommerce
wp plugin activate paypal-for-woocommerce-multi-account-management
```

Deactivate in order:

```
wp plugin activate paypal-for-woocommerce-multi-account-management
wp plugin activate paypal-woocommerce
wp plugin activate woocommerce-simple-auctions
wp plugin activate offers-for-woocommerce-dokan
wp plugin activate offers-for-woocommerce
wp plugin activate dokan-lite
wp plugin activate dokan-pro
wp plugin activate woocommerce
wp plugin activate megamenu-pro
wp plugin activate megamenu
wp plugin activate ajax-search-for-woocommerce
wp plugin activate bidstitchtools
wp plugin activate custom-post-type-ui
wp plugin activate advanced-custom-fields-pro
```
