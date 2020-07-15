<article class="product product-card">

	<?php $wc_product = new WC_Product( get_the_ID() ); ?>

	<span class="inner__wrapper">

		<div class="product-hover-box">

			<div class="product__labels-wrapper">
				<?php do_action( 'woocommerce_product_card_labels' ); ?>
			</div>

			<img class="product-card__img" src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'wctheme-product-thumbnail' ); ?>" alt="<?php the_title(); ?>"/>

			<?php
				$_product 	= wc_get_product( get_the_ID() );
				$link 		= get_the_permalink();
				if ( $_product->is_type( 'simple' ) && ! get_field( 'subproducts', get_the_ID() ) && ! get_field( 'complementary__product', get_the_ID() ) ) {
					$link = '?add-to-cart=' . get_the_ID();
				}
			?>

			<a href="<?php echo $link; ?>" class="full-product product__functional-button product__functional-button--cart" data-id="<?php echo get_the_ID(); ?>"><?php _e( '', 'wctheme' ); ?>
				<div>
					<svg width="27" height="24" viewBox="0 0 27 24" xmlns="http://www.w3.org/2000/svg">
						<g fill="none" fill-rule="evenodd">
							<g>
							<g>
								<g>
								<g fill-rule="nonzero">
									<g fill="#000">
									<path d="M11.01 17.133h11.75c.29 0 .544-.173.623-.425l2.592-8.213a.543.543 0 00-.106-.515.673.673 0 00-.517-.233H9.516l-.463-1.888c-.066-.268-.33-.459-.633-.459H4.533c-.358 0-.648.263-.648.587 0 .324.29.586.648.586H7.9l2.34 9.532c-.689.271-1.172.893-1.172 1.615 0 .97.872 1.76 1.944 1.76H22.76c.358 0 .648-.263.648-.587 0-.324-.29-.586-.648-.586H11.012c-.358 0-.648-.264-.648-.587 0-.323.29-.586.646-.587zM24.493 8.92l-2.221 7.04h-10.74L9.803 8.92h14.69z"/>
									<path d="M10.364 21.24c0 .97.872 1.76 1.943 1.76 1.072 0 1.944-.79 1.944-1.76s-.872-1.76-1.944-1.76c-1.071 0-1.943.79-1.943 1.76zm1.943-.587c.358 0 .648.264.648.587 0 .323-.29.587-.648.587-.357 0-.647-.264-.647-.587 0-.323.29-.587.647-.587z"/>
									<path d="M19.52 21.24c0 .97.873 1.76 1.945 1.76 1.071 0 1.943-.79 1.943-1.76s-.872-1.76-1.943-1.76c-1.072 0-1.944.79-1.944 1.76zm1.945-.587c.357 0 .648.264.648.587 0 .323-.291.587-.648.587-.358 0-.648-.264-.648-.587 0-.323.29-.587.648-.587z"/>
									</g>
									<g>
									<path d="M8.2 1C4.23 1 1 3.956 1 7.59c0 3.633 3.23 6.59 7.2 6.59s7.2-2.957 7.2-6.59C15.4 3.956 12.17 1 8.2 1z" stroke="#BF883B" fill="#BF883B"/>
									<path fill="#FFF" d="M8.65 4.295h-.9v2.883H4.6V8h3.15v2.883h.9V8.001h3.15v-.823H8.65z"/>
									</g>
								</g>
								</g>
							</g>
							</g>
						</g>
					</svg>
				</div>
			</a>

			<div class="product-hover">
				<?php $short_description = get_field( 'product__extra-info' ) ?>
				<div class="product__overlay <?php if ( $short_description ) : ?>product__overlay--full<?php endif; ?>">

					<?php if ( $short_description ) : ?>
						
						<div class="product__ekstra-info">
							<?php echo $short_description ?>
						</div>

					<?php endif; ?>				

					<div class="product__functional-buttons">
						
						<span class="favourites product__functional-button <?php if ( in_array( get_the_ID(), wctheme_get_user_favourites_products() ) ) : ?> favourites-added<?php endif; ?>" data-id="<?php echo get_the_ID(); ?>">
							
							<div class="empty-heart<?php if ( in_array( get_the_ID(), wctheme_get_user_favourites_products() ) ) : ?> full-heart<?php endif; ?>">
							</div>
							
						</span>

						<a href="<?php the_permalink(); ?>" class="add-cart product__functional-button" data-id="<?php echo get_the_ID(); ?>">
							<div>
								<svg width="25" height="16" viewBox="0 0 25 16" xmlns="http://www.w3.org/2000/svg">
								<g fill="none" fill-rule="evenodd">
									<g fill="#BF883B" fill-rule="nonzero" stroke="#BF883B">
									<g>
										<g>
										<path d="M23.86 7.69l-7.188-6.562a.512.512 0 00-.677 0 .411.411 0 000 .619l6.37 5.816H1.478C1.214 7.563 1 7.758 1 8s.214.438.48.438h20.884l-6.37 5.815a.411.411 0 000 .619.502.502 0 00.34.128.502.502 0 00.338-.128l7.188-6.563a.411.411 0 000-.618z"/>
										</g>
									</g>
									</g>
								</g>
								</svg>
							</div>
						</a>
					
					</div>

				</div>
			</div>

		</div>

		<h4 class="product-card__title"><?php the_title(); ?></h4>
	
		<?php if ( $wc_product->is_type( 'variable' ) ) :

			$regular_price 		= $wc_product->is_type('variable') ? $wc_product->get_variation_regular_price( 'min', true ) : $wc_product->get_regular_price();
			$sale_price 		= $wc_product->is_type('variable') ? $wc_product->get_variation_sale_price( 'min', true ) : $wc_product->get_sale_price();

			if ( $sale_price == $regular_price ) : ?>
				
				<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'product-card__price' ) ); ?>"><?php echo wc_price( $sale_price ) ?></p>

				<?php else: ?>

					<p class="product-card__price">
						<del>
							<?php echo wc_price( $regular_price ); ?>
						</del>
						<ins>
							<?php echo wc_price( $sale_price ); ?>
						</ins>
					</p>

				<?php endif;

			else: ?>

				<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'product-card__price' ) ); ?>"><?php echo $wc_product->get_price_html(); ?></p>

		<?php endif; ?>
		
	</span>

</article>
