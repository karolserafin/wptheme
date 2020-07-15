<?php
/**
 * The template for displaying the 404 template in the wctheme theme.
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header();
?>

	<section class="section__404">
		<div class="uk-container uk-container-large">
			
			<div class="section__404--image">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/img_404.png" alt="">
			</div>

			<div class="section__404--content">
				<h3 class="section__404--content__headline"><?php echo __('Opss… Ta strona nie istnieje!', 'wctheme'); ?></h3>
				<div class="section__404--content__links">
					<a class="product-extra-info__link button button--empty" href="<?php echo get_site_url(); ?>" title="<?php echo __('Strona główna', 'wctheme'); ?>"><?php echo __('Strona główna', 'wctheme'); ?></a>
				</div>
				<p class="section__404--content__links--back"><?php echo __('lub wróć do ', 'wctheme'); ?><a href="" class="historyBack" title="<?php echo __('poprzedniej strony', 'wctheme'); ?>"><?php echo __('poprzedniej strony', 'wctheme'); ?></a></p>
			</div>

		</div>
	</section>

<?php
get_footer();
