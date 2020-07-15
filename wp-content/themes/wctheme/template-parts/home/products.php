<?php

	$parent 			= get_the_ID();
	$page_products 		= get_field( 'products' );
	$exclude 			= exclude_products_from_query();
	$products 			= array();

	foreach( $page_products as $product ) {
		if ( ! in_array( $product, $exclude ) ) {
			$products[] = $product;
		}
	}

	$args 	= array(
		'posts_per_page' 		=> -1,
		'post_type' 			=> array( 'product' ),
		'post__in' 				=> $products,
	);

	$query 	= new WP_Query( $args );

?>

<?php if ( $products ) : ?>

	<section class="articles product-list">

		<div class="uk-container uk-container-large">
			<h3 class="uk-heading-line uk-text-center section-title"><?php echo get_field( 'products__title' ) ?></h3>

			<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-3@l uk-child-width-1-4@xl" uk-grid>

			<?php while ( $query->have_posts() ) : $query->the_post(); ?>


				<?php get_template_part( '/template-parts/product/card' ); ?>
				<?php wp_reset_postdata(); ?>

			<?php endwhile; ?>

			<div class="uk-width-1-1 product-extra-info">
				<p class="product-extra-info__para"><?php echo get_field( 'products__content' ) ?></p>
				<a class="product-extra-info__link button button--empty" href="<?php echo get_field( 'products__button__link' ) ?>"><?php echo get_field( 'products__button__content' ) ?></a>
			</div>

			</div>

	

		
		</div>

	</section>

<?php endif; ?>