<page style="font-family: freeserif">
	<table style="width: 100%; border-collapse: collapse;" width="600" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td valign="top" style="width: 500px; padding: 0;">
					<table style="table-layout: fixed; position: relative; border-collapse: collapse; margin-top: 10px; margin-bottom: 25px; width: 100%;" cellpadding="0" cellspacing="0">
						<tr>
							<td style="width: 404px;">
								<h3 style="margin-bottom: 0;"><?php echo __( 'wctheme Patisserie & Chocolaterie', 'wctheme' ); ?></h3>
								<h4 style="margin-top: 0;"><?php echo __( 'Dokument zamówienia', 'wctheme' ); ?></h4>
							</td>
							<td style="width: 200px">
								<table style="table-layout: fixed; border-collapse: collapse; margin-top: 15px;" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th style="width: 100px; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px 10px 0 10px;"><?php echo __( 'Numer zamówienia', 'wctheme' ); ?></th>
											<th style="width: 100px; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px 10px 0 10px;"><?php echo __( 'Data utworzenia', 'wctheme' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width: 100px; padding: 10px; border: 1px solid #dee2e6;"><strong><?php echo $order->get_order_number(); ?></strong></td>
											<td style="width: 100px; padding: 10px; border: 1px solid #dee2e6;"><strong><?php echo $order->get_date_created()->format( 'd-m-Y H:i' ); ?></strong></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top" style="width: 500px;">
					<table style="table-layout: fixed; position: relative; border-collapse: collapse; width: 100%; margin-bottom: 25px" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="vartical-align: top;" width="320" valign="top">
									<table style="table=-layout: fixed; border-collapse: collapse;">
										<thead>
											<tr>
												<th style="width: 280px; vertical-align: bottom; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px;"><?php echo __( 'Dane kupującego', 'wctheme' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="width: 280px; padding: 10px; border: 1px solid #dee2e6;">
													<?php if ( get_post_meta( $order->get_order_number(), '_billing_company', true ) ) : ?>
														<?php echo get_post_meta( $order->get_order_number(), '_billing_company', true ); ?><br>
													<?php endif; ?>
													<?php echo $order->get_shipping_first_name(); ?>&nbsp;<?php echo $order->get_shipping_last_name(); ?><br>
													<?php echo $order->get_billing_email(); ?><br>
													<?php echo $order->get_shipping_address_1(); ?>&nbsp;<?php echo get_post_meta( $order->get_order_number(), '_shipping_address_building', true ); ?><?php if ( get_post_meta( $order->get_order_number(), '_shipping_address_apartment', true ) ) : ?>/<?php echo get_post_meta( $order->get_order_number(), '_shipping_address_apartment', true ); ?><?php endif; ?><br>
													<?php echo $order->get_shipping_address_2(); ?><br>
													<?php if ( get_post_meta( $order->get_order_number(), '_shipping_wctheme_postcode', true ) ) : ?>
														<?php echo get_post_meta( $order->get_order_number(), '_shipping_wctheme_postcode', true ); ?>
													<?php else: ?>
														<?php echo get_post_meta( $order->get_order_number(), '_billing_postcode', true ); ?>
													<?php endif; ?>
													<?php echo $order->get_shipping_city(); ?><br>
													<?php echo $order->get_billing_phone(); ?>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td style="vartical-align: top;" width="40" valign="top">&nbsp;</td>
								<td style="vartical-align: top;" width="320" valign="top">
									<table style="border-collapse: collapse; width: 320px;">
										<thead>
											<tr>
												<th style="width: 280px; vertical-align: bottom; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px;"><?php echo __( 'Wybrana forma dostawy', 'wctheme' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="width: 280px; padding: 10px; border: 1px solid #dee2e6;">
													<?php foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) : ?>
														
														<?php
															$days_en = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
															$days_pl = array("poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota", "niedziela");

															$date = get_post_meta( $order->get_order_number(), '_wctheme_shipping_date', true ); 
															$day_of_week = str_replace( $days_en, $days_pl, date('l', strtotime( $date ) ) ) . ' '; 
														?>

														<?php if ( 'local_pickup' == $shipping_item_obj->get_method_id() ) : ?>
															<?php echo $shipping_item_obj->get_name(); ?><br>
															<?php if ( get_post_meta( $order->get_order_number(), '_wctheme_pickup_location', true ) ) : ?>
																<?php echo __('Miejsce odbioru: ', 'wctheme') . get_the_title( get_post_meta( $order->get_order_number(), '_wctheme_pickup_location', true ) ); ?>
															<?php endif; ?>

															<br>
															<?php if ( get_post_meta( $order->get_order_number(), '_wctheme_shipping_date', true ) ) : ?>
																<br><?php echo __( 'Data realizacji: ', 'wctheme' ) . $day_of_week . get_post_meta( $order->get_order_number(), '_wctheme_shipping_date', true ) ?>
															<?php endif; ?>

															<?php if ( get_post_meta( $order->get_order_number(), '_wctheme_shipping_time', true ) ) : ?>
																<br><?php echo __( 'Godzina odbioru: ', 'wctheme' ) . get_post_meta( $order->get_order_number(), '_wctheme_shipping_time', true ) ?>
															<?php endif; ?>

														<?php endif; ?>

														<?php if ( 'flat_rate' == $shipping_item_obj->get_method_id() ) : ?>
															<?php echo __( 'Dostawa Kurier DHL', 'wctheme' ); ?><br>
															<?php echo $order->get_billing_first_name(); ?>&nbsp;<?php echo $order->get_billing_last_name(); ?><br>
															<?php echo $order->get_billing_email(); ?><br>
															<?php echo $order->get_billing_address_1(); ?>&nbsp;<?php echo get_post_meta( $order->get_order_number(), '_billing_address_building', true ); ?><?php if ( get_post_meta( $order->get_order_number(), '_billing_address_apartment', true ) ) : ?>/<?php echo get_post_meta( $order->get_order_number(), '_billing_address_apartment', true ); ?><?php endif; ?><br>
															<?php echo $order->get_billing_address_2(); ?><br>
															<?php echo $order->get_billing_postcode(); ?>&nbsp;<?php echo $order->get_billing_city(); ?><br>
															<?php echo $order->get_billing_phone(); ?>
															<?php 
																$billing_notes = get_post_meta( $order->get_order_number(), '_billing_notes', true );

																if ( $billing_notes ) {
																	echo sprintf( __( '<p><strong>Uwagi dla kuriera:</strong><br>%s</p>', 'wctheme' ), $billing_notes );
																}
															 ?>
														<?php endif; ?>

														<?php if ( 'wctheme_free_shipping' == $shipping_item_obj->get_method_id() ) : ?>
															<?php echo __( 'Dostawa wctheme Kurier', 'wctheme' ); ?><br>
															<?php echo $order->get_billing_first_name(); ?>&nbsp;<?php echo $order->get_billing_last_name(); ?><br>
															<?php echo $order->get_billing_email(); ?><br>
															<?php echo $order->get_billing_address_1(); ?>&nbsp;<?php echo get_post_meta( $order->get_order_number(), '_billing_address_building', true ); ?><?php if ( get_post_meta( $order->get_order_number(), '_billing_address_apartment', true ) ) : ?>/<?php echo get_post_meta( $order->get_order_number(), '_billing_address_apartment', true ); ?><?php endif; ?><br>
															<?php echo $order->get_billing_address_2(); ?><br>
															<?php echo $order->get_billing_postcode(); ?>&nbsp;<?php echo $order->get_billing_city(); ?><br>
															<?php echo $order->get_billing_phone(); ?>

														<?php endif; ?>

														<?php if ( 'pickpack' == $shipping_item_obj->get_method_id() ) : ?>
															<?php echo __( 'Dostawa PickPack', 'wctheme' ); ?><br>
															<?php echo $order->get_billing_first_name(); ?>&nbsp;<?php echo $order->get_billing_last_name(); ?><br>
															<?php echo $order->get_billing_email(); ?><br>
															<?php echo $order->get_billing_address_1(); ?>&nbsp;<?php echo get_post_meta( $order->get_order_number(), '_billing_address_building', true ); ?><?php if ( get_post_meta( $order->get_order_number(), '_billing_address_apartment', true ) ) : ?>/<?php echo get_post_meta( $order->get_order_number(), '_billing_address_apartment', true ); ?><?php endif; ?><br>
															<?php echo $order->get_billing_address_2(); ?><br>
															<?php echo $order->get_billing_postcode(); ?>&nbsp;<?php echo $order->get_billing_city(); ?><br>
															<?php echo $order->get_billing_phone(); ?>
															<?php 
																$ship 	= wctheme_ready_for_pickpack_send(); // Zakresy kiedy wctheme musi przygotować przesyłke
																$range 	= return_pickpack_time_range(); // Zakresy kiedy kurier dostarcza przesyłkę
																$time 	= get_post_meta( $order->get_order_number(), '_wctheme_shipping_time', true );
																$key 	= array_search( $time, $range );
															?>

															<?php 
																$billing_notes = get_post_meta( $order->get_order_number(), '_billing_notes', true );

																if ( $billing_notes ) {
																	echo sprintf( __( '<p><strong>Uwagi dla kuriera:</strong><br>%s</p>', 'wctheme' ), $billing_notes );
																}
															 ?>

															<?php if ( get_post_meta( $order->get_order_number(), '_wctheme_shipping_date', true ) ) : ?>
																<br><?php echo __( 'Data realizacji: ', 'wctheme' ) . $day_of_week . get_post_meta( $order->get_order_number(), '_wctheme_shipping_date', true ) ?>
															<?php endif; ?>

															<?php if ( $ship[$key] ) : ?><br><?php echo __( 'Godzina odbioru przez kuriera: ', 'wctheme' ) . $ship[$key]; ?><?php endif; ?>
															<?php if ( $time ) : ?>
																<br><?php echo __( 'Godzina dostarczenia: ', 'wctheme' ) . $range[$key]; ?>
															<?php endif; ?>
														<?php endif; ?>
													<?php endforeach; ?>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>		
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top" style="width: 500px;">
					<table style="table-layout: fixed; border-collapse: collapse; margin-top: 15px; width: 500px;" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th style="width: 220px; vertical-align: bottom; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px;"><?php echo __( 'Nazwa produktu', 'wctheme' ); ?></th>
								<th style="width: 40px; vertical-align: bottom; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px;"><?php echo __( 'Ilość', 'wctheme' ); ?></th>
								<th style="width: 140px; vertical-align: bottom; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px; text-align: right;"><?php echo __( 'Cena jednostkowa', 'wctheme' ); ?></th>
								<th style="width: 120px; vertical-align: bottom; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px; text-align: right;"><?php echo __( 'Cena brutto', 'wctheme' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $order->get_items() as $item ) : ?>
								<tr>
									<td style="width: 220px; padding: 10px; border: 1px solid #dee2e6;">
										<p style="margin-top: 0;"><strong><?php echo $item->get_name(); ?></strong></p>
										<?php 
											$flavours 		= wc_get_order_item_meta( $item->get_ID(), 'Wybrane smaki' );
											$cake_text 		= wc_get_order_item_meta( $item->get_ID(), 'Napis na tort' );
											$presentpack 	= wc_get_order_item_meta( $item->get_ID(), 'Komentarz do zestawu prezentowego' );
											$display 		= '';

											if ( $flavours ) {
												foreach( $flavours as $flavour ) {
													$display .= $flavour['name'] . ': <strong>' . $flavour['quantity'] . '</strong><br>';
												}
											} 

											if ( $cake_text ) {
												$display .= __( 'Treść napisu na torcie: ', 'wctheme' ) . '<strong>' . $cake_text . '</strong>';
											}

											if ( $presentpack ) {
												$display .= __( 'Komentarz do zestawu prezentowego: ', 'wctheme' ) . '<strong>' . $presentpack . '</strong>';
											}

											echo '<small>' . $display . '</small>';
										?>
									</td>
									<td style="width: 40px; padding: 10px; border: 1px solid #dee2e6;"><?php echo $item->get_quantity(); ?></td>
									<td style="width: 140px; padding: 10px; border: 1px solid #dee2e6; text-align: right;"><?php echo wc_price( $item->get_total() / $item->get_quantity() ); ?></td>
									<td style="width: 120px; padding: 10px; border: 1px solid #dee2e6; text-align: right;"><?php echo wc_price( $item->get_total() ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<?php foreach( $order->get_items('fee') as $item_id => $item_fee ) : ?>
								<tr>
									<td colspan="3" style="padding: 10px; border: 1px solid #dee2e6;"><?php echo $item_fee->get_name() ?></td>
									<td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;"><?php echo wc_price($item_fee->get_total()); ?></td>
								</tr>
							<?php endforeach; ?>

							<?php foreach( $order->get_items('coupon') as $item_id => $item ) : ?>
								<?php 
									$coupon_post_obj 	= get_page_by_title( $item->get_name(), OBJECT, 'shop_coupon' );
    								$coupon_id 			= $coupon_post_obj->ID;
									$coupon 			= new WC_Coupon( $coupon_id );
								?>
								<tr>
									<td colspan="3" style="padding: 10px; border: 1px solid #dee2e6;">
										<?php _e( 'Wykorzystany kupon: ', 'wctheme' ); ?><?php echo $coupon->get_code(); ?><br>
									</td>
									<td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;"><?php echo wc_price( $coupon->get_amount() ); ?></td>
								</tr>
							<?php endforeach; ?>

							<?php foreach( $order->get_items('shipping') as $item_id => $item_fee ) : ?>
								<tr>
									<td colspan="3" style="padding: 10px; border: 1px solid #dee2e6;"><?php echo $item_fee->get_name() ?></td>
									<td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;"><?php echo wc_price($item_fee->get_total()); ?></td>
								</tr>
							<?php endforeach; ?>

							<tr>
								<td colspan="3" style="padding: 10px; border: 1px solid #dee2e6;"><?php echo __( 'Razem', 'wctheme' ); ?></td>
								<td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;"><?php echo wc_price($order->get_total()); ?></td>
							</tr>
						</tfoot>
					</table>
				</td>
			</tr>

			<tr>
				<td valign="top" style="width: 500px; padding-top: 50px;">
					<h3 style="margin-bottom: 0;">
						<?php _e( 'Dodatkowe informacje', 'wctheme' ); ?>
					</h3>
					<p style="margin-bottom: 0px;">
						<strong><?php _e( 'Prezent: ', 'wctheme' ); ?></strong>
						<?php if ( get_post_meta( $order->get_order_number(), '_wctheme_present', true ) ) : ?>
							<?php _e( 'Tak - Nie dołączać paragonu', 'wctheme' ); ?>
						<?php else: ?>
							<?php _e( 'Nie', 'wctheme' ) ?>
						<?php endif; ?>
					</p>
					<p style="margin-bottom: 5px;">
						<strong><?php _e( 'Faktura: ', 'wctheme' ); ?></strong>
						<?php if ( get_post_meta( $order->get_order_number(), '_wctheme_company_nip', true ) ) : ?>
							<?php _e( 'Tak', 'wctheme' ); ?><br>
							<?php _e( 'NIP:', 'wctheme' ); ?>&nbsp;<?php echo get_post_meta( $order->get_order_number(), '_wctheme_company_nip', true ) ?>
						<?php else: ?>
							<?php _e( 'Nie', 'wctheme' ) ?>
						<?php endif; ?>
					</p>
				</td>
			</tr>

			<?php if ( $order->get_customer_note() ) : ?>

				<tr>
					<td valign="top" style="width: 500px; border: 1px solid red;">
						<table style="table-layout: fixed; border-collapse: collapse; margin-top: 15px; width: 100%;" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th style="vertical-align: bottom; border-bottom: 2px solid #dee2e6; border: 1px solid #dee2e6; padding: 10px;"><?php echo __( 'Uwagi do zamówienia', 'wctheme' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>

			<?php endif; ?>
		</tbody>
	</table>
</page>