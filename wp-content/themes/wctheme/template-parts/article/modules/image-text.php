<div class="content content__image-text">

	<?php if ( get_sub_field('module__image-text__position') ) : ?>

		<div class="uk-container">

		<div uk-grid>
			<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
				<img class="text-img" src="<?php echo get_sub_field( 'module__image-text__image' ); ?>" />
			</div>

			<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
				<?php echo get_sub_field( 'module__image-text__content' ); ?>
			</div>
		</div>

		</div>



	<?php else: ?>

		<div class="uk-container">
			<div uk-grid>
				<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
					<?php echo get_sub_field( 'module__image-text__content' ); ?>
				</div>

				<div class="uk-width-1-1 uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
					<img class="text-img" src="<?php echo get_sub_field( 'module__image-text__image' ); ?>" />
				</div>
			</div>

		</div>


	<?php endif; ?>

</div>