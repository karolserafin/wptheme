<header class="page__header page-banner" style="background: transparent url('<?php echo get_the_post_thumbnail_url( get_the_ID(), 'wctheme-fullscreen' ) ?>') no-repeat center center; background-size: cover;">

	<div class="uk-container uk-container-large banner-100">

		<?php get_breadcrumb(); ?>

		<a class="archive-link" href="<?php echo get_month_link( get_the_time('Y'), get_the_time('m') ); ?>" title="<?php  _e( 'Przejdź do archiwum', 'wctheme' ) ?>">
			<time><?php the_date( 'j F Y' ); ?></time>
		</a>
	
		<h1 class="page-banner__header white__banner uk-margin-small-top"><?php the_title(); ?></h1>

		<?php if ( is_product_category() ) : ?>
			<p class="page-banner__para"><?php do_action( 'woocommerce_category_description' ); ?></p>
		<?php endif; ?>

	</div>

</header>