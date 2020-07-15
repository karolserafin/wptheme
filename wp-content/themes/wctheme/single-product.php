<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

$excludes = exclude_products_from_query();

if ( in_array( get_the_ID(), $excludes ) ) {
	wp_safe_redirect( get_permalink( wc_get_page_id( 'shop' ) ) );
	wc_add_notice( __( 'Ten produkt nie jest dostepny w sprzedazy', 'wctheme' ), 'error' );
	exit;
}

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php $post_id = get_the_ID(); ?>
		<?php get_template_part( '/template-parts/shop/banner' ); ?>

		<div class="single-product-wrapper uk-container uk-container-large">

			<div class="add-to-favorite-container">

				<span class="favourites favourites-containet-product hide-desktop" data-id="<?php echo get_the_ID(); ?>">

					<div class="empty-heart<?php if ( in_array( get_the_ID(), wctheme_get_user_favourites_products() ) ) : ?> full-heart<?php endif; ?>">
					</div>
						
					<p>
						<?php _e( 'Dodaj do ulubionych', 'wctheme' ); ?>
					</p>
												
				</span>
				
			</div>

			<section class="article__content">
				<?php the_content(); ?>
			</section>

			<div class="clearfix"></div>			

			<?php get_template_part( '/template-parts/product/complementary' ); ?>
			<?php get_template_part( '/template-parts/product/related' ); ?>
			<?php get_template_part( '/template-parts/product/cakes-instructions' ); ?>

		</div>
		
	<?php endwhile; ?>

<?php get_footer();
