<header class="page__header page-banner" style="background: transparent url('') no-repeat center center; background-size: cover;">

	<div class="uk-container uk-container-large banner-100">
	
		<h1 class="page-banner__header"><?php the_title(); ?></h1>

		<?php if ( is_product_category() ) : ?>
			<p class="page-banner__para"><?php do_action( 'woocommerce_category_description' ); ?></p>
		<?php endif; ?>

	</div>

</header>