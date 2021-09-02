# Bidstitch theme

Based in: https://github.com/roots/sage version 10

# System requirements

Elasticsearch 5.0+ (max version supported: 7.9)


```
# Test elastic working in port 9200:
curl -X GET "http://localhost:9200/_cat/nodes?v&pretty"
curl -X GET 'http://localhost:9200/_cat/indices?v'
```

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

### Woocommerce

woocommerce 5.5.1

### Dokan Lite

dokan-lite 3.2.9

### Dokan Pro

dokan-pro 3.3.3

### Offers for Woocommerce

offers-for-woocommerce 2.3.10

https://github.com/angelleye/offers-for-woocommerce

update: 

```
git clone git@github.com:angelleye/offers-for-woocommerce.git
wp plugin deactivate offers-for-woocommerce
wp plugin activate offers-for-woocommerce
```

Configuration:

- Form display type = lightbox


### Offers for Woocommerce Dokan

offers-for-woocommerce-dokan 1.0.0

https://github.com/angelleye/offers-for-woocommerce-dokan

Update:

```
git clone git@github.com:angelleye/offers-for-woocommerce-dokan.git
wp plugin deactivate offers-for-woocommerce-dokan
wp plugin activate offers-for-woocommerce-dokan
```

Requires

- Offers For Woocommerce
- WooCommerce Simple Auction

### Auctions for Woocommerce

woocommerce-simple-auctions 2.0.4

WooCommerce Simple Auctions plugin enables you to create professional auction website or Ebay clone with regular, proxy, sealed (silent) and reverse auctions along with your normal products.

https://codecanyon.net/item/woocommerce-simple-auctions-wordpress-auctions/6811382 

* This plugin was previously customized, based on 1.2.40
* Custom functionality is in process of being migrated

### Paypal Woocommerce

paypal-woocommerce 2.5.11

### Paypal Multi Account

paypal-for-woocommerce-multi-account-management 3.1.0

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

### User Switching 

Instant switching between user accounts in WordPress.
Allows admin to switch to another user for support

user-switching 1.5.7

### Elastic press

elasticpress 3.6.2

https://github.com/10up/ElasticPress

Install:

- using wp-cli run: `wp elasticpress index`

Settings: 

/wp-admin/admin.php?page=elasticpress

- server: http://localhost:9200
- autosuggest: 
    - selector: #search_input
    - endpoint: https://siteurl/wp-json/elasticpress/autosuggest (custom)

- Then add a regular search box to the site, it should work

### Others

May not be essential

- safe-svg 1.9.9
- wpdiscuz 7.2.2
- wp-user-avatar custom

## Wp cli

Activate in order:

```
wp plugin activate advanced-custom-fields-pro
wp plugin activate custom-post-type-ui
wp plugin activate bidstitchtools
wp plugin activate ajax-search-for-woocommerce
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

## Custom shortcodes

- Notifications page: [bidstitch_notifications]


