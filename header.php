<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
?>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'dsbs502'); ?></a>

	<div id="wrapper">
		<header>
			<nav id="header" class="navbar navbar-dark navbar-expand-lg <?php echo esc_attr($navbar_scheme);
			if (isset($navbar_position) && 'fixed_top' === $navbar_position): echo ' fixed-top';
			elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position):
				echo ' fixed-bottom';
			endif;
			if (is_home() || is_front_page()):
				echo ' home';
			endif; ?>">
				<div class="container">
					<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>"
						title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<?php
						$header_logo = get_theme_mod('header_logo'); // Get custom meta-value.
						
						if (!empty($header_logo)):
							?>
							<img src="<?php echo esc_url($header_logo); ?>" width="147" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
							<?php
						else:
							echo esc_attr(get_bloginfo('name', 'display'));
						endif;
						?>
					</a>

					<!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
						aria-controls="navbar" aria-expanded="false"
						aria-label="<?php esc_attr_e('Toggle navigation', 'dsbs502'); ?>">
						<span class="navbar-toggler-icon"></span>
					</button> -->

					<div id="navbar" class="collapse navbar-collapse">
						<?php
						// Loading WordPress Custom Menu (theme_location).
						wp_nav_menu(
							array(
								'menu_class' => 'navbar-nav mx-auto',
								'container' => '',
								'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
								'walker' => new WP_Bootstrap_Navwalker(),
								'theme_location' => 'main-menu',
							)
						);

						if ('1' === $search_enabled):
							?>
							<!-- <form class="search-form my-2 my-lg-0" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
								<div class="input-group">
									<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Search', 'dsbs502'); ?>" title="<?php esc_attr_e('Search', 'dsbs502'); ?>" />
									<button type="submit" name="submit" class="btn btn-outline-secondary"><?php esc_html_e('Search', 'dsbs502'); ?></button>
								</div>
							</form> -->
							<?php
						endif;
						?>

					</div><!-- /.navbar-collapse -->

					<div class="menu-idiomas d-none d-lg-flex align-items-center"><?php dynamic_sidebar('header_widget_01'); ?></div>
					<a class="d-block d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasMainMenu" role="button"
					aria-controls="offcanvasMainMenu">
					<i class="bi bi-list text-white"></i></a>
				</div><!-- /.container -->
				<!--<a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasMainMenu" role="button"
					aria-controls="offcanvasMainMenu">
					Link with href
				</a>-->
				

				

				<div class="d-block d-lg-none offcanvas offcanvas-end" tabindex="-1" id="offcanvasMainMenu"
					aria-labelledby="offcanvasMainMenuLabel" aria-modal="true" role="dialog">
					<div class="offcanvas-header bg-transparent">
						<h5 class="offcanvas-title" id="offcanvasMainMenuLabel">Menu</h5><button type="button"
							class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body">
						<div id="navbarMobile">
						<?php
						// Loading WordPress Custom Menu (theme_location).
						wp_nav_menu(
							array(
								'menu_class' => 'navbar-nav mx-auto',
								'container' => '',
								'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
								'walker' => new WP_Bootstrap_Navwalker(),
								'theme_location' => 'main-menu',
							)
						);

						if ('1' === $search_enabled):
							?>
							<!-- <form class="search-form my-2 my-lg-0" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
								<div class="input-group">
									<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Search', 'dsbs502'); ?>" title="<?php esc_attr_e('Search', 'dsbs502'); ?>" />
									<button type="submit" name="submit" class="btn btn-outline-secondary"><?php esc_html_e('Search', 'dsbs502'); ?></button>
								</div>
							</form> -->
							<?php
						endif;
						?>
						</div>
					</div>
				</div>
			</nav><!-- /#header -->
		</header>

		<main id="main" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position): echo ' style="padding-top: 100px;"'; elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position):
			echo ' style="padding-bottom: 100px;"';
		endif; ?>>

		
				
		