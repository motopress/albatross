<?php

function albatross_add_theme_help_page() {
    add_theme_page(
        esc_html__( 'Theme Help', 'albatross' ),
        esc_html__( 'Theme Help', 'albatross' ),
        'edit_theme_options',
        'albatross-theme-help',
        'albatross_theme_help_page_content',
        999
    );
}

add_action( 'admin_menu', 'albatross_add_theme_help_page' );


function albatross_theme_help_page_content() {
    ?>
    <div class="wrap">
        <h1>
            <?php esc_html_e( 'Quick Start Guide', 'albatross' ); ?>
        </h1>
        <div style="max-width: 768px;">
            <hr>

            <h2><?php esc_html_e( 'Editing Home Page slides', 'albatross' );?></h2>
            <p><?php esc_html_e( 'Each slide is a child page (sub-page) of the Home Page. To edit the slides:', 'albatross' );?></p>
            <p><?php esc_html_e( '1. Navigate to Pages > All Pages and edit child pages (sub-pages) of the Home Page to change the title, descriptions, and featured image.', 'albatross' );?></p>
            <p><?php esc_html_e( '2. Go to Appearance > Customize > Theme Settings > Front Page Slider to adjust the speed of the animation or slideshow. There you can also set the video for the slider.', 'albatross' );?></p>

            <hr>

            <h2><?php esc_html_e( 'Transforming a list of Accommodations Types into a slider', 'albatross' );?></h2>
            <p><?php printf( esc_html__( 'If you are on Elementor: open the Accommodation Types widget > Parameters > Class > add a  %1$s CSS class.', 'albatross' ), '<code>slider</code>');?></p>
            <p><?php printf( esc_html__( 'If you are on the block editor: open the Accommodation Types Listing block > Advanced > Additional CSS class(es) > add a %1$s CSS class', 'albatross' ), '<code>slider</code>');?></p>
            <p><?php printf( esc_html__( 'If you use a shortcode: add %2$s parameter and fill it with a %1$s CSS class (example %3$s).', 'albatross' ), '<code>slider</code>', '<code>class=""</code>', '<code>class="slider"</code>');?></p>

            <hr>

            <h2><?php esc_html_e( 'Colors Customization', 'albatross' );?></h2>
            <p><?php esc_html_e( 'Go to Appearance > Customize > Colors > edit colors.', 'albatross' );?></p>
        </div>
    </div>
    <?php
}