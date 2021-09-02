<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class StoreHeader extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.store-header'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $store_user = dokan()->vendor->get(get_query_var('author'));
        $store_info = $store_user->get_shop_info();
        $social_info = $store_user->get_social_profiles();
        $store_tabs = dokan_get_store_tabs($store_user->get_id());
        $social_fields = dokan_get_social_profile_fields();

        $dokan_appearance = get_option('dokan_appearance');
        $profile_layout = empty($dokan_appearance['store_header_template'])
            ? 'default'
            : $dokan_appearance['store_header_template'];
        $store_address = dokan_get_seller_short_address(
            $store_user->get_id(),
            false
        );

        $dokan_store_time_enabled = isset(
            $store_info['dokan_store_time_enabled']
        )
            ? $store_info['dokan_store_time_enabled']
            : '';
        $store_open_notice =
            isset($store_info['dokan_store_open_notice']) &&
            !empty($store_info['dokan_store_open_notice'])
                ? $store_info['dokan_store_open_notice']
                : __('Store Open', 'dokan-lite');
        $store_closed_notice =
            isset($store_info['dokan_store_close_notice']) &&
            !empty($store_info['dokan_store_close_notice'])
                ? $store_info['dokan_store_close_notice']
                : __('Store Closed', 'dokan-lite');
        $show_store_open_close = dokan_get_option(
            'store_open_close',
            'dokan_appearance',
            'on'
        );

        $general_settings = get_option('dokan_general', []);
        $banner_width = dokan_get_option(
            'store_banner_width',
            'dokan_appearance',
            625
        );

        if ('default' === $profile_layout || 'layout2' === $profile_layout) {
            $profile_img_class = 'profile-img-circle';
        } else {
            $profile_img_class = 'profile-img-square';
        }

        if ('layout3' === $profile_layout) {
            unset($store_info['banner']);

            $no_banner_class = ' profile-frame-no-banner';
            $no_banner_class_tabs = ' dokan-store-tabs-no-banner';
        } else {
            $no_banner_class = '';
            $no_banner_class_tabs = '';
        }

        $rating = $store_user->get_rating($store_user->id);
        $rating_count = $rating['count'];

        //pho
        $all_comments = get_comment_all_store($store_user->id);
        if (empty($all_comments)) {
            $all_comments = [];
        }

        //pho
        $dokan_store_des = isset($store_info['vendor_biography'])
            ? $store_info['vendor_biography']
            : '';
        $store_instagramhandle = isset($store_info['instagramhandle'])
            ? $store_info['instagramhandle']
            : '';
        $store_how_for = isset($store_info['how_for'])
            ? $store_info['how_for']
            : '';
        $store_specialize = isset($store_info['specialize'])
            ? $store_info['specialize']
            : '';
        $store_get_into = isset($store_info['get_into'])
            ? $store_info['get_into']
            : '';

        $vendor_id = $store_user->get_id();
        $igverified = get_field('ig_verified', 'user_' . $vendor_id);
        $founder = get_field('founder_member', 'user_' . $vendor_id);
        $vendor = new \WP_User($vendor_id);
        $vendor_name = $vendor->display_name;
        $address = $store_info['address'];
        $countryname = '';
        $countrycode = $address['country'] ?? false;
        if ($countrycode) {
            $countryname =
                WC()->countries->countries[$countrycode] ?? $countrycode;
        }

        $vendor_profile_link = get_field('user_profile', 'option');
        $vendor_profile_link = !empty($vendor_profile_link)
            ? $vendor_profile_link . '?id=' . $vendor_id
            : '#';
        $store_user_id = $store_user->get_id();

        // store url
        global $wp;
        $dokan_get_store_url = dokan_get_store_url($store_user_id);
        $dokan_get_review_url = dokan_get_review_url($store_user_id);
        $dokan_get_store_url_class = $this->is_same_url(
            $wp->request,
            $dokan_get_store_url
        )
            ? 'active'
            : '';
        $dokan_get_review_url_class = $this->is_same_url(
            $wp->request,
            $dokan_get_review_url
        )
            ? 'active'
            : '';

        return [
            'all_comments' => $all_comments,
            'avatar' => $store_user->get_avatar(),
            'banner' => $store_user->get_banner(),
            'countryname' => $countryname,
            'dokan_store_des' => $dokan_store_des,
            'founder' => $founder,
            'igverified' => $igverified,
            'no_banner_class' => $no_banner_class,
            'no_banner_class_tabs' => $no_banner_class_tabs,
            'profile_img_class' => $profile_img_class,
            'profile_layout' => $profile_layout,
            'review_url' => $store_user->get_review_url($store_user_id),
            'shop_name' => $store_user->get_shop_name(),
            'store_rating' => dokan_get_store_rating($store_user_id),
            'store_url' => $store_user->get_store_url($store_user_id),
            'store_user_id' => $store_user_id,
            'vendor_id' => $vendor_id,
            'vendor_name' => $vendor_name,
            'vendor_profile_link' => $vendor_profile_link,
            'args_btn_follow' => $this->args_btn_follow($vendor_id),

            'dokan_get_store_url' => $dokan_get_store_url,
            'dokan_get_review_url' => $dokan_get_review_url,
            'dokan_get_store_url_class' => $dokan_get_store_url_class,
            'dokan_get_review_url_class' => $dokan_get_review_url_class,
        ];
    }
    function args_btn_follow($vendor_id)
    {
        $args_btn_follow = [];
        if (is_user_logged_in()) {
            $customer_id = get_current_user_id();
            $status = null;

            $btn_labels = dokan_follow_store_button_labels();

            if (
                dokan_follow_store_is_following_store($vendor_id, $customer_id)
            ) {
                $label_current = $btn_labels['following'];
                $status = 'following';
            } else {
                $label_current = $btn_labels['follow'];
            }

            $args_btn_follow = [
                'label_current' => $label_current,
                'label_unfollow' => $btn_labels['unfollow'],
                'vendor_id' => $vendor_id,
                'status' => $status,
                'button_classes' =>
                    'btn btn--white px-8 py-2 uppercase dokan-follow-store-button vender_action_btn',
                'is_logged_in' => $customer_id,
            ];
        }
        return $args_btn_follow;
    }
    function is_same_url($url1, $url2)
    {
        $url1 = home_url(wp_make_link_relative($url1));
        $url1 = preg_replace('/\/$/i', '', $url1);

        $url2 = home_url(wp_make_link_relative($url2));
        $url2 = preg_replace('/\/$/i', '', $url2);

        return $url1 == $url2;
    }
}
