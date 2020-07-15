<?php 
/**
 *	Template Name: Kontakt
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php get_template_part( '/template-parts/page/header' ); ?>
		<?php get_template_part( '/template-parts/page/map' ); ?>
		
		<section class="page__content page-contact">

			<div class="uk-container">

				<div uk-grid class="form__contact__wrapper" style="position: relative;">

					<div class="uk-width-1-1 uk-width-1-1@s uk-width-2-3@m uk-width-2-3@l uk-width-2-32x3">
						<?php get_template_part( '/template-parts/form/contact' ); ?>
					</div>

					<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-3@m uk-width-1-3@l uk-width-1-3@xl custom-flex-position">
						<?php get_template_part( '/template-parts/page/contact-details' ); ?>
					</div>

				</div>

			</div>

			<?php get_template_part( '/template-parts/home/instagram' ); ?>
			<?php get_template_part( '/template-parts/page/promo' ); ?>

		</section>

	<?php endwhile; ?>

<?php get_footer();