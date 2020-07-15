<?php
/**
 *	Shop Banner template
 *
 */

$banner 	= get_field( 'banner', 'options' );

if ( empty( $banner ) ) {
	return;
}

?>

<?php if ( !is_product_category() ): ?>

	<?php if ( !empty( $banner ) ): ?>
	<header class="page__header page-banner" style="background: transparent url('<?php echo $banner['banner__background']; ?>') no-repeat center center; background-size: cover;">

		<div class="uk-container uk-container-large banner-100">

			<h1 class="page-banner__header"><?php echo $banner['banner__title']; ?></h1>
			<p class="page-banner__para"><?php echo $banner['banner__content']; ?></p>

		</div>

	</header>
	<?php endif; ?>

<?php else: ?>
	
	<?php 
	/*
	* Product Category page
	*/
	?>

	<?php 
		$product_cat_id 	= get_queried_object_id();
		$product_cat_term   = 'product_cat_'.$product_cat_id;
		$banner_category	= get_field('banner_product_category', $product_cat_term);
		
		$banner_color_field  = $banner_category['banner_product_category_description_color'];
	    $banner_color        = $banner_color_field ? 'style="color:' . $banner_color_field . '"' : null;

	?>
	
	<?php if ( $banner_category ): ?>
		<?php 
		/*
		* Product Category custom banner
		*/
		?>
		<header class="page__header page-banner" style="background: transparent url('<?php echo $banner_category['banner_product_category_background']; ?>') no-repeat center center; background-size: cover;">

			<div class="uk-container uk-container-large banner-100">

				<h1 class="page-banner__header"><?php echo $banner_category['banner_product_category_title']; ?></h1>
				<p class="page-banner__para" <?php echo $banner_color; ?>><?php echo $banner_category['banner_product_category_description']; ?></p>

			</div>

		</header>
	<?php else: ?>
		<?php 
		/*
		* Default banner - options
		*/
		?>
		<header class="page__header page-banner" style="background: transparent url('<?php echo $banner['banner__background']; ?>') no-repeat center center; background-size: cover;">

		<div class="uk-container uk-container-large banner-100">

			<h1 class="page-banner__header"><?php echo $banner['banner__title']; ?></h1>
			<p class="page-banner__para"><?php echo $banner['banner__content']; ?></p>

		</div>

	</header>
	<?php endif; ?>

<?php endif; ?>

<?php if ( is_single() ) : ?>

	<section class="page__breadcrumbs">
		<div class="uk-container uk-container-large">
		
			<?php woocommerce_breadcrumb(); ?>
			
		</div>
	</section>

<?php endif; ?>