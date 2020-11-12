<?php
/**
 * Albatross functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Albatross
 */

if (!defined('ALBATROSS_VERSION')) {
	// Replace the version number of the theme on each release.
	define('ALBATROSS_VERSION', albatross_get_version());
}

if (!function_exists('albatross_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function albatross_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Albatross, use a find and replace
		 * to change 'albatross' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('albatross', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		set_post_thumbnail_size(1620, 9999);
		add_image_size('albatross-large', 920, 650, true);
		add_image_size('albatross-small', 500, 300);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Header Flat', 'albatross'),
				'menu-2' => esc_html__('Header Socials', 'albatross'),
				'menu-3' => esc_html__('Primary', 'albatross'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'albatross_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height' => 250,
				'width' => 250,
				'flex-width' => true,
				'flex-height' => true,
			)
		);

		add_post_type_support('page', 'excerpt');

		add_theme_support('responsive-embeds');
		add_theme_support('align-wide');
		add_theme_support('editor-styles');
		add_editor_style(array(albatross_fonts_url(), 'editor-style.css'));

		add_theme_support('editor-color-palette', array(
			array(
				'name' => esc_html__('Color 1', 'albatross'),
				'slug' => 'color-1',
				'color' => '#fc9285',
			),
			array(
				'name' => esc_html__('Color 2', 'albatross'),
				'slug' => 'color-2',
				'color' => '#455d58',
			),
			array(
				'name' => esc_html__('Color 3', 'albatross'),
				'slug' => 'color-3',
				'color' => '#dadfde',
			),
			array(
				'name' => esc_html__('Color 4', 'albatross'),
				'slug' => 'color-4',
				'color' => '#faf7f2',
			)
		));
	}
endif;
add_action('after_setup_theme', 'albatross_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function albatross_content_width()
{
	$GLOBALS['content_width'] = apply_filters('albatross_content_width', 780);
}

add_action('after_setup_theme', 'albatross_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function albatross_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Header 1', 'albatross'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h5 class="widget-title">',
			'after_title' => '</h5>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Header 2', 'albatross'),
			'id' => 'sidebar-2',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h5 class="widget-title">',
			'after_title' => '</h5>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Header 3', 'albatross'),
			'id' => 'sidebar-3',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h5 class="widget-title">',
			'after_title' => '</h5>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Footer 1', 'albatross'),
			'id' => 'sidebar-4',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Footer 2', 'albatross'),
			'id' => 'sidebar-5',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Footer 3', 'albatross'),
			'id' => 'sidebar-6',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Footer 4', 'albatross'),
			'id' => 'sidebar-7',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Pages', 'albatross'),
			'id' => 'sidebar-8',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => esc_html__('Front Page Header', 'albatross'),
			'id' => 'sidebar-9',
			'description' => esc_html__('Add widgets here.', 'albatross'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
}

add_action('widgets_init', 'albatross_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function albatross_scripts()
{
	wp_enqueue_style('fontawesome-free', 'https://use.fontawesome.com/releases/v5.10.0/css/all.css', [], '5.10.0');

	wp_enqueue_style('albatross-fonts', albatross_fonts_url(), array(), ALBATROSS_VERSION);

	wp_enqueue_style('albatross-style', get_stylesheet_uri(), array(), ALBATROSS_VERSION);
	wp_style_add_data('albatross-style', 'rtl', 'replace');

	if (get_theme_mod('albatross_header_lottie_enabled', true)) {
		wp_enqueue_script('lottie-player', 'https://unpkg.com/@lottiefiles/lottie-player@0.5.1/dist/lottie-player.js', array('jquery'), '0.5.1', true);
	}

	wp_enqueue_style('slick', get_template_directory_uri() . '/assets/slick/slick.css', array(), '1.8.1');
	wp_enqueue_script('slick', get_template_directory_uri() . '/assets/slick/slick.js', array('jquery'), '1.8.1', true);

	wp_enqueue_script('albatross-functions', get_template_directory_uri() . '/js/functions.js', array('slick', 'jquery'), ALBATROSS_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'albatross_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * tgm init
 */
require get_template_directory() . '/inc/tgmpa-init.php';

/**
 * demo-import
 */
require get_template_directory() . '/inc/demo-import.php';

/**
 * MotoPress Hotel Booking functions
 */
if ( class_exists( 'HotelBookingPlugin' ) ) {
	require get_template_directory() . '/inc/mphb-functions.php';
}

function albatross_fonts_url()
{
	$url = 'https://fonts.googleapis.com/css2?';
	$fonts = [];

	$font1 = esc_html_x('on', 'Amiri font: on or off', 'albatross');
	if ('off' !== $font1) {
		$fonts[] = 'family=Amiri:ital,wght@0,400;0,700;1,400;1,700';
	}

	$font2 = esc_html_x('on', 'Montserrat font: on or off', 'albatross');
	if ('off' !== $font2) {
		$fonts[] = 'family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700';
	}

	if (!$fonts) {
		return null;
	}

	$url .= implode('&amp;', $fonts);
	$url .= '&amp;display=swap';

	return esc_url_raw($url);
}

function albatross_get_version()
{
	$theme_info = wp_get_theme(get_template());

	return $theme_info->get('Version');
}
