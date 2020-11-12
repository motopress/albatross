<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Albatross
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'albatross'); ?></a>

    <header id="masthead"
            class="<?php echo esc_attr(implode(' ', apply_filters('albatross_header_classes', ['site-header']))); ?>">
        <div class="site-header-container">
            <div class="default-navigation">
                <div class="site-branding">
					<?php
					the_custom_logo();
					?>
                    <div class="title-wrapper">
						<?php
						if (is_front_page() && is_home()) :
							?>
                            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                      rel="home"><?php bloginfo('name'); ?></a></h1>
						<?php
						else :
							?>
                            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                     rel="home"><?php bloginfo('name'); ?></a></p>
						<?php
						endif;
						$albatross_description = get_bloginfo('description', 'display');
						if ($albatross_description || is_customize_preview()) :
							?>
                            <p class="site-description"><?php echo $albatross_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?></p>
						<?php endif; ?>
                    </div>
                </div><!-- .site-branding -->
				<?php
				if (has_nav_menu('menu-1')) :
					?>
                    <div class="header-menu-wrapper">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id' => 'header-menu',
								'menu_class' => 'header-menu menu nav-menu',
								'container_class' => 'header-menu-container'
							)
						);
						?>
                    </div>
				<?php
				endif;
				?>
            </div>
            <div class="navigation-container">

				<?php
				if (has_nav_menu('menu-2')) {
					wp_nav_menu(
						array(
							'theme_location' => 'menu-2',
							'menu_id' => 'header-socials',
							'menu_class' => 'header-socials social-menu',
							'container_class' => 'header-socials-container',
							'link_before' => '<span class="menu-text">',
							'link_after' => '</span>'
						)
					);
				}
				?>

                <div class="header-dropdown">
                    <button id="header-dropdown-toggle" class="header-dropdown-toggle" aria-controls="header-dropdown"
                            aria-expanded="false"><?php esc_html_e('Menu', 'albatross'); ?></button>
                    <div class="header-dropdown-content">
                        <div class="header-dropdown-content-wrapper">
                            <nav id="site-navigation" class="main-navigation">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'menu-3',
										'menu_id' => 'primary-menu',
										'menu_class' => 'primary-menu',
										'container_class' => 'primary-menu-container'
									)
								);
								?>
                            </nav><!-- #site-navigation -->
							<?php
							get_sidebar('header');
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->
