Migrate production to local
------------------------

Use these steps to migrate

REMOTE_IP=
REMOTE_SYS_USER=
REMOTE_APP_PATH=
REMOTE_DB_NAME=
REMOTE_DB_USER=
REMOTE_DB_PASSWORD=
LOCAL_DIR=
TODAY_DATE=2021-09-10 # example

# go to dir

cd $LOCAL_DIR

# locally backup using wp-cli

wp db export ${TODAY_DATE}-backup-prod-to-local.sql

# remote backup 
ssh $REMOTE_SYS_USER@$REMOTE_IP "cd /home/bidstitch/webapps/bidstitch/public && rm prod-db.sql.gz"
ssh $REMOTE_SYS_USER@$REMOTE_IP "cd /home/bidstitch/webapps/bidstitch/public && wp db export ../prod-db.sql && cd .. && gzip prod-db.sql"

# fetch db
rsync -avz $REMOTE_SYS_USER@$REMOTE_IP:/home/bidstitch/webapps/bidstitch/prod-db.sql.gz ./
gunzip prod-db.sql.gz

# import db
wp db import prod-db.sql
wp search-replace '//bidstitch.com'  '//bidstitch.com'
wp search-replace '\/\/bidstitch.com'  '\/\/bidstitch.com'


Configure
---------

# theme

wp theme activate bidstitch

deactivate some plugins:
------------------------


all-in-one-wp-migration \
classic-editor \
get-url-cron \
import-users-from-csv-with-meta \
jetpack \
perfect-woocommerce-brands \
query-monitor \
redirection \
safe-svg \
show-hooks \
w3-total-cache \
woocommerce-conversion-tracking \
wp plugin deactivate \
wp-emoji-one \
wp-favorite-posts \
wp-file-manager \
wp-user-frontend \
wp-user-frontend \
wp-user-frontend-pro \
wp-user-frontend-pro 


Activate plugins
----------------

wp plugin activate advanced-custom-fields-pro
wp plugin activate custom-post-type-ui
wp plugin activate bidstitchtools
wp plugin activate woocommerce
wp plugin activate dokan-lite
wp plugin activate dokan-pro
wp plugin activate offers-for-woocommerce
wp plugin activate offers-for-woocommerce-dokan
wp plugin activate woocommerce-simple-auctions
wp plugin activate paypal-woocommerce
wp plugin activate paypal-for-woocommerce-multi-account-management
wp plugin activate elasticpress


Fix navigation menus
--------------------

Remove "<span class" from items

https://bidstitch.com/wp-admin/nav-menus.php


Create Header navigation right
-----------------------

wp menu create header-nav-right

wp menu item add-custom header-nav-right 'Bid' 'https://bidstitch.com/shop/?swoof=1&orderby=date&buying_formats=1'
wp menu item add-custom header-nav-right 'Buy' 'https://bidstitch.com/shop/?swoof=1&orderby=date&buying_formats=2'
wp menu item add-custom header-nav-right 'Sell' '#'
    wp menu item add-custom header-nav-right 'Add Buy It Now Listing' 'https://bidstitch.com/dashboard/new-product/'
    wp menu item add-custom header-nav-right 'Add Auction Listing' 'https://bidstitch.com/dashboard/new-auction-product/'

manually set hierarchy

Mark "header navigation"


Add my account navigation
-------------------------

wp menu create my-account

wp menu item add-custom my-account 'My Profile' '#'
    wp menu item add-custom my-account 'My purchases' 'https://bidstitch.com/my-account/orders/'
    wp menu item add-custom my-account 'Profile settings' 'https://bidstitch.com/my-account/edit-account/'
    wp menu item add-custom my-account 'My Profile' 'https://bidstitch.com/my-account/edit-account/'
    wp menu item add-custom my-account 'Cart' 'https://bidstitch.com/cart'
wp menu item add-custom my-account 'My Store' '#'
    wp menu item add-custom my-account 'My sold listings' 'https://bidstitch.com/dashboard/orders/'
    wp menu item add-custom my-account 'My Buy It Now Listings' 'https://bidstitch.com/dashboard/products/'
    wp menu item add-custom my-account 'Subscription' 'https://bidstitch.com/dashboard/subscription/'
    wp menu item add-custom my-account 'Store Settings' 'https://bidstitch.com/dashboard/settings/store/'
    wp menu item add-custom my-account 'View my store' 'https://bidstitch.com/stores'
wp menu item add-custom my-account 'Logout' 'https://bidstitch.com/my-account/customer-logout/?_wpnonce=ef9eb7f97d'

manually set hierarchy
set as my account navigation

Add categories images
---------------------

https://bidstitch.com/wp-admin/edit-tags.php?taxonomy=product_cat&post_type=product

Add elastic search widget
-----------------

Add widget: 'Elasticpress custom search widget'

Check search works


Set page templates
------------------

as "dashboard"

https://bidstitch.com/dashboard/
https://bidstitch.com/my-account/edit-account/



