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

	if (is_page() && has_post_thumbnail()) {
		$classes[] = 'page-has-thumbnail';
	}

	if (is_home()) {
		if (get_theme_mod('albatross_blog_minimalistic', true)) {
			$classes[] = 'blog-minimalistic';
		}
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

function albatross_posts_pagination()
{
	$svg = '<svg width="26" height="16" viewBox="0 0 26 16" xmlns="http://www.w3.org/2000/svg">
			<path d="M25.7071 7.29289C26.0976 7.68342 26.0976 8.31658 25.7071 8.70711L19.3431 15.0711C18.9526 15.4616 18.3195 15.4616 17.9289 15.0711C17.5384 14.6805 17.5384 14.0474 17.9289 13.6569L23.5858 8L17.9289 2.34315C17.5384 1.95262 17.5384 1.31946 17.9289 0.928932C18.3195 0.538408 18.9526 0.538408 19.3431 0.928932L25.7071 7.29289ZM25 9H0V7H25V9Z"/>
			</svg>';

	the_posts_pagination(array(
		'mid_size' => 1,
		'prev_text' => $svg . esc_html__('Previous', 'albatross'),
		'next_text' => esc_attr__('Next', 'albatross') . $svg
	));
}

function albatross_read_more_wrapper($link)
{
	$link = '<div>' . $link . '</div>';
	return $link;
}

add_filter('the_content_more_link', 'albatross_read_more_wrapper');

function albatross_filter_logo($html, $blog_id)
{

	$page_with_thumbnail = is_page() && has_post_thumbnail();
	$ftp_with_header = is_front_page() && !is_home() && (count(get_pages(array('child_of' => get_the_ID()))) || albatross_fp_video_enabled());

	if ($page_with_thumbnail || $ftp_with_header) {
		$light_logo = get_theme_mod('albatross_light_logo', false);

		if ($light_logo) {
			ob_start();
			?>
            <a class="custom-logo-link light" href="<?php echo esc_url(home_url('/')) ?>">
                <img class="custom-logo"
                     src="<?php echo esc_url(wp_get_attachment_image_src(absint(get_theme_mod('albatross_light_logo')))[0]); ?>"
                     alt="<?php echo esc_html(get_bloginfo('name', 'display')); ?>">
            </a>
			<?php
			$html .= ob_get_clean();
		}
	}

	return $html;
}

add_filter('get_custom_logo', 'albatross_filter_logo', 10, 2);

function albatross_page_header()
{
	if (is_page_template('template-front-page.php')) {
		albatross_front_page_header();
	} elseif (is_page_template('template-page-sidebar.php')) {
		return;
	} else {
		albatross_default_page_header();
	}
}

function albatross_simple_page_header()
{
	?>
    <header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>

		<?php if (has_excerpt()) the_excerpt(); ?>

		<?php the_post_thumbnail(); ?>

    </header><!-- .entry-header -->
	<?php
}

function albatross_default_page_header()
{
	$thumb_url = get_the_post_thumbnail_url();
	?>
    <div class="page-header-wrapper"
		<?php if ($thumb_url): ?>
            style="background-image: url('<?php echo esc_url($thumb_url); ?>')"
		<?php endif; ?>
    >
		<?php
		if ($thumb_url && get_theme_mod('albatross_header_lottie_enabled', true)):
			?>
            <lottie-player
                    src="<?php echo esc_url(get_theme_file_uri('assets/animations/blob-effect.json')); ?>"
                    background="transparent" speed="1" loop autoplay class="page-header-animation"></lottie-player>
		<?php
		endif;
		?>
		<?php albatross_post_thumbnail(); ?>

        <header class="entry-header">
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>

			<?php if (has_excerpt()) the_excerpt(); ?>

			<?php
			if ($thumb_url):
				?>
                <a href="#page-content" class="scroll-to-content-button">
                    <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.23396 17.7609C7.84344 18.1515 7.21027 18.1515 6.81975 17.7609L0.455787 11.397C0.0652625
                    11.0065 0.0652624 10.3733 0.455787 9.98277C0.846311 9.59224 1.47948 9.59224 1.87 9.98277L7.52686
                    15.6396L13.1837 9.98276C13.5742 9.59224 14.2074 9.59224 14.5979 9.98276C14.9884 10.3733 14.9884
                    11.0065 14.5979 11.397L8.23396 17.7609ZM6.52686 17.0538L6.52685 0.0538331L8.52685 0.0538329L8.52686
                    17.0538L6.52686 17.0538Z"/>
                    </svg>
                </a>
			<?php
			endif;
			?>
        </header><!-- .entry-header -->
    </div>
	<?php
}

function albatross_front_page_header()
{
	$query = new WP_Query(array(
		'post_type' => 'page',
		'posts_per_page' => 20,
		'post_parent' => get_the_ID(),
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_status' => 'publish'
	));

	$first_slide = albatross_fp_video_enabled();

	if (!$query->have_posts() && !$first_slide) {
		albatross_default_page_header();
		return;
	}
	?>
    <div class="front-page-header"
		<?php
		if (has_header_image()):
			?>
            style="background-image: url('<?php header_image(); ?>')"
		<?php
		endif;
		?>
    >
        <div class="front-page-header-wrapper">
			<?php
			if (get_theme_mod('albatross_header_lottie_enabled', true)):
				?>
                <div class="fp-header-animation-wrapper">
                    <lottie-player
                            src="<?php echo esc_url(get_theme_file_uri('assets/animations/blob-effect.json')); ?>"
                            background="transparent" speed="1" loop autoplay
                            class="fp-header-animation"></lottie-player>
                </div>
			<?php
			endif;

			$slider_fade = intval(get_theme_mod('albatross_fp_slider_enable_fade', false));
			$slider_autoplay = intval(get_theme_mod('albatross_fp_slider_enable_autoplay', false));
			$slider_autoplay_speed = get_theme_mod('albatross_fp_slider_autoplay_speed', 2000);
			$slider_speed = get_theme_mod('albatross_fp_slider_slide_speed', 2000);
			?>

            <div class="front-page-slider-wrapper">
                <div class="front-page-slider slick-slider" id="front-page-slider"
                     data-fade="<?php echo esc_attr($slider_fade); ?>"
                     data-autoplay="<?php echo esc_attr($slider_autoplay); ?>"
                     data-autoplaySpeed="<?php echo esc_attr($slider_autoplay_speed); ?>"
                     data-speed="<?php echo esc_attr($slider_speed); ?>"
                >
					<?php
					if ($first_slide) {
						albatross_front_page_slider_video();
					}
					while ($query->have_posts()):
						$query->the_post();
						?>
                        <div class="front-page-slider-slide slick-slide">
                            <div class="front-page-slider-slide-wrapper">
                                <div class="slide-header">
                                    <div class="description"><?php the_excerpt(); ?></div>
                                    <h2 class="title"><?php the_title(); ?></h2>
                                    <div class="slider-controls">
                                        <button class="fp-slider-prev">
                                            <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.5"
                                                      d="M0.292893 7.29289C-0.0976311 7.68342 -0.0976311 8.31658 0.292893
                                                  8.70711L6.65685 15.0711C7.04738 15.4616 7.68054 15.4616 8.07107
                                                  15.0711C8.46159 14.6805 8.46159 14.0474 8.07107 13.6569L2.41421
                                                  8L8.07107 2.34315C8.46159 1.95262 8.46159 1.31946 8.07107
                                                  0.928932C7.68054 0.538408 7.04738 0.538408 6.65685
                                                  0.928932L0.292893 7.29289ZM1 9H26V7H1V9Z"/>
                                            </svg>
                                        </button>
                                        <button class="fp-slider-next">
                                            <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.5"
                                                      d="M25.7071 7.29289C26.0976 7.68342 26.0976 8.31658 25.7071
                                                  8.70711L19.3431 15.0711C18.9526 15.4616 18.3195 15.4616 17.9289
                                                  15.0711C17.5384 14.6805 17.5384 14.0474 17.9289 13.6569L23.5858
                                                  8L17.9289 2.34315C17.5384 1.95262 17.5384 1.31946 17.9289
                                                  0.928932C18.3195 0.538408 18.9526 0.538408 19.3431
                                                  0.928932L25.7071 7.29289ZM25 9H0V7H25V9Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
								<?php
								if (has_post_thumbnail()):
									?>
                                    <div class="slide-image">
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID())); ?>"
                                             alt="">
                                    </div>
								<?php
								endif;
								?>
                            </div>
                        </div>
					<?php
					endwhile;
					?>
                </div>
            </div>

			<?php
			if (is_active_sidebar('sidebar-9')):
				?>
                <div class="front-page-sidebar-wrapper">
                    <div class="front-page-sidebar">
						<?php dynamic_sidebar('sidebar-9'); ?>
                    </div>
                </div>
			<?php
			endif;
			?>
        </div>
    </div>
	<?php
	wp_reset_postdata();
}

