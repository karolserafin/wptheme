<?php 
/**
 * Strona główna
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>
	
	<div class="custom__alerts">
		<div class="woocommerce">
			<div class="uk-container uk-container-large">
				<?php wc_print_notices(); ?>			
			</div>
		</div>
	</div>

	<?php while ( have_posts() ) : the_post(); ?>
			
		<?php get_template_part( '/template-parts/home/banner' ); ?>

		<section class="image-section">

			<div class="uk-container uk-container-large"> 

				<div class="image-section__container">

					<h2 class="uk-heading-line uk-text-center section-title uk-margin-medium-top uk-margin-medium-bottom">Coco</h2>

					<div class="img-points">
						<ul class="image-section__points image-section__points--mobile">
							<li>ciasto parzone oblane białą czekoladą<span class="carmel-line"></span></li>
							<li>kokosowy krem chantilly<span class="carmel-line"></span></li>
						</ul>
						<ul class="image-section__points image-section__points--desktop">
							<li>kokosowy krem chantilly<span class="carmel-line"></span></li>
							<li>ciasto parzone oblane białą czekoladą<span class="carmel-line"></span></li>
						</ul>
						
						<img src="<?= get_template_directory_uri() . '/assets/img/cake.png' ?>"  width="" height="" alt="" uk-img>

						<ul class="image-section__points image-section__points--bottom image-section__points--desktop">
							<li>krem kokosowy<span class="carmel-line"></span></li>
							<li>pralina migdałowo-kokosowa<span class="carmel-line"></span></li>
						</ul>
						<ul class="image-section__points image-section__points--bottom image-section__points--mobile">
							<li>pralina migdałowo-kokosowa<span class="carmel-line"></span></li>
							<li>krem kokosowy<span class="carmel-line"></span></li>
						</ul>
					</div>

				</div>

			</div>

		</section>

		<?php get_template_part( '/template-parts/home/products' ); ?>
		<?php get_template_part( '/template-parts/home/offer' ); ?>
		<?php get_template_part( '/template-parts/home/posts' ); ?>
		<?php get_template_part( '/template-parts/home/instagram' ); ?>

	<?php endwhile; ?>

<?php get_footer();