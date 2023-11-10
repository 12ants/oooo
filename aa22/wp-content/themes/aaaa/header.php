<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package aaaa
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
<meta name="description" content="<?php bloginfo( 'name' ); ?> | <?php bloginfo( 'description' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'aaaa' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			endif;
			$aaaa_description = get_bloginfo( 'description', 'display' );
			if ( $aaaa_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $aaaa_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			
			
			<!--  menu  -->
<input type="checkbox" id="toggle" class="visually-hidden">
<input type="checkbox" id="menu-open">
<label for="menu-open" class="nav-btn">
  <span></span><span></span><span></span></label>
<label for="toggle" class="nav-btn"></label><?php esc_html_e( '', 'aaaa' ); ?>
<input type="checkbox" id="menu-open" class="visually-hidden">
<input type="checkbox" id="toggle" class="visually-hidden">
<input type="checkbox" id="menu-open">

<!-- menu-items-->
<div class="menu1">
  <div class="menu-item" style="transition-delay:0s;">
 	<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
  </div>
</div>

			
			
		
		</nav><!-- #site-navigation -->
		<style>
	
		
		</style>
		
	</header><!-- #masthead -->
