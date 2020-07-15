<section class="section section__promo" style="background: transparent url('<?php echo get_field( 'promo_image', 'options' ); ?>') no-repeat center center;">

	<div class="promo">
		<div class="uk-container uk-container-large">

			<div uk-grid>

				<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@l uk-width-1-2@xl"></div>

				<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
					<h3 class="promo__title"><?php the_field( 'promo__title', 'options' ); ?></h3>
					<p class="promo__content"><?php the_field( 'promo__content', 'options' ); ?></p>
					<a class="promo__link" href="<?php the_field( 'promo__link', 'options' ); ?>">
						<?php the_field( 'promo__link__content', 'options' ); ?>
					</a>
				</div>

			</div>

		</div>
	</div>


</section>
