# Bidstitch theme

Based in: https://github.com/roots/sage version 10

# Install

```
composer install
yarn
yarn build
```

# Development

Add to wp-config.php

`define('WP_ENV', 'development');`


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

advanced-custom-fields-pro 5.9.9

### CPT

custom-post-type-ui 1.9.2

### Bidstitch tools

bidstitchtools custom: 0.1.1

### Fibosearch in header

ajax-search-for-woocommerce 1.13.0

Add its widget in sidebar-header for ajax search capabilities

https://wordpress.org/plugins/ajax-search-for-woocommerce/#installation

### mega menu

megamenu 2.9.4
megamenu-pro 2.2.2

### Woocommerce

woocommerce 5.5.1

### Dokan Lite

dokan-lite 3.2.9

### Dokan Pro

dokan-pro 3.3.3

### Offers for Woocommerce

offers-for-woocommerce 2.3.5

### Offers for Woocommerce Dokan

offers-for-woocommerce-dokan 1.0.0

### Auctions for Woocommerce

woocommerce-simple-auctions customized, based on 1.2.40 

### Paypal Woocommerce

paypal-woocommerce 2.5.11

### Paypal Multi Account

paypal-for-woocommerce-multi-account-management 3.1.0

### WooCommerce Simple Auction

woocommerce-simple-auctions ( git )

### WOOF - WooCommerce Products Filter

woocommerce-products-filter 2.2.5.4

### YITH WooCommerce Wishlist Premium

yith-woocommerce-wishlist-premium 3.0.23

This one displays the heart over images to mark them as favorites. 

Add to wishlist options

- Enable "Show "Add to wishlist" in loop 
- Position "on top of the image"

Wishlist page options

- Select page to add favorites
- Add shortcode in such page `[yith_wcwl_wishlist]`
- Remove "Share wishlist"


### Others

May not be essential

- safe-svg 1.9.9
- user-switching 1.5.7
- wpdiscuz 7.2.2
- wp-user-avatar custom

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
wp plugin deactivate paypal-for-woocommerce-multi-account-management
wp plugin deactivate paypal-woocommerce
wp plugin deactivate woocommerce-simple-auctions
wp plugin deactivate offers-for-woocommerce-dokan
wp plugin deactivate offers-for-woocommerce
wp plugin deactivate dokan-lite
wp plugin deactivate dokan-pro
wp plugin deactivate woocommerce
wp plugin deactivate megamenu-pro
wp plugin deactivate megamenu
wp plugin deactivate ajax-search-for-woocommerce
wp plugin deactivate bidstitchtools
wp plugin deactivate custom-post-type-ui
wp plugin deactivate advanced-custom-fields-pro
```


### Required changes in plugin dokan pro for "shipping rates editor"

To allow overriding dashboard/settings/shipping add these filters:

**file: includes/Settings.php L281**

```
echo apply_filters('dokan_shipping_zones_editor', $this->load_shipping_content());
```

Add a filter to remove js that registers vue:

**file: includes/Assets.php L173**

```

return apply_filters('dokan_shipping_zones_editor_scripts', $scripts);
```
