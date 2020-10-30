<?php
/**
 *
 * Avaialable variables
 * - DateTime $checkInDate
 * - DateTime $checkOutDate
 * - int $adults
 * - int $children
 * - bool $isShowGallery
 * - bool $isShowImage
 * - bool $isShowTitle
 * - bool $isShowExcerpt
 * - bool $isShowDetails
 * - bool $isShowPrice
 * - bool $isShowViewButton
 * - bool $isShowBookButton
 *
 * @version 2.0.0
 */
if (!defined('ABSPATH')) {
	exit;
}

if (post_password_required()) {
	$isShowGallery = $isShowImage = $isShowDetails = $isShowPrice = $isShowViewButton = $isShowBookButton = false;
}

do_action('mphb_sc_search_results_before_room');

$wrapperClass = apply_filters('mphb_sc_search_results_room_type_class', join(' ', mphb_tmpl_get_filtered_post_class('mphb-room-type')));
?>
    <div class="<?php echo esc_attr($wrapperClass); ?>">

		<?php do_action('mphb_sc_search_results_room_top'); ?>

		<?php
		if ($isShowGallery && mphb_tmpl_has_room_type_gallery()) {
			/**
			 * @hooked \MPHB\Views\LoopRoomTypeView::renderGallery - 10
			 */
			do_action('mphb_sc_search_results_render_gallery');
		} else if ($isShowImage && has_post_thumbnail()) {
			/**
			 * @hooked \MPHB\Views\LoopRoomTypeView::renderFeaturedImage - 10
			 */
			do_action('mphb_sc_search_results_render_image');
		}

		if ($isShowTitle || $isShowExcerpt || $isShowDetails || $isShowPrice || $isShowViewButton || $isShowBookButton):
			?>
            <div class="mphb-room-type-content">
				<?php

				do_action('mphb_sc_search_results_before_info');

				if ($isShowTitle || $isShowExcerpt || $isShowDetails || $isShowPrice):
					?>
                    <div class="mphb-room-type-description">
						<?php
						if ($isShowTitle) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderTitle - 10
							 */
							do_action('mphb_sc_search_results_render_title');
						}

						if ($isShowPrice) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderPriceForDates - 10
							 */
							do_action('mphb_sc_search_results_render_price', $checkInDate, $checkOutDate);
						}

						if ($isShowExcerpt) :
							?>
                            <div class="mphb-room-type-excerpt">
								<?php
								/**
								 * @hooked \MPHB\Views\LoopRoomTypeView::renderExcerpt - 10
								 */
								do_action('mphb_sc_search_results_render_excerpt');
								?>
                            </div>
						<?php
						endif;

						if ($isShowDetails) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderAttributes - 10
							 */
							do_action('mphb_sc_search_results_render_details');
						}
						?>
                    </div>
				<?php
				endif;

				if ($isShowViewButton || $isShowBookButton):
					?>
                    <div class="mphb-room-type-buttons">
						<?php
						if ($isShowBookButton) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderBookButton - 10
							 */
							do_action('mphb_sc_search_results_render_book_button');
						}

						if ($isShowViewButton) {
							/**
							 * @hooked \MPHB\Views\LoopRoomTypeView::renderViewDetailsButton - 10
							 */
							do_action('mphb_sc_search_results_render_view_button');
						}
						?>
                    </div>
				<?php
				endif;

				do_action('mphb_sc_search_results_after_info');
				?>
            </div>
		<?php
		endif;
		?>

		<?php do_action('mphb_sc_search_results_room_bottom'); ?>

    </div>
<?php
do_action('mphb_sc_search_results_after_room');
