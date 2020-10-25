<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Albatross
 */

if (!is_active_sidebar('sidebar-1') &&
	!is_active_sidebar('sidebar-2') &&
	!is_active_sidebar('sidebar-3')) {
	return;
}
?>

<div class="header-sidebar-wrapper">
    <div id="header-sidebar" class="header-sidebar">
		<?php
		if (is_active_sidebar('sidebar-1')) :
			?>
            <div class="widget-area">
				<?php dynamic_sidebar('sidebar-1'); ?>
            </div>
		<?php
		endif;

		if (is_active_sidebar('sidebar-2')) :
			?>
            <div class="widget-area">
				<?php dynamic_sidebar('sidebar-2'); ?>
            </div>
		<?php
		endif;

		if (is_active_sidebar('sidebar-3')) :
			?>
            <div class="widget-area">
				<?php dynamic_sidebar('sidebar-3'); ?>
            </div>
		<?php
		endif;
		?>
    </div><!-- #secondary -->
</div>