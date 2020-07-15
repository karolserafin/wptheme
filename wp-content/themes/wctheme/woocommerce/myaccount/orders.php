<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<header class="woocommerce-Address-title title">
	<h3><?php _e( 'Historia zamówień', 'wctheme' ); ?></h3>
	<p>
		<?php _e( 'Dziękujemy Ci za wszystkie słodkie chwile spędzone wspólnie z wctheme!<br>Poniżej znajdziesz dokładne informacje na temat wszystkich Twoich zamówień w naszym sklepie.', 'wctheme' ); ?>
	</p>
</header>

<?php if ( $has_orders ) : ?>

	<div class="uk-overflow-auto">

		<table id="wctheme-orders-table" class="uk-table woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">

			<tbody>
				<?php
				foreach ( $customer_orders->orders as $customer_order ) {
						$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
						$item_count = $order->get_item_count() - $order->get_item_count_refunded();
					?>
					
					<tr class="parent">
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
							<?php if( $column_id != 'order-total') : ?>
								<td class="order__heading">
									<div class="heading__inner">
										<?php if ( 'order-number' === $column_id ) : ?>
											<?php echo __( 'Numer zamówienia:', 'wctheme' ) . '<strong>&nbsp;' . $order->get_order_number() . '</strong>'; ?>

										<?php elseif ( 'order-status' === $column_id ) : ?>
											<?php echo __( 'Status zamówienia: ', 'wctheme' ) . '<strong>' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '</strong>'; ?>

										<?php elseif ( 'order-date' === $column_id ) : ?>
											<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

										<?php elseif ( 'order-actions' === $column_id ) : ?>
											<span class="collapsed" data-collapse>
												<?php _e( 'zwiń', 'wctheme' ); ?>
											</span>
											<span class="uncollapsed" data-collapse>
												<?php _e( 'rozwiń', 'wctheme' ); ?>
											</span>
										<?php endif; ?>
									</div>
								</td>
							<?php endif; ?>
						<?php endforeach; ?>
						
					</tr>

					<tr>
						<td colspan="4" class="order__details">
							<?php $order_items = $order->get_items(); ?>
							<div class="order__products">
								<h4><?php _e( 'Produkty', 'wctheme' ); ?></h4>
								<?php foreach ($order_items as $item_id => $item_data) : ?>
									<div class="order__product">
										<div class="product__image">
											<img src="<?php echo get_the_post_thumbnail_url( $item_data['product_id'] ); ?>" alt="<?php echo get_the_title( $item_data['product_id'] ) ?>">
										</div>
										<div class="product__details">
											<h5><a href="<?php echo get_permalink( $item_data['product_id'] ) ?>"><?php echo get_the_title( $item_data['product_id'] ) ?></a></h5>
											<?php 
												$flavours 		= wc_get_order_item_meta( $item_id, 'Wybrane smaki' );
												$cake_text 		= wc_get_order_item_meta( $item_id, 'Napis na tort' );
												$presentpack 	= wc_get_order_item_meta( $item_id, 'Komentarz do zestawu prezentowego' );
												$display 		= '';

												if ( $flavours ) {

													foreach( $flavours as $flavour ) {
														if ( $flavour['quantity'] > 0 ) {
															$display .= $flavour['name'] . ': <strong>' . $flavour['quantity'] . '</strong><br>';
														}
													}

												}
												if ( $cake_text ) {
													$display = __( 'Napis na tort: ', 'wctheme' ) . $cake_text;
												}
												if ( $presentpack ) {
													$display = __( 'Komentarz do zestawu prezentowego: ', 'wctheme' ) . $presentpack;
												}
											?>
											<p class="attributes"><?php echo $display; ?></p>
											<p class="weight">
												<?php 
													$weight = get_post_meta( $item_data['variation_id'], 'attribute_pa_ilosc_osob', true );
						                            if ( $weight ) {
						                                echo __( 'Liczba osób: ', 'wctheme' ) . '<strong>' . $weight . '</strong>';
						                            }
						                        ?>
											</p>
											<p class="quantity"><?php _e( 'Liczba:', 'wctheme' ); ?>&nbsp;<strong><?php echo $item_data['quantity']; ?></strong></p>
											<p class="price product-card__price uk-text-left">
												<?php if ( $item_data['subtotal'] == $item_data['total'] ) : ?>
													<?php echo wc_price( $item_data['total'] ); ?>
												<?php else: ?>
													<del><?php echo wc_price( $item_data['subtotal'] ); ?></del><br>
													<ins><?php echo wc_price( $item_data['total'] ); ?></ins>
												<?php endif; ?>
											</p>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="order__totals">
								<table class="details__table">
									<?php foreach( $order->get_items('fee') as $item_id => $item_fee ) : ?>
										<tr>
											<td><?php echo $item_fee->get_name(); ?></td>
											<td><?php echo wc_price( $item_fee->get_total() ); ?></td>
										</tr>
									<?php endforeach; ?>

									<?php if ( !empty( $order->get_coupon_codes() ) ) : ?>
										
										<?php foreach( $order->get_coupon_codes() as $coupon ) : ?>
											<?php $wc_coupon = new WC_Coupon( $coupon ); ?>
											<tr>
												<td><?php echo $coupon ?></td>
												<td>
													<?php 
														if ( $wc_coupon->get_discount_type() == 'percent' ) {
									    					echo $wc_coupon->get_amount() . '%';
									    				} else {
									    					echo wc_price( $wc_coupon->get_amount() );
									    				}
								    				?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>

									<tr>
										<td><?php _e( 'Dostawa: ', 'wctheme' ); ?></td>
										<td><?php echo wc_price( $order->get_total_shipping() ); ?></td>
									</tr>
									<tr>
										<td><?php _e( 'Łącznie: ', 'wctheme' ); ?></td>
										<td><?php echo wc_price( $order->get_total() ); ?></td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					
					<?php
				}
				?>
			</tbody>
		</table>

	</div>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous edit view-history" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next edit view-history" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
		</a>
		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
