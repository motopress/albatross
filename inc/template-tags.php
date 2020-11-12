<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Albatross
 */

if (!function_exists('albatross_posted_on')) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function albatross_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date()),
			esc_attr(get_the_modified_date(DATE_W3C)),
			esc_html(get_the_modified_date())
		);

		echo '<span class="posted-on"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if (!function_exists('albatross_posted_by')) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function albatross_posted_by()
	{
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x('by %s', 'post author', 'albatross'),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
		);

		echo '<span class="byline"> ' . get_avatar(get_the_author_meta('ID'), 41) . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if (!function_exists('albatross_post_categories')) :
	/**
	 * Prints HTML with categories for the current post.
	 */
	function albatross_post_categories()
	{
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list(' ');
		if ($categories_list) {
			/* translators: 1: list of categories. */
			echo '<span class="cat-links">' . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;

if (!function_exists('albatross_post_tags')) :
	/**
	 * Prints HTML with tags for the current post.
	 */
	function albatross_post_tags()
	{
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'albatross'));
		if ($tags_list) {
			/* translators: 1: list of tags. */
			printf('<span class="tags-links">' . esc_html__('Tagged: %1$s', 'albatross') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;

if (!function_exists('albatross_entry_footer')) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function albatross_entry_footer()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			albatross_posted_by();
			albatross_post_categories();
			?>
            <hr>
			<?php
			albatross_post_tags();
		}

		if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
			echo '<span class="comments-link">';
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
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__('Edit <span class="screen-reader-text">%s</span>', 'albatross'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if (!function_exists('albatross_post_thumbnail')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function albatross_post_thumbnail($size = 'post-thumbnail')
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()) :
			?>

            <div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

		<?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					$size,
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
            </a>

		<?php
		endif; // End is_singular().
	}
endif;

if (!function_exists('wp_body_open')) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
endif;

if (!function_exists('albatross_post_navigation')):
	function albatross_post_navigation($class = '')
	{
		?>
        <div class="post-navigation-wrapper <?php echo esc_attr($class); ?>">
			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous', 'albatross') . '</span>
                                    <div class="title-wrapper">
                                    <span class="nav-title">%title</span>
                                    <svg width="26" height="16" viewBox="0 0 26 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.292893 8.67732C-0.0976311 8.2868 -0.0976311 7.65363 0.292893 7.26311L6.65685 0.899147C7.04738 
                                        0.508623 7.68054 0.508623 8.07107 0.899147C8.46159 1.28967 8.46159 1.92284 8.07107 2.31336L2.41421 
                                        7.97021L8.07107 13.6271C8.46159 14.0176 8.46159 14.6508 8.07107 15.0413C7.68054 15.4318 7.04738 
                                        15.4318 6.65685 15.0413L0.292893 8.67732ZM1 6.97021L26 6.97021V8.97021L1 8.97021L1 6.97021Z"/>
                                    </svg></div>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__('Next', 'albatross') . '</span>
                                    <div class="title-wrapper">
                                    <span class="nav-title">%title</span>
                                    <svg width="26" height="16" viewBox="0 0 26 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25.7071 7.26311C26.0976 7.65363 26.0976 8.2868 25.7071 8.67732L19.3431 15.0413C18.9526 
                                        15.4318 18.3195 15.4318 17.9289 15.0413C17.5384 14.6508 17.5384 14.0176 17.9289 13.6271L23.5858 
                                        7.97021L17.9289 2.31336C17.5384 1.92284 17.5384 1.28967 17.9289 0.899148C18.3195 0.508623 18.9526 
                                        0.508623 19.3431 0.899148L25.7071 7.26311ZM25 8.97021L8.74228e-08 8.97022L-8.74228e-08 6.97022L25 
                                        6.97021L25 8.97021Z"/>
                                    </svg></div>',
				)
			);
			?>
        </div>
		<?php
	}
endif;