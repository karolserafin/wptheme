<header class="page__header page-banner" style="background: transparent url('<?php echo get_the_post_thumbnail_url( get_the_ID(), 'wctheme-fullscreen' ) ?>') no-repeat center center; background-size: cover;">
	
	<div class="uk-container uk-container-large banner-100">
		
		<?php
			$banner_color_field  = get_field('banner_description_color');
	    	$banner_color        = $banner_color_field ? 'style="color:' . $banner_color_field . '"' : null;
	    ?>

		<h1 class="page-banner__header"><?php the_title(); ?></h1>

		<?php if ( is_product_category() ) : ?>
		
			<p class="page-banner__para" <?php echo $banner_color; ?>><?php do_action( 'woocommerce_category_description' ); ?></p>
		
		<?php else: ?>
			
			<?php if ( is_page_template('page-content.php') ): ?>
				
				<?php 
					// Default page 
					if ( get_field('banner_description_default_page') ): 
				?>
						
				<div class="page-banner__para">
					<p <?php echo $banner_color; ?>><?php the_field('banner_description_default_page'); ?></p>
				</div>

				<?php endif; ?>

			<?php else: ?>
				
				<div class="page-banner__para">
					<p <?php echo $banner_color; ?>><?php echo get_the_excerpt(); ?></p>
				</div>

			<?php endif; ?>

		<?php endif; ?>

	</div>

</header>