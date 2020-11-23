<?php
add_filter('mphb_loop_room_type_gallery_main_slider_image_size', 'albatross_loop_room_type_gallery_image_size');
function albatross_loop_room_type_gallery_image_size()
{
	return 'albatross-large';
}

add_filter('mphb_loop_room_type_gallery_use_nav_slider', '__return_false');

add_filter('mphb_loop_room_type_gallery_main_slider_flexslider_options', 'albatross_mphb_flexslider_options');

function albatross_mphb_flexslider_options($options)
{
	$options['prevText'] = '<svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0.292893 8.23396C-0.0976311 7.84344 -0.0976311 7.21027 0.292893 6.81975L6.65685 
							0.455787C7.04738 0.0652627 7.68054 0.0652627 8.07107 0.455787C8.46159 0.846311 8.46159 
							1.47948 8.07107 1.87L2.41421 7.52686L8.07107 13.1837C8.46159 13.5742 8.46159 14.2074 
							8.07107 14.5979C7.68054 14.9884 7.04738 14.9884 6.65685 14.5979L0.292893 8.23396ZM1 
							6.52686L18 6.52685L18 8.52685L1 8.52686L1 6.52686Z"/></svg>';
	$options['nextText'] = '<svg width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.7608 8.23396C18.1513 7.84344 18.1513 7.21027 17.7608 6.81975L11.3969 
							0.455787C11.0063 0.0652627 10.3732 0.0652627 9.98264 0.455787C9.59212 0.846311 9.59212 
							1.47948 9.98264 1.87L15.6395 7.52686L9.98264 13.1837C9.59212 13.5742 9.59212 14.2074 
							9.98264 14.5979C10.3732 14.9884 11.0063 14.9884 11.3969 14.5979L17.7608 8.23396ZM17.0537 
							6.52686L0.053711 6.52685L0.0537109 8.52685L17.0537 8.52686L17.0537 6.52686Z"/></svg>';

	return $options;
}

remove_action('mphb_render_loop_room_type_after_book_button', array('\MPHB\Views\LoopRoomTypeView', '_renderBookButtonBr'), 10);

add_filter('mphb_pagination_args', 'albatross_mphb_pagination_args');

function albatross_mphb_pagination_args($args)
{
	$svg = '<svg width="26" height="16" viewBox="0 0 26 16" xmlns="http://www.w3.org/2000/svg">
			<path d="M25.7071 7.29289C26.0976 7.68342 26.0976 8.31658 25.7071 8.70711L19.3431 15.0711C18.9526 
			5.4616 18.3195 15.4616 17.9289 15.0711C17.5384 14.6805 17.5384 14.0474 17.9289 13.6569L23.5858 8L17.9289 
			2.34315C17.5384 1.95262 17.5384 1.31946 17.9289 0.928932C18.3195 0.538408 18.9526 0.538408 19.3431 
			0.928932L25.7071 7.29289ZM25 9H0V7H25V9Z"/></svg>';

	$new_args = array(
		'mid_size' => 1,
		'prev_text' => $svg . esc_html__('Previous', 'albatross'),
		'next_text' => esc_html__('Next', 'albatross') . $svg
	);

	return array_merge($args, $new_args);
}

remove_action('mphb_render_single_room_type_metas', array('\MPHB\Views\SingleRoomTypeView', 'renderAttributes'), 20);
remove_action('mphb_render_single_room_type_metas', array('\MPHB\Views\SingleRoomTypeView', 'renderDefaultOrForDatesPrice'), 30);
remove_action('mphb_render_single_room_type_metas', array('\MPHB\Views\SingleRoomTypeView', 'renderReservationForm'), 50);

add_action('albatross_single_room_type_metas', array('\MPHB\Views\SingleRoomTypeView', 'renderDefaultOrForDatesPrice'), 10);
add_action('albatross_single_room_type_metas', array('\MPHB\Views\SingleRoomTypeView', 'renderAttributes'), 20);
add_action('albatross_single_room_type_form', array('\MPHB\Views\SingleRoomTypeView', 'renderReservationForm'), 10);

