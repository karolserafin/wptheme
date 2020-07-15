<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( !empty( $_POST ) ) {

	foreach( $_POST as $key => $value ) {
		update_user_meta( $customer_id, $key, $value );
	}

	$message[] = __( 'Dane zostały zaktualizowane', 'wctheme' );

}

?>

<div class="customer__addresses">

	<h2><?php _e( 'Moje adresy', 'wctheme' ); ?></h2>

	<?php if ( !empty( $message ) ) : ?>
		
		<div class="woocommerce-notices-wrapper">
			<div class="woocommerce-message" role="alert">
				<?php echo $message[0]; ?>
			</div>
		</div>
		
	<?php endif; ?>

	<h4><?php _e( 'Dane płatności', 'wctheme' ); ?></h4>

	<form action="" method="POST">
		
		<div class="col">

			<p class="form-row form-row-first validate-required">
				<label for="billing_first_name"><?php _e( 'Imię', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_first_name" id="billing_first_name"  value="<?php echo get_user_meta( $customer_id, 'billing_first_name', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-row-first validate-required">
				<label for="billing_last_name"><?php _e( 'Nazwisko', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_last_name" id="billing_last_name" value="<?php echo get_user_meta( $customer_id, 'billing_last_name', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-street form-row-first validate-required">
				<label for="billing_address_1"><?php _e( 'Ulica', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_address_1" id="billing_address_1" value="<?php echo get_user_meta( $customer_id, 'billing_address_1', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-number form-row-first validate-required">
				<label for="billing_address_building"><?php _e( 'Numer budynku', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_address_building" id="billing_address_building" value="<?php echo get_user_meta( $customer_id, 'billing_address_building', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-number form-row-first validate-required">
				<label for="billing_address_apartment"><?php _e( 'Numer lokalu', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_address_apartment" id="billing_address_apartment" value="<?php echo get_user_meta(  $customer_id, 'billing_address_apartment', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-row-first validate-required">
				<label for="billing_postcode"><?php _e( 'Kod pocztowy', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_postcode" id="billing_postcode" value="<?php echo get_user_meta( $customer_id, 'billing_postcode', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-row-first validate-required">
				<label for="billing_city"><?php _e( 'Miasto', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_city" id="billing_city" value="<?php echo get_user_meta( $customer_id, 'billing_city', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-row-first validate-required">
				<label for="billing_phone"><?php _e( 'Telefon', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="billing_phone" id="billing_phone" value="<?php echo get_user_meta( $customer_id, 'billing_phone', true ) ?>"/>
				</span>
			</p>

		</div>

		<div class="col text-right">
			<button type="submit" class="edit"><?php _e( 'Zmień dane', 'wctheme' ); ?></button>
		</div>

	</form>

	<h4><?php _e( 'Dane do wysyłki', 'wctheme' ); ?></h4>

	<form action="" method="POST">
		
		<div class="col">

			<input type="hidden" name="user" value="<?php echo $customer_id; ?>">

			<p class="form-row form-row-first validate-required">
				<label for="shipping_first_name"><?php _e( 'Imię', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="shipping_first_name" id="shipping_first_name"  value="<?php echo get_user_meta( $customer_id, 'shipping_first_name', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-row-first validate-required">
				<label for="shipping_last_name"><?php _e( 'Nazwisko', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="shipping_last_name" id="shipping_last_name" value="<?php echo get_user_meta( $customer_id, 'shipping_last_name', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-street form-row-first validate-required">
				<label for="shipping_address_1"><?php _e( 'Ulica', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="shipping_address_1" id="shipping_address_1" value="<?php echo get_user_meta( $customer_id, 'shipping_address_1', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-number form-row-first validate-required">
				<label for="shipping_address_building"><?php _e( 'Numer budynku', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="shipping_address_building" id="shipping_address_building" value="<?php echo get_user_meta( $customer_id, 'shipping_address_building', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-number form-row-first validate-required">
				<label for="shipping_address_apartment"><?php _e( 'Numer lokalu', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="shipping_address_apartment" id="shipping_address_apartment" value="<?php echo get_user_meta(  $customer_id, 'shipping_address_apartment', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-row-first validate-required">
				<label for="shipping_postcode"><?php _e( 'Kod pocztowy', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="shipping_postcode" id="shipping_postcode" value="<?php echo get_user_meta( $customer_id, 'shipping_postcode', true ) ?>"/>
				</span>
			</p>

			<p class="form-row form-row-first validate-required">
				<label for="shipping_city"><?php _e( 'Miasto', 'wctheme' ); ?></label>
				<span class="woocommerce-input-wrapper">
					<input type="text" class="input-text" name="shipping_city" id="shipping_city" value="<?php echo get_user_meta( $customer_id, 'shipping_city', true ) ?>"/>
				</span>
			</p>

		</div>

		<div class="col text-right">
			<button type="submit" class="edit"><?php _e( 'Zmień dane', 'wctheme' ); ?></button>
		</div>

	</form>

</div>