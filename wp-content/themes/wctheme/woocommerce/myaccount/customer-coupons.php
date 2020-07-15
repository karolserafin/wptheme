<?php
/**
 * My Account 
 *
 * Customer coupons
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="customer__coupons">
	
	<h2><?php _e( 'Moje rabaty', 'wctheme' ); ?></h2>
	<p><?php _e( 'Tutaj może być jakiś opis dotyczący rabatów w zakładce Moje Konto. Najlepiej krótkie informacje, które będą ważne zarówno po stronie wctheme jak i uzytkownika.', 'wctheme' ); ?></p>

	<div class="discount-table">
	
		<div class="discount-table__head">
			<div class="discount-table__head--element"><?php _e( 'Kod rabatu', 'wctheme' ); ?></div>
			<div class="discount-table__head--element"><?php _e( 'Rabat', 'wctheme' ); ?></div>
			<div class="discount-table__head--element flex-2"><?php _e( 'Termin ważności', 'wctheme' ); ?></div>
			<div class="discount-table__head--element flex-2"><?php _e( 'Status', 'wctheme' ); ?></div>
		</div>

		<div class="discount-table__body">
			<?php foreach( $coupons as $coupon ) : ?>
				<div class="discount-table__body-container">
					<div class="discount-table__body-container--element"><?php echo $coupon['code']; ?></div>
					<div class="discount-table__body-container--element"><?php echo $coupon['discount']; ?></div>
					<div class="discount-table__body-container--element flex-2"><?php date_default_timezone_set('Europe/Warsaw'); echo date( 'Y-m-d H:i', strtotime($coupon['expires']) ); ?></div>
					<div class="flex-2">
						<div class="discount-table__body-container--element"><?php echo $coupon['status']; ?></div>
						<div class="discount-table__body-container--element"><?php date_default_timezone_set('Europe/Warsaw'); echo date( 'Y-m-d H:i', strtotime($coupon['used']) ); ?></div>	
					</div>

				</div>
			<?php endforeach; ?>
		</div>
	</div>

</div>