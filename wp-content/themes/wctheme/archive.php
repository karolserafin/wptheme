<?php 
/**
 *
 *
 * @package wctheme
 * @since wctheme 1.0
 */
global $wp_query;

$wp_query->set( 'posts_per_page', 11 );

get_header(); ?>

	<!-- tutaj dodać header odpowiedni dla archiwum -->
	<?php get_template_part( '/template-parts/blog/archive-header' ); ?>
	
	<?php $paged 	= get_query_var('paged') ? get_query_var('paged') : 1; ?>

	<section class="articles">

		<div class="uk-container uk-container-large">

		<div uk-grid>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( '/template-parts/article/card-list' ); ?>
			<?php wp_reset_postdata(); ?>

		<?php endwhile; ?>

		</div>
		<?php 
			/**
			 *	Strzałki w nawigacji są edytoane - można je zmienić za pomoca tłumaczeń w CMS'ie lub poprzez zmianę w funkcji 'wctheme_articles_pagination'
			 *
			 */
			wctheme_articles_pagination( $paged, $wp_query->max_num_pages ); 
		?>

		
		<div class="archive-articles-info">

			<p class="product-extra-info__para"><?php _e( 'Aktualnie przeglądasz archiwum. Możesz w każdej chwili wrócić do aktualności.', 'wctheme' ); ?></p>
			<a class="button button--empty" href="<?php echo get_blog_base_url(); ?>"><?php _e( 'Wróć do aktualności', 'wctheme' ); ?></a>

		</div>

		</div>

	

	</section>

	<?php get_template_part( '/template-parts/page/promo' ); ?>

<?php get_footer();