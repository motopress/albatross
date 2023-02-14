<?php
/**
 * Albatross Theme Customizer
 *
 * @package Albatross
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function albatross_customize_register($wp_customize)
{
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector' => '.site-title a',
				'render_callback' => 'albatross_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector' => '.site-description',
				'render_callback' => 'albatross_customize_partial_blogdescription',
			)
		);
	}

	$wp_customize->add_panel(
		'albatross_theme_settings',
		array(
			'title' => esc_html__('Theme Settings', 'albatross')
		)
	);

	$wp_customize->add_section(
		'albatross_header',
		array(
			'title' => esc_html__('Header', 'albatross'),
			'panel' => 'albatross_theme_settings'
		)
	);

	$wp_customize->add_setting(
		'albatross_header_lottie_enabled',
		array(
			'default' => true,
			'sanitize_callback' => 'albatross_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'albatross_header_lottie_enabled',
		array(
			'label' => __('Enable animation on page headers?', 'albatross'),
			'section' => 'albatross_header',
			'type' => 'checkbox'
		)
	);

	$wp_customize->add_setting( 'albatross_light_logo', array(
		'sanitize_callback' => 'absint'
	) );

	$custom_logo_args = get_theme_support( 'custom-logo' );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'albatross_light_logo', array(
		'label'         => esc_html__( 'Light Logo', 'albatross' ),
		'section'       => 'title_tagline',
		'settings'      => 'albatross_light_logo',
		'priority'      => 9,
		'height'        => $custom_logo_args[0]['height'],
		'width'         => $custom_logo_args[0]['width'],
		'flex_height'   => $custom_logo_args[0]['flex-height'],
		'flex_width'    => $custom_logo_args[0]['flex-width'],
		'button_labels' => array(
			'select' => esc_html__( 'Select Light Logo', 'albatross' ),
		)
	) ) );

	$wp_customize->add_section( 'albatross_front_page_slider', array(
		'title' => esc_html__( 'Front Page Slider', 'albatross' ),
		'panel' => 'albatross_theme_settings'
	) );

	$wp_customize->add_setting( 'albatross_fp_slider_enable_autoplay', array(
		'default'           => false,
		'sanitize_callback' => 'albatross_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'albatross_fp_slider_enable_autoplay', array(
		'label'    => esc_html__( 'Enable slideshow', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'checkbox',
		'settings' => 'albatross_fp_slider_enable_autoplay'
	) );

	$wp_customize->add_setting( 'albatross_fp_slider_autoplay_speed', array(
		'default'           => 2000,
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'albatross_fp_slider_autoplay_speed', array(
		'label'       => esc_html__( 'Slideshow speed', 'albatross' ),
		'section'     => 'albatross_front_page_slider',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 200,
			'max'  => 10000,
			'step' => 200
		)
	) );

	$wp_customize->add_setting( 'albatross_fp_slider_enable_fade', array(
		'default'           => false,
		'sanitize_callback' => 'albatross_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'albatross_fp_slider_enable_fade', array(
		'label'    => esc_html__( 'Use fade animation effect', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'checkbox',
		'settings' => 'albatross_fp_slider_enable_fade'
	) );

	$wp_customize->add_setting( 'albatross_fp_slider_slide_speed', array(
		'default'           => 1000,
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'albatross_fp_slider_slide_speed', array(
		'label'       => esc_html__( 'Animation speed', 'albatross' ),
		'section'     => 'albatross_front_page_slider',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 100,
			'max'  => 5000,
			'step' => 100
		)
	) );

	$wp_customize->add_setting( 'albatross_fp_enable_video', array(
		'default'           => false,
		'type'              => 'theme_mod',
		'sanitize_callback' => 'albatross_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'albatross_fp_enable_video', array(
		'label'    => esc_html__( 'Enable video as a first slide', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'checkbox',
		'settings' => 'albatross_fp_enable_video'
	) );

	$wp_customize->add_setting( 'albatross_fp_video_autoplay', array(
		'default'           => true,
		'type'              => 'theme_mod',
		'sanitize_callback' => 'albatross_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'albatross_fp_video_autoplay', array(
		'label'    => esc_html__( 'Autoplay video', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'checkbox',
		'settings' => 'albatross_fp_video_autoplay'
	) );

	$wp_customize->add_setting( 'albatross_fp_video_muted', array(
		'default'           => true,
		'type'              => 'theme_mod',
		'sanitize_callback' => 'albatross_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'albatross_fp_video_muted', array(
		'label'    => esc_html__( 'Mute video', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'checkbox',
		'settings' => 'albatross_fp_video_muted'
	) );

	$wp_customize->add_setting( 'albatross_fp_video_loop', array(
		'default'           => true,
		'type'              => 'theme_mod',
		'sanitize_callback' => 'albatross_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'albatross_fp_video_loop', array(
		'label'    => esc_html__( 'Loop video', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'checkbox',
		'settings' => 'albatross_fp_video_loop'
	) );

	$wp_customize->add_setting( 'albatross_fp_video', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'albatross_fp_video', array(
		'label'     => esc_html__( 'Video', 'albatross' ),
		'section'   => 'albatross_front_page_slider',
		'mime_type' => 'video',  // Required. Can be image, audio, video, application, text
	) ) );

	$wp_customize->add_setting( 'albatross_fp_video_poster', array(
		'type'              => 'theme_mod',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'albatross_fp_video_poster', array(
		'label'     => esc_html__( 'Video Poster', 'albatross' ),
		'section'   => 'albatross_front_page_slider',
		'mime_type' => 'image',  // Required. Can be image, audio, video, application, text
	) ) );

	$wp_customize->add_setting( 'albatross_fp_video_title', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'wp_kses_post'
	) );

	$wp_customize->add_control( 'albatross_fp_video_title', array(
		'label'    => esc_html__( 'Video Title', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'text',
		'settings' => 'albatross_fp_video_title'
	) );

	$wp_customize->add_setting( 'albatross_fp_video_text', array(
		'default'           => '',
		'transport'         => 'refresh',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'wp_kses_post'
	) );

	$wp_customize->add_control( 'albatross_fp_video_text', array(
		'label'    => esc_html__( 'Video Caption', 'albatross' ),
		'section'  => 'albatross_front_page_slider',
		'type'     => 'textarea',
		'settings' => 'albatross_fp_video_text'
	) );

	$wp_customize->add_section(
		'albatross_blog',
		array(
			'title' => esc_html__('Blog', 'albatross'),
			'panel' => 'albatross_theme_settings'
		)
	);

	$wp_customize->add_setting(
		'albatross_blog_minimalistic',
		array(
			'default' => true,
			'sanitize_callback' => 'albatross_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'albatross_blog_minimalistic',
		array(
			'label' => __('Enable minimalistic blog style?', 'albatross'),
			'section' => 'albatross_blog',
			'type' => 'checkbox'
		)
	);

	$wp_customize->add_section( 'albatross_footer_options', array(
		'title' => esc_html__( 'Footer', 'albatross' ),
		'panel' => 'albatross_theme_settings'
	) );

	$wp_customize->add_setting( 'albatross_show_footer_text', array(
		'default'           => true,
		'transport'         => 'refresh',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'albatross_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'albatross_show_footer_text', array(
			'label'    => esc_html__( 'Show Footer Text?', 'albatross' ),
			'section'  => 'albatross_footer_options',
			'type'     => 'checkbox',
			'settings' => 'albatross_show_footer_text'
		)
	);

	$default_footer_text = _x( '%1$s &copy; %2$s All Rights Reserved.<br/><span style="font-size: .875em;">Designed by <a href="https://motopress.com/" target="_blank" rel="noopener noreferrer nofollow">MotoPress</a>.</span>', 'Default footer text, %1$s - blog name, %2$s - current year', 'albatross' );
	$wp_customize->add_setting( 'albatross_footer_text', array(
		'default'           => $default_footer_text,
		'type'              => 'theme_mod',
		'sanitize_callback' => 'wp_kses_post'
	) );

	$wp_customize->add_control( 'albatross_footer_text', array(
			'label'       => esc_html__( 'Footer Text', 'albatross' ),
			'description' => esc_html__( 'Use %1$s to insert the blog name, %2$s to insert the current year.', 'albatross' ),
			'section'     => 'albatross_footer_options',
			'type'        => 'textarea',
			'settings'    => 'albatross_footer_text'
		)
	);

	$wp_customize->add_setting( 'albatross_accent_color', array(
		'default'           => '#fc9285',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'albatross_accent_color', array(
		'label'   => esc_html__( 'Accent Color', 'albatross' ),
		'section' => 'colors',
		'setting' => 'albatross_accent_color'
	) ) );

	$wp_customize->add_setting( 'albatross_secondary_color', array(
		'default'           => '#455d58',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'albatross_secondary_color', array(
		'label'   => esc_html__( 'Secondary Color', 'albatross' ),
		'section' => 'colors',
		'setting' => 'albatross_secondary_color'
	) ) );

	$wp_customize->add_setting( 'albatross_fp_sidebar_bg', array(
		'default'           => '#334844',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'albatross_fp_sidebar_bg', array(
		'label'   => esc_html__( 'Front Page Widgets Background', 'albatross' ),
		'section' => 'colors',
		'setting' => 'albatross_fp_sidebar_bg'
	) ) );

	$wp_customize->add_setting( 'albatross_fp_sidebar_controls_bg', array(
		'default'           => '#334844',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'albatross_fp_sidebar_controls_bg', array(
		'label'   => esc_html__( 'Front Page Search Availability Controls Background', 'albatross' ),
		'section' => 'colors',
		'setting' => 'albatross_fp_sidebar_controls_bg'
	) ) );

	$wp_customize->add_setting( 'albatross_main_text_color', array(
		'default'           => '#455d58',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'albatross_main_text_color', array(
		'label'   => esc_html__( 'Main Text Color', 'albatross' ),
		'section' => 'colors',
		'setting' => 'albatross_main_text_color'
	) ) );

	$wp_customize->add_setting( 'albatross_heading_text_color', array(
		'default'           => '#455d58',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'albatross_heading_text_color', array(
		'label'   => esc_html__( 'Headings Text Color', 'albatross' ),
		'section' => 'colors',
		'setting' => 'albatross_heading_text_color'
	) ) );

}

add_action('customize_register', 'albatross_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function albatross_customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function albatross_customize_partial_blogdescription()
{
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function albatross_customize_preview_js()
{
	wp_enqueue_script('albatross-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), ALBATROSS_VERSION, true);
}

add_action('customize_preview_init', 'albatross_customize_preview_js');

function albatross_sanitize_checkbox($input)
{
	return filter_var($input, FILTER_VALIDATE_BOOLEAN);
}

function albatross_enqueue_colors_style() {

	$css = '';

	$css .= albatross_generate_accent_color_css();
	$css .= albatross_generate_secondary_color_css();
	$css .= albatross_generate_albatross_fp_sidebar_bg_css();
	$css .= albatross_generate_albatross_fp_sidebar_controls_bg_css();
	$css .= albatross_generate_albatross_text_color_css();
	$css .= albatross_generate_dropdown_menu_bg_color_css();

	if ( $css ) {
		wp_add_inline_style( 'albatross-style', $css );
	}
}

add_action( 'wp_enqueue_scripts', 'albatross_enqueue_colors_style' );

function albatross_generate_accent_color_css() {
	$color = get_theme_mod( 'albatross_accent_color', '#fc9285' );

	if ('#fc9285' == $color) {
		return '';
	}

	$css = <<<CSS
	a, a:hover, a:focus, a:active,
	.albatross-button,
	.an_mailchimp_wrapper form .mpam-submit,
	.social-menu a:hover,
	.main-navigation li:hover > a,
	.main-navigation .current_page_item > a,
	.main-navigation .current-menu-item > a,
	.main-navigation .current_page_ancestor > a,
	.main-navigation .current-menu-ancestor > a,
	.primary-menu-more li.opened > a,
	.primary-menu-more li.focus > a,
	.primary-menu-more li:hover > a,
	.header-menu-container li.opened > a,
	.header-menu-container li.focus > a,
	.header-menu-container li:hover > a,
	.primary-menu-more .current_page_item > a,
	.primary-menu-more .current-menu-item > a,
	.primary-menu-more .current_page_ancestor > a,
	.primary-menu-more .current-menu-ancestor > a,
	.header-menu-container .current_page_item > a,
	.header-menu-container .current-menu-item > a,
	.header-menu-container .current_page_ancestor > a,
	.header-menu-container .current-menu-ancestor > a,
	.post-navigation .nav-links a:hover,
	.navigation.pagination .page-numbers.next:hover,
	.navigation.pagination .page-numbers.prev:hover,
	.footer-widgets a:hover,
	.entry-title a:hover,
	.entry-meta a:hover,
	.byline a:hover,
	.tags-links a:hover,
	.comments-link a:hover,
	.comment-list .comment-metadata a:hover,
	.mphb_sc_room-wrapper .type-mphb_room_type .mphb-view-details-button,
	.mphb_sc_search_results-wrapper .type-mphb_room_type .mphb-view-details-button,
	.mphb_sc_rooms-wrapper .type-mphb_room_type .mphb-view-details-button,
	.mphb_widget_rooms-wrapper .mphb-widget-room-type-title a:hover,
	.mphb_sc_rooms-wrapper.slider .type-mphb_room_type .mphb-to-book-btn-wrapper .mphb-book-button:hover,
	.mphb-single-room-type-attributes li:before,
	.mphb-loop-room-type-attributes li:before,
	.mphb-widget-room-type-attributes li:before,
	.loop-room-short-attributes li:before,
	.mphb-single-room-type-attributes li.mphb-room-type-rating:before,
	.mphb-loop-room-type-attributes li.mphb-room-type-rating:before,
	.mphb-widget-room-type-attributes li.mphb-room-type-rating:before,
	.loop-room-short-attributes li.mphb-room-type-rating:before,
	.mphb-single-room-type-attributes a:hover,
	.mphb-loop-room-type-attributes a:hover,
	.mphb-widget-room-type-attributes a:hover,
	.loop-room-short-attributes a:hover,
	.mphb-regular-price,
	.datepick .datepick-cmd-today:hover,
	.datepick .datepick-ctrl a:hover,
	.mphbr-star-rating > span,
	.mphb-reserve-rooms-details .mphb-room-rate-variant .mphb-price,
	.stratum-advanced-posts.layout-carousel .swiper-container .swiper-slide .stratum-advanced-posts__post-title a:hover,
	.stratum-advanced-posts.layout-carousel .swiper-container .swiper-slide .stratum-advanced-posts__entry-footer .posted-on a:hover
	{
		color: {$color};
	}

	.main-navigation li:hover > .dropdown-toggle
	{
		background-image: linear-gradient({$color}, {$color}), linear-gradient({$color}, {$color});
	}

	.site-header .header-dropdown-toggle.toggled-on
	{
		border: 2px solid {$color};
	}

	.cat-links a:hover
	{
		background: {$color};
		border-color: {$color};
	}

	.front-page-sidebar-wrapper .widget_mphb_search_availability_widget .mphb_widget_search-submit-button-wrapper input:hover,
	.wp-block-button__link:hover,
	.wp-block-button__link:focus,
	.wp-block-button__link:active,
	.wp-block-button__link:visited,
	.datepick .datepick-cmd-next:hover:not(.datepick-disabled),
	.datepick .datepick-cmd-prev:hover:not(.datepick-disabled)
	{
		background: {$color};
	}

	.site-header .header-dropdown-toggle,
	button:hover, .edit-link .post-edit-link:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	.button:hover,
	.stratum-advanced-posts.layout-carousel .swiper-container .swiper-slide .stratum-advanced-posts__read-more a:hover,
	.more-link:hover,
	button:focus,
	.edit-link .post-edit-link:focus,
	input[type="button"]:focus,
	input[type="reset"]:focus,
	input[type="submit"]:focus,
	.button:focus,
	.stratum-advanced-posts.layout-carousel .swiper-container .swiper-slide .stratum-advanced-posts__read-more a:focus,
	.more-link:focus,
	.wp-block-file a.wp-block-file__button:hover, .wp-block-file a.wp-block-file__button:visited,
	.wp-block-file a.wp-block-file__button:focus, .wp-block-file a.wp-block-file__button:active
	{
		background-color: {$color};
	}
CSS;

	return $css;
}

function albatross_generate_secondary_color_css() {
	$color = get_theme_mod( 'albatross_secondary_color', '#455d58' );

	if ('#455d58' == $color) {
		return '';
	}

	$css = <<<CSS
	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	input[type="number"],
	input[type="tel"],
	input[type="range"],
	input[type="date"],
	input[type="month"],
	input[type="week"],
	input[type="time"],
	input[type="datetime"],
	input[type="datetime-local"],
	input[type="color"],
	textarea,
	select,
	body,
	button,
	input,
	select,
	optgroup,
	.main-navigation,
	.primary-menu-more ul ul a,
	.header-menu-container ul ul a,
	.front-page-sidebar-wrapper .widget_mphb_search_availability_widget .mphb_widget_search-submit-button-wrapper input,
	.mphb_sc_room-wrapper .type-mphb_room_type .mphb-view-details-button:hover,
	.mphb_sc_search_results-wrapper .type-mphb_room_type .mphb-view-details-button:hover,
	.mphb_sc_rooms-wrapper .type-mphb_room_type .mphb-view-details-button:hover,
	.datepick .datepick-cmd-next,
	.datepick .datepick-cmd-prev,
	.datepick .datepick-month table td .mphb-out-of-season-date--check-in,
	.datepick .datepick-month table td .mphb-out-of-season-date--check-out,
	.datepick .datepick-month table td .mphb-mark-as-unavailable--check-in,
	.datepick .datepick-month table td .mphb-mark-as-unavailable--check-out
	{
		color: {$color};
	}

	button,
	.edit-link .post-edit-link,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.button,
	.stratum-advanced-posts.layout-carousel .swiper-container .swiper-slide .stratum-advanced-posts__read-more a,
	.more-link,
	.navigation.pagination .page-numbers.current,
	.navigation.pagination .page-numbers:hover,
	.site-footer,
	.front-page-header:after,
	.front-page-header .front-page-slider[data-fade="1"] .slide-image:before,
	.wp-block-file a.wp-block-file__button
	{
		background: {$color};
	}

	.site-header .header-dropdown-toggle:focus,
	.site-header .header-dropdown-toggle:hover,
	.wp-block-button__link
	{
		background-color: {$color};
	}

	.site-header .header-dropdown-toggle.toggled-on:hover,
	.site-header .header-dropdown-toggle.toggled-on:focus
	{
		border-color: {$color};
	}

	.site-footer .scroll-to-top-button:hover svg,
	body.page-has-thumbnail .page-header-wrapper .scroll-to-content-button svg,
	.type-mphb_room_type ul.flex-direction-nav .flex-nav-next a svg,
	.type-mphb_room_type ul.flex-direction-nav .flex-nav-prev a svg
	{
		fill: {$color};
	}

	.datepick .datepick-month table td .mphb-check-in-date,
	.datepick .datepick-month table td .mphb-selected-date,
	.datepick .datepick-month table td .datepick-selected,
	.datepick .datepick-month table td .datepick-highlight
	{
		background: {$color} !important;
	}
CSS;

	return $css;
}

function albatross_generate_albatross_fp_sidebar_bg_css() {
	$color = get_theme_mod( 'albatross_fp_sidebar_bg', '#334844' );

	if ('#334844' == $color) {
		return '';
	}

	$css = <<<CSS
	.front-page-sidebar-wrapper
	{
		background: {$color};
	}

CSS;
	return $css;
}

function albatross_generate_albatross_fp_sidebar_controls_bg_css() {
	$color = get_theme_mod( 'albatross_fp_sidebar_controls_bg', '#2B3F3B' );

	if ('#2B3F3B' == $color) {
		return '';
	}

	$css = <<<CSS
	.front-page-sidebar-wrapper .widget_mphb_search_availability_widget input[type="text"],
	.front-page-sidebar-wrapper .widget_mphb_search_availability_widget select
	{
		background-color: {$color};
	}

CSS;
	return $css;
}

function albatross_generate_albatross_text_color_css() {

	$css = '';
	$color = get_theme_mod( 'albatross_main_text_color', '#455d58' );

	if ('#455d58' != $color) {

		$css .= <<<CSS
			body,
			input,
			select,
			optgroup,
			textarea
			{
				color: {$color};
			}
CSS;
	}

	$color = get_theme_mod( 'albatross_heading_text_color', '#455d58' );

	if ('#455d58' != $color) {

		$css .= <<<CSS
			h1,
			h2,
			h3,
			h4,
			h5,
			h6
			{
				color: {$color};
			}
CSS;
	}

	return $css;
}

function albatross_generate_dropdown_menu_bg_color_css() {
	$color = get_background_color();

	if ('#faf7f2' == $color) {
		return '';
	}

	$css = <<<CSS
	.site-header .header-dropdown-content
	{
		background-color: #{$color};
	}

CSS;
	return $css;
}