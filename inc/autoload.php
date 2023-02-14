<?php
include get_theme_file_path( 'inc/autoload/Loader.php' );

$loader = new \WPTRT\Autoload\Loader();

$loader->add( 'WPTRT\\AdminNotices', get_theme_file_path( 'inc/admin-notices' ) );
$loader->register();