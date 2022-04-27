<?php

/*ACF Options Page*/
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Page Settings',
        'menu_title' => 'Page Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
    ]);
    acf_add_options_sub_page([
        'page_title' => 'Homepage Settings',
        'menu_title' => 'Homepage Settings',
        'parent_slug' => 'theme-general-settings',
    ]);
    acf_add_options_sub_page([
        'page_title' => 'Page Shop Setting',
        'menu_title' => 'Shop Setting',
        'parent_slug' => 'theme-general-settings',
    ]);
    acf_add_options_sub_page([
        'page_title' => 'Theme Footer Settings',
        'menu_title' => 'Footer',
        'parent_slug' => 'theme-general-settings',
    ]);
}
