<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Albatross
 */

if (!is_active_sidebar('sidebar-4') &&
	!is_active_sidebar('sidebar-5') &&
	!is_active_sidebar('sidebar-6') &&
	!is_active_sidebar('sidebar-7')) {
	return;
}
?>

<div id="footer-widgets" class="footer-widgets">
	<?php
	if (is_active_sidebar('sidebar-4')):
		?>
        <div class="widget-area">
			<?php dynamic_sidebar('sidebar-4'); ?>
        </div>
	<?php
	endif;
	if (is_active_sidebar('sidebar-5')):
		?>
        <div class="widget-area">
			<?php dynamic_sidebar('sidebar-5'); ?>
        </div>
	<?php
	endif;
	if (is_active_sidebar('sidebar-6')):
		?>
        <div class="widget-area">
			<?php dynamic_sidebar('sidebar-6'); ?>
        </div>
	<?php
	endif;
	if (is_active_sidebar('sidebar-7')):
		?>
        <div class="widget-area">
			<?php dynamic_sidebar('sidebar-7'); ?>
        </div>
	<?php
	endif;
	?>
</div><!-- #secondary -->
