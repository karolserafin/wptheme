<?php 
/**
 *	Produkty uzupełniające
 *	Lista produktów uzupełniających - z oferty sezonowej itp
 *
 */
$complementary_products 	= get_field( 'complementary__products' ); ?>

<?php if ( ! empty( $complementary_products ) ) : ?>

	<section class="complementary__porducts uk-container uk-container-expand-left">

		<h2 class="complementary-title"><?php _e( 'Dodatki do tortów:', 'wctheme' ); ?></h2>

		<div class="products__list">

		<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-4@xl" uk-grid>

				<?php foreach( $complementary_products as $complementary ) : ?>

					<?php
						$post = get_post( $complementary, OBJECT );
						setup_postdata( $post );
						get_template_part( '/template-parts/product/card' );
						wp_reset_postdata();
					?>

				<?php endforeach; ?>

			</div>
		</div>

	</section>

<?php endif; ?>