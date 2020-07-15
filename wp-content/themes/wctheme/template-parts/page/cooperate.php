<?php if ( get_field('cooperate__title') || get_field('cooperate__content') ): ?>
<section class="section section__cooperates uk-container uk-container-large">
	
	<div class="cooperates__content">

		<h2><?php the_field( 'cooperate__title' ); ?></h2>
		<?php the_field( 'cooperate__content' ); ?>
		
		<?php if ( get_field( 'cooperate__button__link' ) ): ?>
			<a href="<?php echo get_the_permalink( get_field( 'cooperate__button__link' ) ); ?>">
				<?php the_field( 'cooperate__button__content' ); ?>					
		</a>
		<?php endif; ?>

	</div>

</section>
<?php endif; ?>