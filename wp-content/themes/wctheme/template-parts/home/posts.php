<?php

	$parent = get_the_ID();
	$posts 	= get_field( 'posts' );

	$args 	= array(
		'posts_per_page' 		=> -1,
		'post_type' 			=> array( 'post' ),
		'post__in' 				=> $posts,
	);

	$query 	= new WP_Query( $args );

?>

<?php if ( $posts ) : ?>

	<section class="articles">

		<div style="display: none;"><?php print_r($posts); ?></div>

		<div class="uk-container uk-container-large">

			<h2 class="uk-heading-line uk-text-center section-title uk-margin-large-top uk-margin-medium-bottom"><?php echo get_field( 'posts__title', $parent ) ?></h2>

			<div uk-grid>

				<div uk-slider class="uk-width-1-1 uk-width-2-3@s uk-width-2-3@m uk-width-2-3@l uk-width-2-3@xl uk-position-relative">

					<div class="uk-slider-container">

						<div class="uk-slider-items" uk-grid>

							<?php while ( $query->have_posts() ) : $query->the_post(); ?>
								<div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
								<?php get_template_part( '/template-parts/article/card' ); ?>
								<?php wp_reset_postdata(); ?>
								</div>
							<?php endwhile; ?>

						</div>

					</div>
					
					<ul class="uk-slider-nav uk-dotnav posts-nav"></ul>

				</div>

				<div class="uk-width-1-1 uk-width-1-3@s uk-width-1-3@m uk-width-1-3@l uk-width-1-3@xl">

					<div class="blog-text-container">
						<h3 class="articles-text-header"><?php echo get_field( 'posts__content', $parent ) ?></h3>
						<a class="product-extra-info__link button button--empty" href="<?php echo get_field( 'posts__button__link', $parent ) ?>"><?php echo get_field( 'posts__button__content', $parent ) ?></a>
					</div>

				</div>


			</div>

		</div>	

	</section>

<?php endif; ?>