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

		<?php
		if( get_theme_mod('albatross_show_footer_text', true) == true ):
		?>
        <div class="site-info">
			<?php
			$dateObj = new DateTime;
			$current_year = $dateObj->format("Y");
			echo wp_kses_post(sprintf(
				get_theme_mod('albatross_footer_text',
					sprintf(
						_x('%1$s &copy; %2$s All Rights Reserved.<br> <span style="font-size: .875em;">Powered by <a href="https://motopress.com/products/albatross/" rel="nofollow">Albatross</a> WordPress theme.</span>', 'Default footer text, %1$s - blog name, %2$s - current year', 'albatross'),
						get_bloginfo('name'),
						$current_year
					)
				),
				get_bloginfo('name'),
				$current_year
			));
			?>
        </div><!-- .site-info -->
        <?php
        endif;
        ?>

        <a href="#page" class="scroll-to-top-button">
            <svg width="12" height="17" viewBox="0 0 12 17" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.53033 0.46967C6.23744 0.176777 5.76256 0.176777 5.46967 0.46967L0.696699 5.24264C0.403806 5.53553 0.403806 6.01041 0.696699 6.3033C0.989593 6.59619 1.46447 6.59619 1.75736 6.3033L6 2.06066L10.2426 6.3033C10.5355 6.59619 11.0104 6.59619 11.3033 6.3033C11.5962 6.01041 11.5962 5.53553 11.3033 5.24264L6.53033 0.46967ZM5.25 1L5.25 17L6.75 17L6.75 1L5.25 1Z"/>
            </svg>
        </a>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
