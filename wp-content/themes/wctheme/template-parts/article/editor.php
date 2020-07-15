<?php if ( have_rows( 'article__modules' ) ) : ?>

	<?php while ( have_rows( 'article__modules' ) ) : the_row(); ?>

		<?php if ( get_row_layout() == 'module__text' ) : ?>

			<?php get_template_part( '/template-parts/article/modules/text' ); ?>

		<?php endif; ?>

		<?php if ( get_row_layout() == 'module__image' ) : ?>

			<?php get_template_part( '/template-parts/article/modules/image' ); ?>

		<?php endif; ?>

		<?php if ( get_row_layout() == 'module__banner' ) : ?>
			
			<?php get_template_part( '/template-parts/article/modules/banner' ); ?>

		<?php endif; ?>

		<?php if ( get_row_layout() == 'module__image-text' ) : ?>

			<?php get_template_part( '/template-parts/article/modules/image-text' ); ?>

		<?php endif; ?>



	<?php endwhile; ?>

<?php endif; ?>