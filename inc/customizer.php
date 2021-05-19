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

	$default_footer_text = _x( '%1$s &copy; %2$s All Rights Reserved.<br> <span style="font-size: .875em;">Powered by <a href="https://motopress.com/products/albatross/" rel="nofollow">Albatross</a> WordPress theme.</span>', 'Default footer text, %1$s - blog name, %2$s - current year', 'albatross' );
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