function albatross_front_page_slider_video()
{
	$video_id = get_theme_mod('albatross_fp_video', false);

	$video_atts = [
		'autoplay',
		'muted',
		'loop'
	];

	if (!get_theme_mod('albatross_fp_video_autoplay', true)) {
		$video_atts = array_diff($video_atts, ['autoplay']);
	}
	if (!get_theme_mod('albatross_fp_video_muted', true)) {
		$video_atts = array_diff($video_atts, ['muted']);
	}
	if (!get_theme_mod('albatross_fp_video_loop', true)) {
		$video_atts = array_diff($video_atts, ['loop']);
	};

	$title = get_theme_mod('albatross_fp_video_title', false);
	$text = get_theme_mod('albatross_fp_video_text', false);

	?>
    <div class="front-page-slider-slide slick-slide">
        <div class="front-page-slider-slide-wrapper">
            <div class="slide-header">
                <div class="description"><?php echo wp_kses_post($text); ?></div>
                <h2 class="title"><?php echo wp_kses_post($title); ?></h2>
                <div class="slider-controls">
                    <button class="fp-slider-prev">
                        <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                  d="M0.292893 7.29289C-0.0976311 7.68342 -0.0976311 8.31658 0.292893
                                                  8.70711L6.65685 15.0711C7.04738 15.4616 7.68054 15.4616 8.07107
                                                  15.0711C8.46159 14.6805 8.46159 14.0474 8.07107 13.6569L2.41421
                                                  8L8.07107 2.34315C8.46159 1.95262 8.46159 1.31946 8.07107
                                                  0.928932C7.68054 0.538408 7.04738 0.538408 6.65685
                                                  0.928932L0.292893 7.29289ZM1 9H26V7H1V9Z"/>
                        </svg>
                    </button>
                    <button class="fp-slider-next">
                        <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                  d="M25.7071 7.29289C26.0976 7.68342 26.0976 8.31658 25.7071
                                                  8.70711L19.3431 15.0711C18.9526 15.4616 18.3195 15.4616 17.9289
                                                  15.0711C17.5384 14.6805 17.5384 14.0474 17.9289 13.6569L23.5858
                                                  8L17.9289 2.34315C17.5384 1.95262 17.5384 1.31946 17.9289
                                                  0.928932C18.3195 0.538408 18.9526 0.538408 19.3431
                                                  0.928932L25.7071 7.29289ZM25 9H0V7H25V9Z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="slide-image">
                <video id="fp-slider-video" <?php echo esc_attr(implode(' ', $video_atts)); ?>>
                    <source src="<?php echo esc_url(wp_get_attachment_url($video_id)); ?>"
                            type="<?php echo esc_attr(get_post_mime_type($video_id)); ?>">
					<?php
					$image_id = get_theme_mod('albatross_fp_video_poster', false);
					if ($image_id) {
						echo wp_kses_post(wp_get_attachment_image($image_id, 'full'));
					}
					?>
                </video>
            </div>
        </div>
    </div>
	<?php
}

