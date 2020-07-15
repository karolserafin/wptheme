<?php
/**
 * Header file for the wctheme WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wctheme
 * @since wctheme 1.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
		<link rel="profile" href="https://gmpg.org/xfn/11">

		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/favicon-16x16.png">
		<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#bf883b;">
		<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
		<meta name="theme-color" content="#bf883b;">
		
		<meta property="og:title" content="<?php the_title(); ?>" />
		<meta property="og:url" content="<?php the_permalink(); ?>" />

		<?php if ( has_post_thumbnail() ): ?>
			<?php if ( get_post_meta( get_the_ID(), 'wctheme_share_image_link', true ) ) : ?>
				<meta property="og:image" content="<?php echo wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'wctheme_share_image_link', true ), 'full' )[0]; ?>" />
				<meta property="og:image:secure_url" content="<?php echo wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'wctheme_share_image_link', true ), 'full' )[0]; ?>" />
				<meta property="og:image:width" content="<?php echo wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'wctheme_share_image_link', true ), 'full' )[1]; ?>" />
				<meta property="og:image:height" content="<?php echo wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'wctheme_share_image_link', true ), 'full' )[2]; ?>" />
				<meta property="og:image:type" content="image/png" />
			<?php else: ?>
				<meta property="og:image" content="<?php echo get_the_post_thumbnail_url(); ?>" />
				<meta property="og:image:secure_url" content="<?php echo get_the_post_thumbnail_url(); ?>" />
				<meta property="og:image:width" content="600" />
				<meta property="og:image:height" content="315" />
				<meta property="og:image:type" content="image/jpeg" />
			<?php endif; ?>
		
		<?php endif; ?>
		
		<meta property="og:description" content="<?php echo strip_tags( get_the_excerpt() ); ?>" />
		<meta name="description" content="wctheme Patisserie & Chocolaterie to luksusowa cukiernia w Warszawie specjalizująca się w ciastkach typu petit gateau, tortach i czekoladowych pralinach!">

		<?php wp_head(); ?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132475184-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		  gtag('config', 'UA-132475184-1');
		</script>

		<!-- Facebook Pixel Code -->
		<script>
		  !function(f,b,e,v,n,t,s)
		  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		  n.queue=[];t=b.createElement(e);t.async=!0;
		  t.src=v;s=b.getElementsByTagName(e)[0];
		  s.parentNode.insertBefore(t,s)}(window, document,'script',
		  'https://connect.facebook.net/en_US/fbevents.js');
		  fbq('init', '473013286584053');
		  fbq('track', 'PageView');
		</script>
		<noscript>
		  <img height="1" width="1" style="display:none" 
		       src="https://www.facebook.com/tr?id=473013286584053&ev=PageView&noscript=1"/>
		</noscript>
		<!-- End Facebook Pixel Code -->
	</head>
	<body <?php body_class(); ?>>
		<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=473013286584053&ev=PageView&noscript=1"/></noscript>
		<?php wp_body_open(); ?>

		<header class="app__header uk-container uk-container-large">

			<div class="uk-navbar-container uk-navbar-transparent main-navigation-container" uk-navbar>

				<div class="main-navigation-container--left">

					<div class="desktop-search">
						<div class="desktop-search__icon">
							<button class="search-link" name="search-init"></button>
						</div>
					</div>

					<div class="mobile-hamburger">

						<a href="#offcanvas-slide" class="" uk-toggle>
							<svg width="24" height="17" viewBox="0 0 24 17" xmlns="http://www.w3.org/2000/svg">
								<g fill="none" fill-rule="evenodd">
									<g fill="#292929">
									<g>
										<rect width="24" height="2" rx="1"/>
										<rect y="14.632" width="24" height="2" rx="1"/>
										<rect y="7.316" width="19.895" height="2" rx="1"/>
									</g>
									</g>
								</g>
							</svg>

						</a>

					</div>

				</div>

				<div class="main-navigation-container--center">

					<?php if ( has_nav_menu( 'header-left' ) ) : ?>
						<nav role="navigation" class="header__menu header__menu--left main-navigation-container__nav">

							<?php wp_nav_menu(
								array(
									'container'  			=> '',
									'menu_id' 				=> 'header-left',
									'theme_location' 		=> 'header-left',
									'walker' 				=> new wctheme_Nav_Walker()
								)
							); ?>


						</nav>

					<?php endif; ?>

					<?php if ( get_field( 'logo', 'options' ) ) : ?>
						<a href="<?php echo get_site_url(); ?>" class="wctheme-logo">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-wctheme.svg" alt="<?php echo __( 'wctheme', 'wctheme' ); ?>" />
						</a>
					<?php endif; ?>

					<?php if ( has_nav_menu( 'header-right' ) ) : ?>
						<nav role="navigation" class="header__menu header__menu--right main-navigation-container__nav">

							<?php wp_nav_menu(
								array(
									'container'  			=> '',
									'menu_id' 				=> 'header-right',
									'theme_location' 		=> 'header-right',
									'walker' 				=> new wctheme_Nav_Walker()
								)
							); ?>

						</nav>
					<?php endif; ?>

				</div>

				<div class="main-navigation-container--right">

					<?php if ( has_nav_menu( 'header-ecommerce' ) ) : ?>
						<nav role="navigation" class="header__menu header__menu--user links-container">

							<?php wp_nav_menu(
								array(
									'container'  			=> '',
									'menu_id' 				=> 'header-ecommerce',
									'theme_location' 		=> 'header-ecommerce',
								)
							); ?>

							<a href="/koszyk" class="cart-link">
	                            <span class="cart-items-count count">
	                                <?= WC()->cart->get_cart_contents_count(); ?>
	                            </span>
	                        </a>

	                        <?php if ( function_exists( 'woocommerce_mini_cart' ) ) : ?>
	                            <div class="widget_shopping_cart_content">
	                                <?php woocommerce_mini_cart() ?>
	                            </div>
	                        <?php endif; ?>

						</nav>
					<?php endif; ?>

				</div>

				<div class="search-container">
					<?php get_search_form( true ); ?>
					<button class="search-container__close" name="close-search" type="button" uk-close></button>
				</div>

			</div>

		</header>

			<div id="offcanvas-slide" uk-offcanvas>
				<div class="uk-offcanvas-bar">

				<button class="uk-offcanvas-close" type="button">
					<img src="<?= get_template_directory_uri() . '/assets/img/close-icon.png' ?>" class="logo-block__img" alt="wctheme logo">
				</button>

				<div class="mobile-menu-header">

					<?php if ( get_field( 'logo', 'options' ) ) : ?>
						<a href="<?php echo get_site_url(); ?>" class="wctheme-logo">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-wctheme.svg" alt="<?php echo __( 'wctheme', 'wctheme' ); ?>" />
						</a>
					<?php endif; ?>

					<?php get_search_form( true ); ?>

				</div>

				<?php if ( has_nav_menu( 'header-mobile' ) ) : ?>
					<nav role="navigation" class="mobile-menu-body">

						<?php wp_nav_menu(
							array(
								'container'  			=> '',
								'menu_id' 				=> 'header-mobile',
								'theme_location' 		=> 'header-mobile',
								'walker' 				=> new wctheme_mobile_Nav_Walker_Nav_Menu()
							)
						); ?>

					</nav>

				<?php endif; ?>
				</div>
			</div>

		<main role="main" class="app__main container">