<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wctheme
 * @since wctheme 1.0
 */

?>
		
		</main>	
		
		<?php $footer__banner = get_field('footer__banner', 'options'); ?>
		
		<footer class="app__footer">

		<?php if ( !empty( $footer__banner ) ): ?>
			<div class="footer" style="background-image: url(<?php echo $footer__banner; ?>);">
		<?php else: ?>
			<div class="footer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/footer-img.jpg);">
		<?php endif; ?>

				<div class="uk-container uk-container-large">

					<div class="logo-block">

						<img src="<?= get_template_directory_uri() . '/assets/img/svg/logo-wctheme-white.svg' ?>" class="logo-block__img" alt="wctheme logo">
						<p class="uk-text-center logo-block__para">
						Luksusowa cukiernia specjalizująca się w ciastkach typu petit gateau, tortach i czekoladowych pralinach.
						</p>
					</div>

					<div class="uk-text-center" uk-grid>

						<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-3@m uk-width-2-5@l">
							<?php if ( has_nav_menu( 'footer-sitemap' ) ) : ?>
							<p class="footer__block-title"><?php _e( 'Mapa strony', 'wctheme' ); ?></p>
								<nav role="navigation" class="footer__menu footer__menu--sitemap">
									
									<?php wp_nav_menu(
										array(
											'container'  			=> '',
											'menu_id' 				=> 'footer-sitemap',
											'theme_location' 		=> 'footer-sitemap',
										)
									); ?>
								
								</nav>
							<?php endif; ?>

						</div>

						<div class="uk-width-1-1 uk-width-1-1@s uk-width-2-3@m uk-width-3-5@l mobile-nexted-grid-margin" uk-grid>

							<div class="uk-width-1-1 uk-width-1-2@s">
								<p class="footer__block-title"><?php _e( 'Lokalizacja', 'wctheme' ); ?></p>

								<?php if ( has_nav_menu( 'footer-locations' ) ) : ?>
									<nav role="navigation" class="footer__menu footer__menu--locations">
										
										<?php wp_nav_menu(
											array(
												'container'  			=> '',
												'menu_id' 				=> 'footer-locations',
												'theme_location' 		=> 'footer-locations',
											)
										); ?>
									
									</nav>
								<?php endif; ?>

							</div>

							<div class="uk-width-1-1 uk-width-1-2@s">

								<p class="footer__block-title"><?php _e( 'Kontakt', 'wctheme' ); ?></p>
								<div class="footer__company__contact">
									<?php the_field( 'footer__company-contact', 'options' ); ?>

									<?php if ( has_nav_menu( 'social' ) ) : ?>
										<nav role="navigation" class="footer__menu footer__menu--social">
											
											<?php wp_nav_menu(
												array(
													'container'  			=> '',
													'menu_id' 				=> 'social',
													'theme_location' 		=> 'social',
												)
											); ?>
										
										</nav>
									<?php endif; ?>
								</div>

							</div>

						</div>

					</div>

				</div>
			</div>
			
			<div class="uk-container uk-container-expand bottom-footer-color">
				<div class="uk-container uk-container-large">
					<div class="bottom-footer">
						<p>Design by 
							<a href="https://rockon.tech/" rel="noreferrer" target="_blank">rockon.tech</a>
						</p>
					
					</div>
				</div>
			</div>	
			
			<section class="animation__loader" style="display: none;">
				<div class="animation animation--seventh">  
			        <svg class="animation__blender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.62 122.42"><defs><style>.cls-1{fill:#58595b;}</style></defs><g id="Warstwa_2" data-name="Warstwa 2"><g id="Layer_1" data-name="Layer 1"><path class="cls-1" d="M24.61,0a3,3,0,0,0-3.06,2.92l-.11,41.47C17.82,49.16.08,73.61,0,94.2c0,10.89,2.27,18.37,7.06,22.88,5,4.73,11.8,5.34,17.15,5.34,5.86,0,10.22-.9,13.72-2.82a18.14,18.14,0,0,0,7.92-9c1.84-4.23,2.74-9.6,2.77-16.41.07-20.59-17.49-45-21.07-49.81l.1-41.48A3,3,0,0,0,24.61,0ZM26,116.24a3.2,3.2,0,0,1-1.6.34c-1.19,0-2.26-.2-3.33-2.73-1.48-3.51-2.21-10.12-2.18-19.65,0-13,3.25-28.12,5.72-37.87,2.4,9.75,5.5,24.9,5.46,37.88C30,101.57,29.44,114.22,26,116.24ZM7.13,94.2c0-10.27,5-22,9.88-31.2-2,9.31-3.93,20.79-4,31.2,0,9.78.68,16.46,2.23,20.86a10.63,10.63,0,0,1-3.15-2.14C8.73,109.56,7.1,103.44,7.13,94.2Zm34.61,0c-.05,16.17-5.46,19.3-7.24,20.33-.32.19-.67.36-1,.53,1.6-4.45,2.32-11.16,2.35-20.86C35.87,83.79,34,72.3,32.08,63,36.94,72.18,41.78,83.92,41.74,94.21Z"/></g></g></svg>

			        <svg class="animation__bowl" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 115 95.89"><defs><style>.cls-1{fill:#58595b;}</style></defs><g id="Warstwa_2" data-name="Warstwa 2"><g id="Layer_1" data-name="Layer 1"><path class="cls-1" d="M76,0V7h33V38.47a54.32,54.32,0,0,1-3.8,20.68,45.41,45.41,0,0,1-26.65,26,56.54,56.54,0,0,1-20.22,3.54,61.24,61.24,0,0,1-20.8-3.37,46.93,46.93,0,0,1-16.17-9.64A43.31,43.31,0,0,1,10.79,60.3,53.05,53.05,0,0,1,7,39.79V7H40V0H0V39.87A59.55,59.55,0,0,0,4.35,63.1,51.75,51.75,0,0,0,16.43,80.82,52.36,52.36,0,0,0,34.74,92a66.84,66.84,0,0,0,23.09,3.87,60.92,60.92,0,0,0,22.59-4.12A54.38,54.38,0,0,0,98.57,80.16,52.72,52.72,0,0,0,110.64,62,61.21,61.21,0,0,0,115,38.55V0Z"/></g></g></svg>
			    </div> 
			</section>

		</footer>
		<?php wp_footer(); ?>

	</body>
</html>