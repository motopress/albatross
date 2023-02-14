<?php
$albatross_notices = new \WPTRT\AdminNotices\Notices();

function albatross_get_import_demo_data_guide_notice() {
	ob_start();
	?>
	<ol>
		<li><?php
			echo wp_kses(
				sprintf(
					__( 'Follow the prompts to <a href="%1$s">install required plugins</a>.', 'albatross' ),
					admin_url( 'themes.php?page=tgmpa-install-plugins' )
				),
				[ 'a' => [ 'href' => [] ] ]
			);
		?></li>
		<li><?php esc_html_e('If you create a new website, you may import sample data following these steps:', 'albatross'); ?>
			<ol>
				<li><?php
					echo wp_kses(
						sprintf(
							__( 'Download content and widgets import files <a href="%1$s">here</a>.', 'albatross' ),
							esc_url('https://motopress.com/products/albatross/#install-demo-guide')
						),
						[ 'a' => [ 'href' => [] ] ]
					);
				?></li>
				<li><?php
					echo wp_kses(
						sprintf(
							__( 'Go to  <a href="%1$s">Appearance > Import Demo Data > Manual Demo File Import</a> section and select downloaded files following the instructions.', 'albatross' ),
							admin_url( 'themes.php?page=pt-one-click-demo-import' )
						),
						[ 'a' => [ 'href' => [] ] ]
					);
				?></li>
			</ol>
		</li>
		<li><?php
			echo wp_kses(
				sprintf(
					__( 'Go to <a href="%1$s">Appearance > Theme Help</a> to get useful tips for quick theme customization.', 'albatross' ),
					admin_url( 'themes.php?page=albatross-theme-help' )
				),
				[ 'a' => [ 'href' => [] ] ]
			);
			?></li>
	</ol>
	<?php
	return ob_get_clean();
}

function albatross_get_import_demo_data_notice() {
	ob_start();
	?>
	<p><?php esc_html_e( 'To import demo data, follow the steps below:', 'albatross' ); ?>
	<ol>
		<li><?php esc_html_e( 'Download content and widgets import files.', 'albatross' ); ?></li>
		<li><?php
			echo wp_kses(
				__( 'Go to <strong>Manual Demo File Import</strong> section and select downloaded files following the instructions.', 'albatross' ),
				[ 'strong' => [] ]
			);
		?></li>
	</ol>
	<p><a class="button-primary" href="https://motopress.com/products/albatross/#install-demo-guide" target="_blank"><?php esc_html_e( 'Download import files', 'albatross' ); ?></a></p>
	<p><small><?php esc_html_e( 'According to the WordPress rules for the demo importing or downloading, we can’t pack the theme with import files or provide a direct download link to them, that is why you must manually download and import the files.', 'albatross' ); ?>
	<br><a href="https://make.wordpress.org/themes/handbook/review/required/#9-files" target="_blank"><?php esc_html_e('Theme Requirements - Files', 'albatross'); ?></a></small></p>
	<?php
	return ob_get_clean();
}

// Add a notice.
$albatross_notices->add(
	'import_demo_data_guide', // Unique ID.
	esc_html__( 'Theme installation steps', 'albatross' ), // The title for this notice.
	// The content for this notice.
	albatross_get_import_demo_data_guide_notice(),
	[
		'scope'         => 'user',      // user/global.
		'screens'       => [ 'themes', 'appearance_page_tgmpa-install-plugins' ],
		'type'          => 'info',      // info, success, warning, error.
		'alt_style'     => false,       // Use alt styles. true/false
		'option_prefix' => 'albatross',
	]
);

// Add a notice.
$albatross_notices->add(
	'import_demo_data', // Unique ID.
	esc_html__( 'Important note before importing sample data', 'albatross' ), // The title for this notice.
	// The content for this notice.
	albatross_get_import_demo_data_notice(),
	[
		'scope'         => 'user',      // user/global.
		'screens'       => [ 'appearance_page_one-click-demo-import' ],
		'type'          => 'info',      // info, success, warning, error.
		'alt_style'     => false,       // Use alt styles. true/false
		'option_prefix' => 'albatross',
	]
);

// Boot things up.
$albatross_notices->boot();
