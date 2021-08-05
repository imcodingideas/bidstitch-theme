<?php
/*
 * Imported from old theme
 */

// used in: dokan store-header
// todo: cache in a transient
function get_comment_all_store($vendor_id)
{
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
        $comments = $wpdb->get_results($request);
        return $comments;
    } else {
        return [];
    }
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
        $html =
            '<p><i class="fa fa-star"></i>' .
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
// todo: don't fetch all results, query for count
// todo: cache in a transient
function dokan_get_following( $follower_id ) {

	global $wpdb;
	$count_following = 0;

	$following = $wpdb->get_results(
		$wpdb->prepare(
			"select id"
			. " from {$wpdb->prefix}dokan_follow_store_followers"
			. " where follower_id = %d"
			. "     and unfollowed_at is null",
			$follower_id
		),
		OBJECT_K
	);

	if ( !empty( $following ) ) {
		$count_following = count($following);
	}

	return $count_following;
}


// get_followers by seller_id
// todo: don't fetch all results, query for count
// todo: add transient
function dokan_get_followers( $seller_id ) {

	global $wpdb;
	$count_followers = 0;

	$followers = $wpdb->get_results(
		$wpdb->prepare(
			"select id"
			. " from {$wpdb->prefix}dokan_follow_store_followers"
			. " where vendor_id = %d"
			. "     and unfollowed_at is null",
			$seller_id
		),
		OBJECT_K
	);

	if ( !empty( $followers ) ) {
		$count_followers = count($followers);
	}

	return $count_followers;
}
