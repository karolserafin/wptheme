<?php
/**
 * The template for displaying single posts and pages.
 *
 * Template Name: Content 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php get_template_part( '/template-parts/page/header' ); ?>
		<?php get_template_part( '/template-parts/page/page' ); ?>

	<?php endwhile; ?>

<?php get_footer();
