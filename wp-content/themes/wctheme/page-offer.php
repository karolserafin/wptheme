<?php 
/**
 *	Template Name: Oferta
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php get_template_part( '/template-parts/page/header' ); ?>

		<section class="page__content">

			<?php get_template_part( '/template-parts/page/categories' ); ?>
			<?php get_template_part( '/template-parts/page/pdf' ); ?>
			<?php get_template_part( '/template-parts/page/cooperate' ); ?>
			<?php get_template_part( '/template-parts/page/workshops' ); ?>
			<?php get_template_part( '/template-parts/page/logotypes' ); ?>
			<?php get_template_part( '/template-parts/page/gallery' ); ?>

		</section>

		<?php get_template_part( '/template-parts/page/promo' ); ?>

	<?php endwhile; wp_reset_query(); ?>

<?php get_footer();