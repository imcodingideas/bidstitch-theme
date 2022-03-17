<?php

/**
 * Theme filters for the event listing and detail pages.
 */

namespace App;

use Roots\Acorn\Sage\ViewFinder;


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
        'relation' => 'OR',
        [
            'key' => 'date_type',
            'compare' => '=',
            'value' => 'text',
        ],
        [
            'key' => 'date',
            'compare' => '>',
            'value' => date('Y-m-d'),
            'type' => 'DATE',
        ],
    ]);
});

// Lose the "Archive:" <title> prefix for event listing
add_filter('the_seo_framework_generated_archive_title', function($title) {
    if (is_post_type_archive('event')) {
        $title = preg_replace('/^Archives: /', '', $title);
    }

    return $title;
});

// Create a separate simple signup page for eventgoers
add_action('init', function() {
    add_rewrite_endpoint('event-registration', EP_ROOT | EP_PAGE);
    add_rewrite_endpoint('event-registration-complete', EP_ROOT | EP_PAGE);
});

add_filter('request', function($query_vars) {
    if (isset($query_vars['event-registration'])) {
        $query_vars['event-registration'] = true;
    } elseif (isset($query_vars['event-registration-complete'])) {
        $query_vars['event-registration-complete'] = true;
    }

    return $query_vars;
});

add_action('template_redirect', function($template) {
    if (get_query_var('event-registration') && is_user_logged_in()) {
        wp_redirect(home_url('/event-registration-complete'));
        exit();
    } elseif (get_query_var('event-registration-complete') && !is_user_logged_in()) {
        wp_redirect(home_url('/event-registration'));
        exit();
    }
});

add_action('template_include', function($template) {
    if (get_query_var('event-registration')) {
        return locate_template('events/event-registration.php');
    } elseif (get_query_var('event-registration-complete')) {
        return locate_template('events/event-registration-complete.php');
    }

    return $template;
});
