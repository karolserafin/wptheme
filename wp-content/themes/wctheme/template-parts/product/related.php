<?php 
/**
 *	Powiązane produkty
 *	Lista produktów - z tej samej kategorii co produkt aktualnie oglądany
 *
 */

$id 					= get_the_ID();
$terms 					= wp_get_post_terms( $id, 'product_cat', array( 'fields' => 'ids' ) );
$category 				= get_term( $terms[0], 'product_cat' );
$not_in 				= array();

$not_in[] 				= $id;

$args 					= array(
	'post_type' 			=> 'product',
	'posts_per_page' 		=> 4,
	'post__not_in' 			=> $not_in,
	'tax_query' => array(
    	array(
    		'taxonomy' 		=> 'product_cat',
    		'field' 		=> 'term_id',
    		'terms' 		=> $category->term_id
     	),
     	array(
	        'taxonomy' 		=> 'product_visibility',
	        'field'    		=> 'name',
	        'terms'    		=> 'exclude-from-catalog',
	        'operator' 		=> 'NOT IN',
	    ),
  	)
);

$related_products 		= new WP_Query( $args );
?>

<?php if ( $related_products->have_posts() ) : ?>

	<section class="complementary__porducts uk-container uk-container-expand-left">

		<?php if ( isset( $category ) ) : ?>
			<h2 classclass="complementary-title"><?php echo sprintf( __( 'Inne w kategorii %s:', 'wctheme' ), $category->name ); ?></h2>
		<?php endif; ?>

		<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-4@xl" uk-grid>

			<?php while ( $related_products->have_posts() ) : $related_products->the_post(); ?>

				<div>
					<div class="uk-card">
						<?php
							get_template_part( '/template-parts/product/card' );
						?>
					</div>
				</div>

			<?php endwhile; ?>

		</div>

	</section>

<?php endif; ?>