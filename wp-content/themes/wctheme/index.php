<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( ! is_front_page() ) : ?>
			<?php get_template_part( '/template-parts/article/header' ); ?>
		<?php endif; ?>

		<section class="article__content">
			<?php the_content(); ?>
		</section>

	<?php endwhile; ?>

<?php get_footer();
