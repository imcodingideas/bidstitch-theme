<?php
/*
 * Imported from old theme
 */

// used in: dokan store-header
// todo: cache duration as parameter
function get_comment_all_store($vendor_id)
{
    $bidstitch_post_comments = [];
    if (
        false ===
        ($bidstitch_post_comments = get_transient(
            "bidstitch_post_comments_$vendor_id"
        ))
    ) {
        global $wpdb;
        $array_post = [];
        $products = $wpdb->get_results(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product' AND post_author = $vendor_id AND post_status = 'publish' "
        );
        if (!empty($products)) {
            foreach ($products as $product_val) {
                $array_post[] = $product_val->ID;
            }
            $string_post = implode(',', $array_post);
            $request = "SELECT * FROM $wpdb->comments";
            $request .= " JOIN $wpdb->posts ON ID = comment_post_ID";
            $request .=
                " WHERE comment_approved = '1' AND post_status = 'publish' AND post_password =''";
            $request .= " AND comment_post_ID IN ($string_post)";
            $request .= ' ORDER BY comment_date DESC ';
            $bidstitch_post_comments = $wpdb->get_results($request);
        }
        /* MINUTE_IN_SECONDS  = 60 (seconds) */
        /* HOUR_IN_SECONDS    = 60 * MINUTE_IN_SECONDS */
        /* DAY_IN_SECONDS     = 24 * HOUR_IN_SECONDS */
        /* WEEK_IN_SECONDS    = 7 * DAY_IN_SECONDS */
        /* MONTH_IN_SECONDS   = 30 * DAY_IN_SECONDS */
        /* YEAR_IN_SECONDS    = 365 * DAY_IN_SECONDS */
        set_transient(
            "bidstitch_post_comments_$vendor_id",
            $bidstitch_post_comments,
            MINUTE_IN_SECONDS
        );
    }
    return $bidstitch_post_comments;
}

// used in: dokan store-header
function dokan_get_store_rating($seller_id)
{
    $vendor = dokan()->vendor->get($seller_id);
    $display = true;
    $count = 0;
    $count_ratting = 0;
    $all_comments = get_comment_all_store($vendor->id);
    if (!empty($all_comments)) {
        $count = count($all_comments);
        foreach ($all_comments as $review) {
            $rating_cm = get_comment_meta($review->comment_ID, 'rating', true);
            if (!empty($rating_cm)) {
                $count_ratting = $count_ratting + $rating_cm;
            }
        }
    }
    $rating_medium = 0;
    if ($count) {
        $rating_medium = $count_ratting / $count;
    }

    $rating = $vendor->get_rating($vendor->id);
    if (empty($all_comments)) {
        $star = get_template_directory_uri().'/public/images/star-solid.svg';
        $html = 
            '<p class="flex items-center">' .
            "<img src='$star' class='w-4 mr-2 inline-block'>".
            __(' No ratings found yet!', 'dokan-lite') .
            '</p>';
    } else {
        $text = sprintf(
            __('Rated %s out of %d', 'dokan-lite'),
            $rating['rating'],
            number_format(5)
        );
        $width = ($rating_medium / 5) * 100;
        if (function_exists('dokan_get_review_url')) {
            $review_text = sprintf(
                '<a href="%s">%d Reviews</a>',
                esc_url(dokan_get_review_url($vendor->id)),
                $count
            );
        }
        $html =
            '<span class="seller-rating">
		<span title=" ' .
            esc_attr($text) .
            '" class="star-rating" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
		<span class="width" style="width: ' .
            $width .
            '%"></span>
		</span>
		</span>
		<span class="text">' .
            $review_text .
            '</span>';
    }
    return $html;
}

// used in vendor info
// todo: cache duration as parameter
function dokan_get_following($follower_id)
{
    $bidstitch_vendor_following = 0;
    if (
        false ===
        ($bidstitch_vendor_following = get_transient(
            "bidstitch_vendor_following_$follower_id"
        ))
    ) {
        global $wpdb;

        $bidstitch_vendor_following = $wpdb->get_var(
            $wpdb->prepare(
                "select count(*) from {$wpdb->prefix}dokan_follow_store_followers where follower_id = %d and unfollowed_at is null",
                $follower_id
            )
        );

        /* MINUTE_IN_SECONDS  = 60 (seconds) */
        /* HOUR_IN_SECONDS    = 60 * MINUTE_IN_SECONDS */
        /* DAY_IN_SECONDS     = 24 * HOUR_IN_SECONDS */
        /* WEEK_IN_SECONDS    = 7 * DAY_IN_SECONDS */
        /* MONTH_IN_SECONDS   = 30 * DAY_IN_SECONDS */
        /* YEAR_IN_SECONDS    = 365 * DAY_IN_SECONDS */
        set_transient(
            'bidstitch_vendor_following_$follower_id',
            $bidstitch_vendor_following,
            MINUTE_IN_SECONDS
        );
    }
    return $bidstitch_vendor_following;
}

// get_followers by seller_id
// todo: cache duration as parameter
function dokan_get_followers($seller_id)
{
    $bidstitch_count_followers = 0;
    if (
        false ===
        ($bidstitch_count_followers = get_transient(
            "bidstitch_count_followers_$seller_id"
        ))
    ) {
        global $wpdb;
        $count_followers = 0;
        $bidstitch_count_followers = $wpdb->get_var(
            $wpdb->prepare(
                "select count(*) from {$wpdb->prefix}dokan_follow_store_followers  where vendor_id = %d and unfollowed_at is null",
                $seller_id
            )
        );
        /* MINUTE_IN_SECONDS  = 60 (seconds) */
        /* HOUR_IN_SECONDS    = 60 * MINUTE_IN_SECONDS */
        /* DAY_IN_SECONDS     = 24 * HOUR_IN_SECONDS */
        /* WEEK_IN_SECONDS    = 7 * DAY_IN_SECONDS */
        /* MONTH_IN_SECONDS   = 30 * DAY_IN_SECONDS */
        /* YEAR_IN_SECONDS    = 365 * DAY_IN_SECONDS */
        set_transient(
            "bidstitch_count_followers_$seller_id",
            $bidstitch_count_followers,
            MINUTE_IN_SECONDS
        );
    }

    return $bidstitch_count_followers;
}
