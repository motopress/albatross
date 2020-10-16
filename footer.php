<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Albatross
 */

?>

<footer id="colophon" class="site-footer">
    <div class="site-footer-wrapper">
		<?php get_sidebar(); ?>

        <div class="site-info">
			<?php
			$dateObj = new DateTime;
			$year = $dateObj->format("Y");
			printf(
				get_theme_mod('albatross_footer_text',
					sprintf(
						esc_html_x('%1$s &copy; %2$s All Rights Reserved', 'Default footer text, %1$s - blog name, %2$s - current year', 'albatross'),
						get_bloginfo('name'),
						$year
					)
				),
				get_bloginfo('name'),
				$year
			);
			?>
        </div><!-- .site-info -->
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
