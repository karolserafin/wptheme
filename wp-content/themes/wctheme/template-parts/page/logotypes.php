<section class="section section__logotypes uk-container uk-container-large">
	
	<div class="logotypes__content">
		
		<?php if ( get_field('logotypes__title') ): ?>
		<h3 class="section__headline"><span><?php the_field('logotypes__title'); ?></span></h3>
		<?php endif; ?>

		<?php if ( get_field( 'logotypes' ) ) : ?>
		
		<?php 
			$index		= 1; 
    		$totalNum 	= count( get_field( 'logotypes' ) ); 
    	?>

		<div class="logotypes__desktop">
			<ul class="logotypes__list logotypes__list--desktop">
				<?php while ( the_repeater_field( 'logotypes' ) ) : ?>
					<li class="logotype">
						<img src="<?php echo get_sub_field( 'logotype__image' ) ?>" />
					</li>				
				<?php endwhile; wp_reset_query(); ?>
			</ul>			
		</div>
		<div class="logotypes__mobile">
			<div uk-slideshow>
				<div class="logotypes__list logotypes__list--mobile uk-slideshow-items">					
					<div class="logotypes__list__item">
					<?php while ( the_repeater_field( 'logotypes' ) ) : ?>
						
						<div class="logotype">
							<img src="<?php echo get_sub_field( 'logotype__image' ) ?>" />
						</div>	

						<?php if ( $index % 6 == 0 ): ?>
							<?php if ( $index < $totalNum ): ?>
							</div>
							<div class="logotypes__list__item">
							<?php elseif ( $index < $totalNum ): ?>
							</div>
							<?php endif; ?>
						<?php endif; ?>

					<?php $index++; endwhile; wp_reset_query(); ?>
				</div>
			</div>			
			<ul class="uk-slideshow-nav uk-dotnav"></ul>
		</div>
		<?php endif; ?>

	</div>

</section>