function albatross_single_room_type_sidebar()
{
	?>
    <div class="room-type-meta room-type-sidebar-block">
		<?php
		do_action('albatross_single_room_type_metas');
		?>
    </div>
    <div class="room-type-form room-type-sidebar-block">
		<?php
		do_action('albatross_single_room_type_form');
		?>
    </div>
	<?php
}

add_filter('mphb_single_room_type_gallery_columns', 'albatross_mphb_single_room_type_gallery_columns');

function albatross_mphb_single_room_type_gallery_columns()
{
	return 2;
}

add_filter('mphb_single_room_type_gallery_image_size', 'albatross_mphb_single_room_type_gallery_image_size');

function albatross_mphb_single_room_type_gallery_image_size()
{
	return 'albatross-small';
}

remove_action('mphb_render_single_room_type_before_attributes', array('\MPHB\Views\SingleRoomTypeView', '_renderAttributesTitle'), 10);
remove_action('mphb_render_single_room_type_before_reservation_form', array('\MPHB\Views\SingleRoomTypeView', '_renderReservationFormTitle'), 10);

add_filter('mphbr_reviews_template', 'albatross_mphbr_reviews_template');

function albatross_mphbr_reviews_template($path)
{
	return get_template_directory() . '/mphb-reviews/reviews.php';
}

function albatross_review_callback($comment, $args, $depth)
{
	$tag = ('div' === $args['style']) ? 'div' : 'li';

	$commenter = wp_get_current_commenter();
	if ($commenter['comment_author_email']) {
		$moderation_note = esc_html__('Your comment is awaiting moderation.', 'albatross');
	} else {
		$moderation_note = esc_html__('Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.', 'albatross');
	}
	?>
    <<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? 'parent' : '', $comment); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php
		if (0 != $args['avatar_size']) {
			echo get_avatar($comment, $args['avatar_size']);
		}
		?>
        <div class="review-comment-wrapper">
            <footer class="comment-meta">
                <div class="comment-author vcard">
					<?php
					printf('<span class="fn">%s</span>', get_comment_author_link($comment));
					?>
                </div><!-- .comment-author -->
                <div class="comment-metadata">
                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                        <time datetime="<?php comment_time('c'); ?>">
							<?php echo esc_html(get_comment_date('', $comment)) ?>
                        </time>
                    </a>
					<?php edit_comment_link(__('Edit', 'albatross'), '<span class="edit-link">', '</span>'); ?>
                </div><!-- .comment-metadata -->

				<?php if ('0' == $comment->comment_approved) : ?>
                    <em class="comment-awaiting-moderation"><?php echo wp_kses_post($moderation_note); ?></em>
				<?php endif; ?>
            </footer>

            <div class="comment-content">
				<?php comment_text(); ?>
            </div><!-- .comment-content -->
        </div>

    </article><!-- .comment-body -->
	<?php
}

add_action('mphb_sc_checkout_room_details', 'albatross_mphb_sc_checkout_room_details_before', 15);

function albatross_mphb_sc_checkout_room_details_before()
{
	?>
    <div class="guest-chooser-wrapper">
	<?php
}

add_action('mphb_sc_checkout_room_details', 'albatross_mphb_sc_checkout_room_details_after', 25);

function albatross_mphb_sc_checkout_room_details_after()
{
	?>
    </div>
	<?php
}

add_action('mphb_sc_rooms_before_loop', 'albatross_mphb_sc_rooms_before_loop');

function albatross_mphb_sc_rooms_before_loop()
{
	?>
    <div class="rooms-wrapper">
	<?php
}

add_action('mphb_sc_rooms_after_loop', 'albatross_mphb_sc_rooms_after_loop');

function albatross_mphb_sc_rooms_after_loop()
{
	?>
    </div>
	<?php
}