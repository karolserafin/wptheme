<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wctheme
 */

get_header(); ?>

	<header class="page__header page-banner" style="background: transparent url('<?php the_field( 'search__background', 'options' ); ?>') no-repeat center center; background-size: cover;">

		<div class="uk-container uk-container-large banner-100">
		
			<p class="search-result"><?php printf( __( 'Wyniki<br>wyszukiwania dla: %s', 'wctheme' ), '<span>' . get_search_query() . '</span>' ); ?></p>

		</div>

	</header>

	<?php

		$exclude 	= exclude_products_from_query();
		$args 		= array(
			'posts_per_page' 	=> -1,
			'post_type' 		=> array( 'product' ),
			'post__not_in' 		=> $exclude,
			'tax_query' 		=> array(
				array(
					'taxonomy' 					=> 'product_visibility',
                    'field' 					=> 'term_taxonomy_id',
                    'terms' 					=> array(7),
                    'operator' 					=> 'NOT IN',
				),
			),
			's' 				=> get_search_query()
		);


		$exclude_cats  = get_field( 'disabled_categories', 'options' );

		if ( !empty( $exclude_cats ) ) {
			foreach( $exclude_cats as $term ) {
		        $exclude_cats_array[] = $term->slug;
		    }

		    $args['tax_query']['relation'] 	= 'AND';
		    $args['tax_query'][]    		= array(
		        'taxonomy'     => 'product_cat',
		        'field'        => 'slug',
		        'terms'        => $exclude_cats_array,
		        'operator'     => 'NOT IN'
		    );

		}

		$products 	= new WP_Query( $args );

		$args 		= array(
			'posts_per_page' 	=> -1,
			'post_type' 		=> array( 'post' ),
			's' 				=> get_search_query()
		);
		$posts 		= new WP_Query( $args );

	?>

	<section class="search-results">

		<div class="uk-container uk-container-large">

			<?php if ( $products->have_posts() ) : ?>

				<h2 class="search-results__title "><?php _e( 'Sklep', 'wctheme' ); ?></h2>
				
				<div class="search-results__container">

					<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-3@l uk-child-width-1-4@xl" uk-grid>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php get_template_part( '/template-parts/product/card' ); ?>
						<?php wp_reset_postdata(); ?>

					<?php endwhile; ?>

					</div>
				</div>
			
			<?php endif; ?>

			<?php if ( $posts->have_posts() ) : ?>

				<h2 class="search-results__title "><?php _e( 'Aktualności', 'wctheme' ); ?></h2>	

				<div class="search-results__container">	

					<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-3@l uk-child-width-1-3@xl" uk-grid>

						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<?php get_template_part( '/template-parts/article/card' ); ?>
							<?php wp_reset_postdata(); ?>

						<?php endwhile; ?>

					</div>

				</div>	
					
			<?php endif; ?>

			<?php if ( !$products->have_posts() && !$posts->have_posts() ) : ?>

				<h2><?php _e( 'Brak wyników wyszukiwania', 'wctheme' ); ?></h2>
				<br>
				<br>

			<?php endif; ?>


		</div>

	</section>

<?php get_footer();
