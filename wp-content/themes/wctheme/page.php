<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php if ( is_shop() || is_product_category() ) : ?>

			<?php get_template_part( '/template-parts/shop/shop' ); ?>

		<?php else: ?>
		
			<?php get_template_part( '/template-parts/page/page' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

<?php get_footer();
