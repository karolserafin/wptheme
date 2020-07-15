<?php 
	global $post;
    $post_slug = $post->post_name;
?>
<section class="section section__categories <?php echo $post_slug; ?> uk-container uk-container-large">
	
	<?php if ( get_field( 'categories__list' ) ) : ?>

		<ul class="categories__list">
			
			<?php while ( have_rows('categories__list') ) : the_row(); ?>

				<li class="category">

					<div class="category__image">

						<img src="<?php echo get_sub_field( 'category__photo' ); ?>" alt="<?php echo get_sub_field( 'category__title' ); ?>" />
			
					</div>
					<div class="category__content">
				
						<h5><?php echo get_sub_field( 'category__title' ); ?></h5>
						<p><?php echo get_sub_field( 'category__description' ); ?></p>
						
						<?php 
							$category__page__link 		= get_sub_field('category__page__link');
							$category__page__link_val	= $category__page__link['value'];
						?>
						
						<?php if ( $category__page__link_val == 'category' ): // product category link ?>

							<?php if ( get_term_link( get_sub_field( 'category__url' ) ) ): ?>
							<a href="<?php echo get_term_link( get_sub_field( 'category__url' ) ) ?>" title="<?php echo get_sub_field( 'category__button__content' ); ?>">
								<?php echo get_sub_field( 'category__button__content' ); ?>
							</a>
							<?php endif; ?>

						<?php else: // page link ?>
						
							<?php $page__link = get_sub_field('page__link'); ?>
							<?php if ( $page__link ): ?>
								<a href="<?php echo $page__link; ?>" title="<?php echo get_sub_field( 'category__button__content' ); ?>">
									<?php echo get_sub_field( 'category__button__content' ); ?>
								</a>
							<?php endif; ?>

						<?php endif; ?>

					</div>

				</li>
				
			<?php endwhile; wp_reset_query(); ?>

		</ul>

	<?php endif; ?>

</section>
