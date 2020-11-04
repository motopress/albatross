<?php
/**
 *
 * Avaialable variables
 * - bool $isShowGallery
 * - bool $isShowImage
 * - bool $isShowTitle
 * - bool $isShowExcerpt
 * - bool $isShowDetails
 * - bool $isShowPrice
 * - bool $isShowViewButton
 * - bool $isShowBookButton
 *
 * @version 1.2.0
 */
if (!defined('ABSPATH')) {
	exit;
}
if (post_password_required()) {
	$isShowGallery = $isShowImage = $isShowDetails = $isShowPrice = $isShowViewButton = $isShowBookButton = false;
}
$wrapperClass = apply_filters('mphb_sc_room_item_wrapper_class', join(' ', mphb_tmpl_get_filtered_post_class('mphb-room-type')));
?>
<div class="<?php echo esc_attr($wrapperClass); ?>">

	<?php do_action('mphb_sc_room_item_top'); ?>

	<?php
	if ($isShowGallery && mphb_tmpl_has_room_type_gallery()) {
		/**
		 * @hooked \MPHB\Views\LoopRoomTypeView::renderGallery - 10
		 */
		do_action('mphb_sc_room_render_gallery');
	} else if ($isShowImage && has_post_thumbnail()) {
		/**
		 * @hooked \MPHB\Views\LoopRoomTypeView::renderFeaturedImage - 10
		 */
		?>
        <div class="mphb-room-type-images">
			<?php
			do_action('mphb_sc_room_render_image');

			?>
        </div>
		<?php
	}

	if ($isShowTitle || $isShowExcerpt || $isShowDetails || $isShowPrice || $isShowViewButton || $isShowBookButton):
		?>
        <div class="mphb-room-type-content-wrapper">
            <div class="mphb-room-type-content">
				<?php
				if ($isShowTitle || $isShowExcerpt || $isShowDetails || $isShowPrice):
					?>
                    <div class="mphb-room-type-description">
						<?php
						if ($isShowTitle) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderTitle - 10
							 */
							do_action('mphb_sc_room_render_title');
						}


						if ($isShowPrice) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderPrice - 10
							 */
							do_action('mphb_sc_room_render_price');
						}

						if ($isShowExcerpt) {
							?>
                            <div class="mphb-room-type-excerpt">
								<?php
								/**
								 * @hooked \MPHB\Views\LoopRoomTypeView::renderExcerpt - 10
								 */
								do_action('mphb_sc_room_render_excerpt');
								?>
                            </div>
							<?php
						}

						if ($isShowDetails) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderAttributes - 10
							 */
							do_action('mphb_sc_room_render_details');
						}
						?>
                    </div>
				<?php
				endif;
				if ($isShowViewButton || $isShowBookButton):
					?>
                    <div class="mphb-room-type-buttons">
						<?php
						if ($isShowViewButton) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderViewDetailsButton - 10
							 */
							do_action('mphb_sc_room_render_view_button');
						}

						if ($isShowBookButton) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderBookButton - 10
							 */
							do_action('mphb_sc_room_render_book_button');
						}

						?>
                    </div>
				<?php
				endif;
				do_action('mphb_sc_room_item_bottom'); ?>
            </div>
        </div>
	<?php
	endif;
	?>
</div>