<?php get_template_part( '/template-parts/shop/banner' ); ?>

<section class="uk-container uk-container-large article__content row">

	<?php wc_print_notices(); ?>

	<form action="" metohd="GET">

		<div uk-grid>
			<div class="shop__tags uk-width-1-1">

				<p class="shop-para"><?php _e( 'Filtruj:', 'wctheme' ); ?></p>

				<?php $get_tag 	= isset( $_GET['tag'] ) ? $_GET['tag'] : array(); ?>
				<?php $tags 	= get_terms( 'product_tag' ); ?>

				<ul class="products_tag_filter filter-desktop">

					<?php foreach ( $tags as $tag ) : ?>
						<li>
							<label for="tag-<?php echo $tag->slug; ?>" class="<?php if ( in_array( $tag->slug, $get_tag ) ) : ?>label-selected<?php endif; ?>">
								<input id="tag-<?php echo $tag->slug; ?>" type="checkbox" class="uk-checkbox" name="tag[]" value="<?php echo $tag->slug; ?>" <?php if ( in_array( $tag->slug, $get_tag ) ) : ?>checked<?php endif; ?>>
								<?php echo $tag->name; ?>
							</label>
						</li>
					<?php endforeach; ?>

				</ul>

			</div>

			<div class="shop__sidebar uk-width-1-1 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-5@xl">
				<h3><?php echo __( 'Kategorie:', 'wctheme' ); ?></h3>
				<?php $categories 	= wctheme_categories_filter(); ?>
				<?php $checked 	 	= wctheme_get_current_category_slug(); ?>
				<?php $get_category = isset( $_GET['category'] ) ? $_GET['category'] : array(); ?>
				<?php if ( is_shop() ) : ?>

					<ul class="sidebar__products_category_filter sidebar__products_category_filter__shop filter-desktop">
						<li>
							<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
								<input type="checkbox" class="uk-checkbox" value="all" <?php if ( empty( $_GET['category'] ) ) : ?>checked<?php endif; ?>>
								<?php echo __( 'Wszystkie', 'wctheme' ); ?>
							</a>
						</li>
						<?php foreach( $categories as $category ): ?>
							<li>
								<label for="category-<?php echo $category->slug; ?>">
									<input type="checkbox" id="category-<?php echo $category->slug; ?>" class="uk-checkbox" name="category[]" value="<?php echo $category->slug; ?>" <?php if ( $checked == $category->slug || in_array( $category->slug, $get_category ) ) : ?>checked<?php endif; ?> >
									<?php echo $category->name; ?>
								</label>
							</li>
						<?php endforeach; ?>
					</ul>

					<div uk-slider class="filter-desktop-mobile">
						<ul class="sidebar__products_category_filter sidebar__products_category_filter__shop uk-slider-items">
							<li>
								<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
									<input type="checkbox" class="uk-checkbox" value="all" <?php if ( empty( $get_category ) ) : ?>checked<?php endif; ?>>
									<?php echo __( 'Wszystkie', 'wctheme' ); ?>
								</a>
							</li>
							<?php foreach( $categories as $category ): ?>
								<li>
									<label for="category-<?php echo $category->slug; ?>" class="mobile_filter_label <?php if ( $checked == $category->slug || in_array( $category->slug, $get_category ) ) : ?>label-selected<?php endif; ?>">

										<input type="checkbox" class="uk-checkbox" value="<?php echo $category->slug; ?>" <?php if ( $checked == $category->slug || in_array( $category->slug, $get_category ) ) : ?>checked<?php endif; ?> >
										<?php echo $category->name; ?>
									</label>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					
				<?php endif; if ( is_product_category() ) : ?>
					<ul class="sidebar__products_category_filter sidebar__products_category_filter__category filter-desktop">
						<li>
							<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
								<input type="checkbox" class="uk-checkbox" value="all">
								<?php echo __( 'Wszystkie', 'wctheme' ); ?>
							</a>
						</li>

						<?php foreach( $categories as $category ): ?>
							<li>
								<a href="<?php echo get_term_link( $category->term_id, 'product_cat' ); ?>">
									<input type="checkbox" class="uk-checkbox" name="category[]" value="<?php echo $category->slug; ?>" <?php if ( $checked == $category->slug || in_array( $category->slug, $get_category ) ) : ?>checked<?php endif; ?> >
									<?php echo $category->name; ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>

					<div uk-slider class="filter-desktop-mobile">
						<ul class="sidebar__products_category_filter sidebar__products_category_filter__category uk-slider-items">
							<li>
								<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
									<input type="checkbox" class="uk-checkbox" value="all">
									<?php echo __( 'Wszystkie', 'wctheme' ); ?>
								</a>
							</li>
							<?php global $wp_query; $current_category = get_query_var( 'product_cat' ); ?>
							<?php foreach( $categories as $category ): ?>
								<li>
									<a href="<?php echo get_term_link( $category->term_id, 'product_cat' ); ?>" <?php if ( $current_category == $category->slug ) : ?>class="label-selected"<?php endif; ?>>
										<input type="checkbox" class="uk-checkbox" name="category[]" value="<?php echo $category->slug; ?>" <?php if ( $checked == $category->slug || in_array( $category->slug, $get_category ) ) : ?>checked<?php endif; ?> >
										<?php echo $category->name; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<p class="clear-all-category">
					<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="clear-all-category--link"><?php _e( 'Wyczyść wszystko', 'wctheme' ); ?></a>	
				</p>

				<script type="text/javascript">
					jQuery(function($){
						$('.mobile_filter_label').on('click', function(){
							var check = $(this).find('input');
							check.prop("checked", !check.prop("checked"));
						});
						var check = $('.sidebar__products_category_filter input, .products_tag_filter input').on('change', function(){
							$('form').submit();
						});
					});
				</script>
				
			</div>
			
			<div class="content__article uk-width-1-1 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l uk-width-4-5@xl">
				<?php 
					$paged 						= get_query_var('paged') ? get_query_var('paged') : 1;
					$category 					= array();
					$args 						= array(
						'paged' 					=> $paged,
						'posts_per_page' 			=> 12,
						'post_type' 				=> 'product',
						'tax_query' 				=> array(),
					);

					$exclude = exclude_products_from_query();

			        if ( !empty( $exclude ) ) {
			            $args['post__not_in'] = $exclude;
			        }

					if ( is_product_category() ) {

						global $wp_query;

						$args['posts_per_page'] = -1;

        				$term 			= $wp_query->get_queried_object();
        				$category[] 	= $term->slug;

					}

					$args['tax_query'][] 		= array(
						'taxonomy' 					=> 'product_visibility',
                        'field' 					=> 'term_taxonomy_id',
                        'terms' 					=> array(7),
                        'operator' 					=> 'NOT IN',
					);

					if ( !empty( $_GET['category'] ) ) {
						foreach( $_GET['category'] as $cat ) {
							$category[] = $cat;
						}
					}

					if ( !empty( $category ) ) {
			            $args['tax_query'][]    = array(
			                'taxonomy'     			=> 'product_cat',
			                'field'        			=> 'slug',
			                'terms'        			=> $category,
			                'operator'     			=> 'IN'
			            );
			        }

			        if ( !empty( $_GET['tag'] ) ) {
			            $args['tax_query'][]    = array(
			                'taxonomy'     			=> 'product_tag',
			                'field'        			=> 'slug',
			                'terms'        			=> $get_tag,
			                'operator'    	 		=> 'AND'
			            );
			        }

			        $query = new Wp_Query( $args );
				?>

				<?php if ( $query->have_posts() ) : ?>

					<div class="woocommerce columns-4">
						<ul class="products columns-4">

							<?php while ( $query->have_posts() ) : $query->the_post(); ?>

								<li class="product type-product"><?php get_template_part( '/template-parts/product/card' ); ?></li>
								<?php wp_reset_postdata(); ?>
								
							<?php endwhile; ?>

							<?php wctheme_articles_pagination( $paged, $query->max_num_pages ); ?>

						</ul>
					</div>

				<?php else: ?>
					<p class="woocommerce-info"><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
				<?php endif; ?>

			</div>

		</div>

	</form>

</section>