<?php
/**
 * Template part for displaying mphb_room_type
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Albatross
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->

	<?php albatross_post_thumbnail(); ?>

    <div class="single-room-type-wrapper">

        <div class="entry-content">
			<?php if (has_excerpt()): ?>
                <div class="room-excerpt">
					<?php
					$excerpt = get_the_excerpt();
					?>
                    <span class="first-letter">
                    <?php
					echo esc_html($excerpt[0]);
					?>
                </span>
                    <p>
						<?php echo wp_kses_post(substr($excerpt, 1)); ?>
                    </p>
                </div>
			<?php endif; ?>
			<?php
			the_content(
				sprintf(
					wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
						__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'albatross'),
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
        </div><!-- .entry-content -->
        <div class="single-room-type-sidebar">
			<?php
			albatross_single_room_type_sidebar();
			?>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
