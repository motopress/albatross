<?php
/**
 * Template Name: Page With Sidebar
 */

get_header();
?>
    <div class="page-with-sidebar-container">
		<?php albatross_simple_page_header(); ?>
        <div class="page-with-sidebar-wrapper">
            <main id="primary" class="site-main">

				<?php
				while (have_posts()) :
					the_post();

					get_template_part('template-parts/content', 'page');

					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

            </main><!-- #main -->

			<?php
			get_sidebar('page');
			?>
        </div>
    </div>
<?php
get_footer();