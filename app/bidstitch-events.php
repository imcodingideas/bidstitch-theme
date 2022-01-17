<?php

/**
 * Theme filters for the event listing and detail pages.
 */

namespace App;

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
function bidstitch_event_conditional_username($form)
{
    if (get_post_type() == 'event') {
        foreach ($form['fields'] as $key => $field) {
            if ($field->inputName === 'desired_username' && is_user_logged_in()) {
                unset($form['fields'][$key]);
                break;
            }
        }
    }

    return $form;
}
add_filter('gform_pre_render', 'App\\bidstitch_event_conditional_username');
add_filter('gform_pre_validation', 'App\\bidstitch_event_conditional_username');

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

// Lose the "Archive:" <title> prefix for event listing
add_filter('the_seo_framework_generated_archive_title', function($title) {
    if (is_post_type_archive('event')) {
        $title = preg_replace('/^Archives: /', '', $title);
    }

    return $title;
});
