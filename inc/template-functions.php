<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Albatross
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function albatross_body_classes($classes)
{
	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (!is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter('body_class', 'albatross_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function albatross_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}

add_action('wp_head', 'albatross_pingback_header');

add_filter('comment_form_default_fields', 'albatross_comment_form_default_fields');
function albatross_comment_form_default_fields($fields)
{
	unset($fields['url']);

	return $fields;
}

add_filter('comment_form_defaults', 'albatross_comment_form_defaults');
function albatross_comment_form_defaults($defaults)
{
	$defaults['submit_button'] = '<button type="submit" id="%2$s" class="%3$s" value="" >
		<svg enable-background="new 0 0 30.99 6.99" viewBox="0 0 30.99 6.99" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
            <rect y="3" width="30" height="1"></rect>
            <polyline points="26.78 0.68 28.18 2.08 29.58 3.48 26.8 6.26 27.53 6.99 30.99 3.53 27.46 0"></polyline>
        </svg>%4$s</button>';

	return $defaults;
}