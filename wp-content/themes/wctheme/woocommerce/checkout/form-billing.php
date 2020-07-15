<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h2><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h2>

	<?php else : ?>

		<h2><?php esc_html_e( 'Adres dostawy', 'wctheme' ); ?></h2>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<ul class="user_type">
			<li>
				<label class="form__radio" for="type_user">
					<input type="radio" name="user_type" id="type_user" value="user" checked="checked">
					<span><?php _e( 'Osoba prywatna', 'wctheme' ); ?></span>
				</label>					
			</li>
			<li>
				<label class="form__radio" for="type_company">
					<input type="radio" name="user_type" id="type_company" value="company">
					<span><?php _e( 'Firma', 'wctheme' ); ?></span>
				</label>					
			</li>
		</ul>

		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		foreach ( $fields as $key => $field ) {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>