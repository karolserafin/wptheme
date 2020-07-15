<?php 
/**
 *	Template Name: Ulubione
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>
	
	<div class="custom__alerts">
		<div class="woocommerce">
			<div class="uk-container uk-container-large">
				<?php wc_print_notices(); ?>			
			</div>
		</div>
	</div>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php get_template_part( '/template-parts/page/header' ); ?>

	<?php endwhile; ?>

	<?php
		$favourites		= wctheme_get_user_favourites_products();
		$paged 			= get_query_var('paged') ? get_query_var('paged') : 1;
		$get_category 	= isset( $_GET['category'] ) ? $_GET['category'] : array();
		$args 			= array(
			'paged' 				=> $paged,
			'orderby' 				=> 'menu_order',
			'posts_per_page' 		=> 12,
			'post__in' 				=> $favourites,
			'post_type' 			=> array( 'product' ),
		);

		if ( !empty( $get_category ) ) {
            $args['tax_query'][]    = array(
                'taxonomy'     			=> 'product_cat',
                'field'        			=> 'slug',
                'terms'        			=> $get_category,
                'operator'     			=> 'IN'
            );
        }

		$query 	= new WP_Query( $args );

	?>

	<section class="articles">

		<form action="" metohd="GET">

			<div class="uk-container uk-container-large">

				<div class="add-to-favorite-container uk-hidden">
					<a href="#" class="add-favorite add-favorite--full">Dodaj do ulubione do koszyka</a>
				</div>
			
				<div uk-grid>

					<div class="shop__sidebar uk-width-1-1 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-5@xl">

						<h3 class="carmel-color"><?php echo __( 'Kategorie:', 'wctheme' ); ?></h3>
						<?php $categories 	= wctheme_categories_filter(); ?>
						<?php $checked 	 	= wctheme_get_current_category_slug(); ?>

						<ul class="sidebar__products_category_filter filter-desktop">
							<li>
								<label>
									<input type="checkbox" class="uk-checkbox" value="all" <?php if ( ! $checked ) : ?>checked<?php endif; ?>>
									<?php echo __( 'Wszystkie', 'wctheme' ); ?>
								</label>
							</li>
							<?php foreach( $categories as $category ): ?>
								<li>
									<label>
										<input type="checkbox" class="uk-checkbox" name="category" id="<?php echo $category->slug; ?>" value="<?php echo $category->slug; ?>" <?php if ( $checked == $category->slug ) : ?>checked<?php endif; ?> >
										<?php echo $category->name; ?>
									</label>
								</li>
							<?php endforeach; ?>
						</ul>

						<div uk-slider class="filter-desktop-mobile">
							<ul class="sidebar__products_category_filter uk-slider-items">
								<li>
									<label>
										<input type="checkbox" class="uk-checkbox" value="all" <?php if ( ! $checked ) : ?>checked<?php endif; ?>>
										<?php echo __( 'Wszystkie', 'wctheme' ); ?>
									</label>
								</li>
								<?php 
								?>
								<?php foreach( $categories as $category ): ?>
									<li>
										<label for="<?php echo $category->slug; ?>" class="<?php if ( $category->slug == $get_category ) : ?>label-selected<?php endif; ?>">
											<?php echo $category->name; ?>
										</label>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>

						<p class="clear-all-category">
							<a href="#" class="clear-all-category--link"><?php echo __( 'Wyczyść wszystko', 'wctheme' ); ?></a>	
						</p>
					</div>

					<div class="uk-width-1-1 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l uk-width-4-5@xl">
						<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-3@l uk-child-width-1-4@xl" uk-grid>
								<?php if ( !empty( $favourites ) && $query->have_posts() ) : ?>

									<?php while ( $query->have_posts() ) : $query->the_post(); ?>

										<?php get_template_part( '/template-parts/product/card' ); ?>

										<?php wp_reset_postdata(); ?>

									<?php endwhile; ?>

									<?php 
										/**
										 *	Strzałki w nawigacji są edytoane - można je zmienić za pomoca tłumaczeń w CMS'ie lub poprzez zmianę w funkcji 'wctheme_articles_pagination'
										*
										*/
										wctheme_articles_pagination( $paged, $query->max_num_pages ); 
									?>

								<?php else: ?>
									<div class="no-favorite-product-container">
										<?php if ( !empty( $get_category ) ) : ?>
											<p class="no-favorite-products"><?php _e( 'Brak produktów spełniających te kryteria.', 'wctheme' ) ?></p>
										<?php else: ?>
											<p class="no-favorite-products"><?php _e( 'Nie dodałeś jeszcze swoich ulubionych produktów.', 'wctheme' ) ?></p>
										<?php endif; ?>
										<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="button button--empty"><?php echo __( 'Zobacz sklep', 'wctheme' ); ?></a>
									</div>				
								<?php endif; ?>
							</div>
						
						</div>
					</div>

				</div>

			</div>

		</form>

		<script type="text/javascript">
			jQuery(function($){
				var check = $('.sidebar__products_category_filter input').on('change', function(){
					$('form').submit();
				});
			});
		</script>

	</section>

	<?php get_template_part( '/template-parts/page/promo' ); ?>

<?php get_footer();