<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

// add query filters to post listing page
add_filter('pre_get_posts', function($q) {
    if (is_admin() || !$q->is_main_query()) return $q;

    if (is_home() && !dokan_is_store_page()) {
        // show only posts
        $q->set('post_type', 'post');

        // set default ordering by date
        if (!isset($_GET['orderby'])) {
            $q->set('orderby', 'date');
            $q->set('order', 'DESC');
        }

        // hide specific categories from post listing page
        $excluded_categories = [
            'dealer-spotlight',
        ];

        $tax_query = $q->get('tax_query');
        if (!is_array($tax_query)) $tax_query = [];

        $tax_query[] = [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $excluded_categories,
            'operator' => 'NOT IN',
        ];

        $q->set('tax_query', $tax_query);
    }

    return $q;
}, 11, 1);

// decrease excerpt length
add_filter('excerpt_length', function($length) {
    if (is_admin()) return $length;

    return 32;
});

// Populate "Registration Form" select on events with GFs
add_filter('acf/load_field/name=registration_form', function($field) {
    if (class_exists('GFFormsModel')) {
		$choices = [];

		foreach (\GFFormsModel::get_forms() as $form) {
			$choices[$form->id] = $form->title;
		}

		$field['choices'] = $choices;
	}

    return $field;
});

// Front-end event GFs get conditional field based on login
add_filter('gform_pre_render', function($form) {
    foreach ($form['fields'] as $key => $field) {
        if ($field->inputName === 'desired_username' && is_user_logged_in()) {
            unset($form['fields'][$key]);
            break;
        }
    }

    return $form;
});

// Filter events archive query to only show future events
add_filter('pre_get_posts', function($query) {
    if (is_admin() || $query->get('post_type') !== 'event') {
        return;
    }

    $query->set('meta_query', [
        'relation' => 'AND',
        [
            'key' => 'date',
            'compare' => '>',
            'value' => date('Y-m-d'),
            'type' => 'DATETIME',
        ],
    ]);
    $query->set('order', 'ASC');
    $query->set('orderby', 'meta_value');
    $query->set('meta_key', 'date');
    $query->set('meta_type', 'DATETIME');
});

add_filter('the_seo_framework_generated_archive_title', function($title) {
    if (is_post_type_archive('event')) {
        $title = preg_replace('/^Archives: /', '', $title);
    }

    return $title;
});