add_filter('albatross_header_classes', 'albatross_filter_header_classes');

function albatross_filter_header_classes($classes)
{
	if (is_page_template('template-page-sidebar.php')) {
		return $classes;
	}

	if (is_page() && has_post_thumbnail()) {
		$classes[] = 'absolute';
	}

	if (is_front_page() && !is_home()) {
		if (count(get_pages(array('child_of' => get_the_ID()))) || albatross_fp_video_enabled()) {
			$classes[] = 'absolute';
		}
	}

	return array_unique($classes);
}

function albatross_fp_video_enabled()
{

	$video_enabled = get_theme_mod('albatross_fp_enable_video', false);
	$video_id = get_theme_mod('albatross_fp_video', false);

	return apply_filters('albatross_enable_fp_video', $video_enabled && $video_id);
}

function albatross_add_more_to_nav($nav_menu, $args)
{
	if ('menu-1' === $args->theme_location) :
		$nav_menu .= '<div class="primary-menu-more">';
		$nav_menu .= '<ul class="menu nav-menu">';
		$nav_menu .= '<li class="menu-item menu-item-has-children">';
		$nav_menu .= '<button class="submenu-expand primary-menu-more-toggle is-empty" aria-label="' . esc_attr__('More', 'albatross') . '" aria-haspopup="true" aria-expanded="false">';
		$nav_menu .= '<span class="screen-reader-text">' . esc_html__('More', 'albatross') . '</span>';
		$nav_menu .= '<svg height="20px" viewBox="-14 -174 474.66578 474" width="20px" xmlns="http://www.w3.org/2000/svg">
						<path d="m382.457031-10.382812c-34.539062-.003907-62.539062 28-62.539062 62.542968 0 34.539063 28 62.539063 
						62.539062 62.539063 34.542969 0 62.542969-28 62.542969-62.539063-.039062-34.527344-28.015625-62.503906-62.542969-62.542968zm0 
						100.148437c-20.765625 0-37.605469-16.839844-37.605469-37.605469 0-20.769531 16.839844-37.605468 37.605469-37.605468 20.769531 
						0 37.605469 16.832031 37.605469 37.605468-.023438 20.757813-16.847656 37.574219-37.605469 37.605469zm0 0"/>
						<path d="m222.503906-10.382812c-34.542968 0-62.546875 28-62.546875 62.542968 0 34.539063 28.003907 62.539063 
						62.546875 62.539063 34.539063 0 62.539063-28 62.539063-62.539063 0-34.542968-28-62.542968-62.539063-62.542968zm0 
						100.148437c-20.773437 0-37.613281-16.839844-37.613281-37.605469 0-20.773437 16.839844-37.605468 37.613281-37.605468 
						20.765625 0 37.601563 16.832031 37.601563 37.605468 0 20.765625-16.835938 37.605469-37.601563 37.605469zm0 0"/>
						<path d="m62.542969-10.382812c-34.542969 0-62.542969 28-62.542969 62.542968 0 34.539063 28 62.539063 62.542969 62.539063 
						34.539062 0 62.539062-28 62.539062-62.539063-.039062-34.527344-28.015625-62.503906-62.539062-62.542968zm0 100.148437c-20.769531 
						0-37.605469-16.839844-37.605469-37.605469 0-20.773437 16.835938-37.605468 37.605469-37.605468s37.601562 16.832031 37.601562 
						37.605468c0 20.765625-16.835937 37.605469-37.601562 37.605469zm0 0"/></svg>';
		$nav_menu .= '</button>';
		$nav_menu .= '<ul class="sub-menu hidden-links">';
		$nav_menu .= '</ul>';
		$nav_menu .= '</li>';
		$nav_menu .= '</ul>';
		$nav_menu .= '</div>';
	endif;

	return $nav_menu;
}

