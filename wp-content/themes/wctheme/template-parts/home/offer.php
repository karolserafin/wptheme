<section class="section section__cooperates">
	
	<div class="cooperates__content">

		<div class="uk-container uk-container-large">
			<h2 class="uk-heading-line uk-text-center section-title"><?php the_field( 'offer__title' ); ?></h2>

			<?php if ( get_field( 'offer' ) ) : ?>

				<ul class="offer__list" uk-grid="parallax: 100">

					<?php while ( the_repeater_field( 'offer' ) ) : ?>

						<li class="single-offer uk-width-1-1 uk-width-1-1@s uk-width-1-1@m uk-width-1-2@l uk-width-1-2@xl" >

							<div class="single-offer__container" style="background: transparent url('<?php echo get_sub_field( 'background' ) ?>') no-repeat center center; background-size: cover;">

								<h3><?php the_sub_field( 'title' ); ?></h3>
								<p><?php the_sub_field( 'content' ); ?></p>
								<a class="product-extra-info__link button button--empty" href="<?php echo get_the_permalink( get_sub_field( 'button__link' ) ); ?>"><?php the_sub_field( 'button__content' ); ?></a>
							
							</div>

							
						</li>
						
					<?php endwhile; ?>

				</ul>

			<?php endif; ?>

		</div>
	</div>

</section>