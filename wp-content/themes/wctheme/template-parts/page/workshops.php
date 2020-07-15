<?php if ( get_field('workshops__title') || get_field('workshops__content') ): ?>
<section class="section section__workshops uk-container uk-container-large">
	
	<div class="workshops__content">

		<h2><?php the_field( 'workshops__title' ); ?></h2>
		<?php the_field( 'workshops__content' ); ?>
		
		<?php if (get_field( 'workshops__button__link' )): ?>
		<a href="<?php echo get_the_permalink( get_field( 'workshops__button__link' ) ); ?>">
			<?php the_field( 'workshops__button__content' ); ?>
		</a>
		<?php endif; ?>

	</div>

</section>
<?php endif; ?>