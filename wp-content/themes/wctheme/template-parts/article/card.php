<article class="article article__card">

	<div class="rounded-corrners" <?php if ( get_field( 'image' ) ) : ?>style="background: transparent url('<?php echo get_field( 'image' ); ?>') no-repeat center center; background-size: cover;"<?php endif; ?>>
	<div class="article-card-miniature">

		<a href="<?php echo get_month_link( get_the_time('Y'), get_the_time('m') ); ?>" title="<?php  _e( 'Przejdź do archiwum', 'wctheme' ) ?>">
			<time><?php the_date( 'j F Y' ); ?></time>
		</a>

		<h4><?php the_title(); ?></h4>

		<?php the_excerpt(); ?>

		<?php if ( get_field( 'is_product' ) ) : ?>
			<a href="<?php echo get_permalink( get_field( 'product' ) ); ?>" title="<?php the_title(); ?>"><?php _e( 'Zobacz produkt', 'wctheme' ) ?></a>
		<?php else: ?>
			<a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php  _e( 'Czytaj dalej', 'wctheme' ) ?></a>
		<?php endif; ?>
		
	</div>
	
</article>