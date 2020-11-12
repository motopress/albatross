<?php

if (!defined('ABSPATH')) {
	exit;
}
?>

<?php

/**
 * @hooked \MPHB\Views\LoopRoomTypeView::_renderBookButtonWrapperOpen - 10
 */
do_action('mphb_render_loop_room_type_before_book_button');
?>

<?php
$button_text = '<svg enable-background="new 0 0 30.99 6.99" 
				viewBox="0 0 30.99 6.99" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
            	<rect y="3" width="30" height="1"></rect><polyline points="26.78 0.68 28.18 2.08 29.58 3.48 26.8 6.26 
            	27.53 6.99 30.99 3.53 27.46 0"></polyline></svg>' .
				esc_html_x('Book now', 'Loop book button text', 'albatross');
mphb_tmpl_the_loop_room_type_book_button_form($button_text);
?>

<?php

/**
 * @hooked \MPHB\Views\LoopRoomTypeView::_renderBookButtonBr - 10
 * @hooked \MPHB\Views\LoopRoomTypeView::_renderBookButtonWrapperClose - 20
 */
do_action('mphb_render_loop_room_type_after_book_button');
