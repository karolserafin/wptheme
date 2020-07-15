<?php 
/**
 *	Template Name: Aktualności
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php get_template_part( '/template-parts/page/header' ); ?>

	<?php endwhile; wp_reset_postdata(); ?>

	<?php
		$paged 	= get_query_var('paged') ? get_query_var('paged') : 1;
		$args 	= array(
			'paged' 				=> $paged,
			'posts_per_page' 		=> 12,
			'post_type' 			=> array( 'post' ),
		);

		$query 	= new WP_Query( $args );

	?>

	<section class="articles">

		<div class="uk-container uk-container-large">

		<div uk-grid>

			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

			<?php get_template_part( '/template-parts/article/card-list' ); ?>
			<?php wp_reset_postdata(); ?>

			<?php endwhile; ?>

		</div>

				<?php 
				/**
				 *	Strzałki w nawigacji są edytoane - można je zmienić za pomoca tłumaczeń w CMS'ie lub poprzez zmianę w funkcji 'wctheme_articles_pagination'
				*
				*/
				wctheme_articles_pagination( $paged, $query->max_num_pages ); 
				?>

		
		</div>



	</section>

	<?php get_template_part( '/template-parts/page/promo' ); ?>

<?php get_footer();