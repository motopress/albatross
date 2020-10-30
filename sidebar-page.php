<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Albatross
 */

if (!is_active_sidebar('sidebar-8')) {
	return;
}
?>

<aside id="secondary" class="widget-area page-sidebar">
	<?php dynamic_sidebar('sidebar-8'); ?>
</aside><!-- #secondary -->
