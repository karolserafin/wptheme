<section class="section section__banner uk-position-relative">
	<?php if ( get_field( 'banner' ) ) : ?>


		<div uk-slideshow="animation: push; autoplay: true; autoplay-interval: 4000; ratio: 7:3; max-height: 700">
	
				<div class="uk-slideshow-items">
					<?php while ( the_repeater_field( 'banner' ) ) : ?>

					<div class="banner__front" style="background: transparent url('<?php echo get_sub_field( 'background' ) ?>') no-repeat center center; background-size: cover;">

						<div class="uk-container uk-container-large width-100">

							<div uk-grid>

								<div class="uk-width-1-1 uk-width-2-3@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
	
											<ul class="banner__list">
												
													<li class="slide">

														<?php 

															$labels 	= get_sub_field( 'label' );
															$return 	= '<div class="banner__labels">';

															if ( $labels ) {
																foreach( $labels as $label ) {
																	echo '<div class="banner__label" uk-slider-parallax="x: 100,-100" style="background-color:'.get_field( 'color', $label ).'">'.get_the_title( $label ) .'</div>';
																}
															}

														?>

														<h3><?php the_sub_field( 'title' ); ?></h3>
														<p><?php the_sub_field( 'content' ); ?></p>
														<a class="button button--empty button--white" href="<?php the_sub_field( 'button__link' ); ?>"><?php the_sub_field( 'button__content' ); ?></a>
					
													</li>	

																										

											</ul>
																	
								</div>

							</div>

						</div>

			
					</div>

					<?php endwhile; ?>
			

				</div>
				
				<ul class="uk-slideshow-nav uk-dotnav posts-nav"></ul>
	
		</div>


	<?php endif; ?>
</section>

