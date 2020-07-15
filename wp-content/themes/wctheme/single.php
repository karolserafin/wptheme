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

			<?php get_template_part( '/template-parts/article/header' ); ?>

		<section class="article__content article__content-single">
	
			<?php get_template_part( '/template-parts/article/editor' ); ?>

		</section>

		<section class="article__navigation">
			<div class="uk-container">

				<div class="article-footer">
					
					<div class="fb__share" data-url="<?php echo get_permalink(); ?>" data-title="<?php echo get_the_title(); ?>" data-description="<?php echo get_the_excerpt(); ?>">
						<a href="#0" class="button social-button">
	                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/facebook-icon.svg' ?>"
	                             alt="facebook"/>
	                        <?php _e( 'Udostępnij na facebooku', 'wctheme' ); ?>
	                    </a>
					</div>

					<div class="blog-pragination">
						<?php previous_post_link( '%link', __( 'Poprzedni wpis', 'wctheme' ) ); ?>
						<?php next_post_link( '%link', __( 'Następny wpis', 'wctheme' ) ); ?>
					</div>
				</div>


			</div>	
		</section>

		<?php get_template_part( '/template-parts/page/promo' ); ?>

	<?php endwhile; ?>

<?php get_footer();
