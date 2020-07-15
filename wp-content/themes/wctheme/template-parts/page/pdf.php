<?php if ( get_field('pdf__title') || get_field('pdf__description') ): ?>
<section class="section section__pdf uk-container uk-container-large">

	<div class="pdf__content">

		<h2><?php the_field( 'pdf__title' ); ?></h2>

		<p><?php the_field( 'pdf__description' ); ?></p>
		
		<?php if ( get_field( 'pdf__file__url' ) ): ?>
		<a href="<?php echo get_field( 'pdf__file__url' ); ?>">
			<?php the_field( 'pdf__button__content' ); ?>
		</a>
		<?php endif; ?>
			
	</div>

</section>
<?php endif; ?>