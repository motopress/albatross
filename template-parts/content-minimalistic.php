<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Albatross
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php albatross_post_thumbnail('albatross-large'); ?>

    <header class="entry-header">

		<?php
		if ('post' === get_post_type()) :
			albatross_post_categories();
		endif;

		if (is_singular()) :
			the_title('<h1 class="entry-title">', '</h1>');
		else :
			the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
		endif;

		if ('post' === get_post_type()) :
			?>
            <div class="entry-meta">
				<?php
				albatross_posted_on();
				?>
            </div><!-- .entry-meta -->
		<?php endif; ?>
    </header><!-- .entry-header -->

</article><!-- #post-<?php the_ID(); ?> -->
