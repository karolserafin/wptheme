<section class="section section__instagram">
	
	<div class="uk-container uk-container-large">

		<div uk-grid class="mobie-grid-revert">
			
			<div class="content__description uk-width-1-1@s uk-width-1-3@m uk-width-2-5@l uk-width-1-3@xl">
				
				<?php if ( get_field('instagram__title', 'options') ): ?>
					<h2><?php the_field( 'instagram__title', 'options' ); ?></h2>
				<?php endif; ?>
				
				<?php if ( get_field('instagram__description', 'options') ): ?>
					<p><?php the_field( 'instagram__description', 'options' ); ?></p>
				<?php endif; ?>
				
				<?php if ( get_field('instagram__button__content', 'options') ): ?>
					<a href="<?php the_field( 'instagram__link', 'options' ); ?>"><?php the_field( 'instagram__button__content', 'options' ); ?></a>
				<?php endif; ?>

			</div>		
			
			<?php if ( get_field('instagram__gallery', 'options') ): ?>
			<div class="content__gallery uk-width-1-1@s uk-width-2-3@m uk-width-3-5@l uk-width-2-3@xl">
				<?php echo do_shortcode( get_field( 'instagram__gallery', 'options' ) ); ?>
			</div>
			<?php endif; ?>
		
		</div>

	</div>

</section>