add_filter('wp_nav_menu', 'albatross_add_more_to_nav', 10, 2);

add_action('comment_form_top', 'albatross_comment_form_top');

function albatross_comment_form_top()
{
	?>
    <div class="comment-fields-wrapper">
	<?php
}

add_action('comment_form', 'albatross_comment_form');

function albatross_comment_form()
{
	?>
    </div>
	<?php
}

add_action('elementor/widget/render_content', 'albatross_render_elementor_widget', 10, 2);

function albatross_render_elementor_widget($content, $widget)
{
	if ('stratum-advanced-posts' === $widget->get_name()) {
		return albatross_stratum_advanced_posts_content($content, $widget);
	}

	return $content;
}

function albatross_stratum_advanced_posts_content($content, $widget)
{
	$settings = $widget->get_settings();

	$query_args = [];
	stratum_build_custom_query($query_args, $settings);

	$q = new \WP_Query($query_args);

	$widget_class = 'stratum-advanced-posts';
	$slider_options = stratum_generate_swiper_options($settings);

	$class = 'stratum-advanced-posts layout-carousel masonry-disable';

	if ($settings['slide_animation_effect'] != 'none') {
		$class .= ' slide-effect-' . $settings['slide_animation_effect'];
	}

	if ($settings['slide_text_animation_effect'] != 'none') {
		$class .= ' has-text-animation-' . $settings['slide_text_animation_effect'];
	}

	ob_start();
	?>
    <div class="<?php echo esc_attr($class); ?>"
         data-slider-options="<?php echo esc_attr(json_encode($slider_options)); ?>">
        <div class="swiper-container">
            <div class="swiper-wrapper">
				<?php
				if ($q->have_posts()) {

					while ($q->have_posts()):
						$q->the_post();

						$post_id = get_the_ID();
						$url = get_the_post_thumbnail_url($post_id, $settings['image_size']);
						?>

                        <div class="swiper-slide stratum-advanced-posts__post">
                            <div class="stratum-advanced-posts__image">
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <img src="<?php echo esc_url($url); ?>" alt="">
                                </a>
                            </div>
                            <div class="stratum-advanced-posts__slide-content">
                                <div class="stratum-advanced-posts__slide-wrapper">
                                    <div class="stratum-advanced-posts__slide-container">

										<?php
										if (!empty($settings['show_meta'])) {
											?>
                                            <div class="stratum-advanced-posts__slide__entry-meta">
												<?php
												if (in_array("categories", $settings['show_meta'])) {
													?>
                                                    <div class="stratum-advanced-posts__post-categories">
														<?php albatross_post_categories(); ?>
                                                    </div>
													<?php
												}
												?>
                                            </div>
											<?php
										}

										if ($settings['show_title'] == 'yes') {
											$before_title = '<' . esc_attr($settings['title_typography_html_tag']) . ' 
																		class="stratum-advanced-posts__post-title">
																		<a href="' . esc_url(get_permalink()) . '">';
											$after_title = '</a></' . esc_attr($settings['title_typography_html_tag']) . '>';

											the_title($before_title, $after_title);
										}

										if ($settings['show_content'] == 'yes') {
											?>
                                            <div class="stratum-advanced-posts__post-content">
												<?php
												if ($settings['show_excerpt'] == 'yes') {
													if ($settings['excerpt_length']) {
														\Stratum\Excerpt_Helper::get_instance()->setExcerptLength($settings['excerpt_length']);
														add_filter('excerpt_length', array('Stratum\Excerpt_Helper', 'excerpt_length'), 999);
													}

													the_excerpt();

													remove_filter('excerpt_length', array('Stratum\Excerpt_Helper', 'excerpt_length'), 999);

												} else {
													the_content();
												}
												?>
                                            </div>
											<?php
										}
										?>
                                        <div class="stratum-advanced-posts__entry-footer">
											<?php
											if (in_array("date", $settings['show_meta'])) {
												?>
                                                <span class="stratum-advanced-posts__post-date">
                                                        <?php albatross_posted_on(); ?>
                                                    </span>
												<?php
											}

											if (in_array("author", $settings['show_meta'])) {
												?>
                                                <span class="stratum-advanced-posts__meta-fields-divider">
                                                        <?php echo esc_html($settings['meta_fields_divider']) ?>
                                                    </span>
                                                <div class="stratum-advanced-posts__post-author">
                                                    <span class="byline">
                                                        <span class="author vcard">
                                                        <a class="url fn n"
                                                           href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                            <?php echo esc_html(get_the_author()); ?>
                                                        </a></span>
                                                    </span>
                                                </div>
												<?php
											}

											if (in_array("comments", $settings['show_meta'])) {
												?>
                                                <span class="stratum-advanced-posts__meta-fields-divider">
                                                        <?php echo esc_html($settings['meta_fields_divider']) ?>
                                                    </span>
                                                <div class="stratum-advanced-posts__post-comments">
                                                        <span class="comments-link">
                                                        <?php
														comments_popup_link(
															sprintf(
																wp_kses(
																/* translators: %s: post title */
																	__('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'albatross'),
																	array(
																		'span' => array(
																			'class' => array(),
																		),
																	)
																),
																wp_kses_post(get_the_title())
															)
														);
														?>
                                                        </span>
                                                </div>
												<?php
											}

											if ($settings['show_read_more'] == 'yes') {
												?>

                                                <div class="stratum-advanced-posts__read-more">
                                                    <a href="<?php echo esc_url(get_permalink()); ?>"
														<?php if ($settings['open_new_tab'] == 'yes') {
															?>
                                                            target='_blank'
															<?php
														}
														?>
                                                    > <?php echo esc_html($settings['read_more_text']); ?></a>
                                                </div>
												<?php
											}

											?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php

					endwhile;
					wp_reset_postdata();

				} else {
					?>
                    <p><?php echo esc_html__('Nothing found.', 'albatross'); ?></p>
					<?php
				}
				?>
            </div>
			<?php
			if ($settings['navigation'] == 'both' || $settings['navigation'] == 'pagination') {
				if ($settings['pagination_style'] == 'scrollbar') {
					?>
                    <div class='swiper-scrollbar'></div>
					<?php
				} else {
					?>
                    <div class='swiper-pagination'></div>
					<?php
				}
			}
			?>
        </div>
		<?php
		if ($settings['navigation'] == 'both' || $settings['navigation'] == 'arrows') {
			?>
            <div class='stratum-swiper-button-prev'></div>
            <div class='stratum-swiper-button-next'></div>
			<?php
		}
		?>
    </div>

	<?php

	return ob_get_clean();
}