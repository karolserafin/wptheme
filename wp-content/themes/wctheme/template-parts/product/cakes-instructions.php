<?php
	global $post;

	$instruction__steps 	= get_field( 'instruction__steps', get_the_ID() );
	$instruction__heading	= get_field( 'instructions__title', get_the_ID() );

	if ( ! empty( $instruction__steps ) && $instruction__heading ) :

?>

<section class="order-instructions">

	<div class="order-instructions__container">
		<p class="order-instructions__title"><?php echo $instruction__heading; ?></p>

		<ol class="order-instructions__steps">

			<?php while ( the_repeater_field( 'instruction__steps' ) ) : ?>
				<li><?php echo get_sub_field( 'step' ); ?></li>
			<?php endwhile; ?>
			
		</ol>
	</div>

</section>

<?php endif; ?>