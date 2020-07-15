<?php
/**
 * Cancelled Order sent to Customer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) {
	$shipping = $shipping_item_obj->get_method_id();
} ?>

<?php 
/**
 *	Wysyłka PickPack
 *
 *
 */	
if ( $shipping == 'pickpack' ) : ?>

	<p><?php _e( 'Dziękujemy za zamówienie w wctheme Patisserie & Chocolaterie. Twoje zamówienie zostało wysłane i zostanie dziś dostarczone przez firmę <strong>PickPack</strong> :) Mamy nadzieję, że będzie pysznie!', 'wctheme' ); ?></p>
	<p><?php _e( 'Jeśli masz Instagram lub Facebooka, podziel się swoimi wrażeniami, wrzucając zdjęcia lub relacje i oznaczając profil wctheme. Znajdziesz nas jako:', 'wctheme' ); ?></p>

	<p>
		<a href=""><?php _e( '@wctheme na Facebooku', 'wctheme' ); ?></a>
		<a href=""><?php _e( '@wctheme_patisserie na Instagramie', 'wctheme' ); ?></a>
	</p>

	<p><?php _e( 'Smacznego!', 'wctheme' ) ?></p>
	<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>

<?php endif; ?>

<?php 
/**
 *	Wysyłka DHL
 *
 *
 */	
if ( $shipping == 'flat_rate' ) : ?>

	<p><?php _e( 'Dziękujemy za zamówienie w wctheme Patisserie & Chocolaterie. Twoje zamówienie zostało wysłane i zostanie dostarczone w ciągu najbliższych dwóch dni przez firmę <strong>DHL</strong> :) Mamy nadzieję, że będzie pysznie!', 'wctheme' ); ?></p>

	<p><?php _e( 'Jeśli masz Instagram lub Facebooka, podziel się swoimi wrażeniami, wrzucając zdjęcia lub relacje i oznaczając profil wctheme. Znajdziesz nas jako:', 'wctheme' ); ?></p>

	<p>
		<a href=""><?php _e( '@wctheme na Facebooku', 'wctheme' ); ?></a>
		<a href=""><?php _e( '@wctheme_patisserie na Instagramie', 'wctheme' ); ?></a>
	</p>

	<p><?php _e( 'Smacznego!', 'wctheme' ) ?></p>
	<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>
	<br><br>

	<p><?php _e( 'PS. Gdyby okazało się, że zamówienie do Ciebie nie dotarło w ciągu 2 dni od otrzymania tego maila, poprosimy o kontakt na adres mailowy – ', 'wctheme' ); ?>
		<a href="mailto:contact@wcthemepatisserie.com"><?php _e( 'contact@wcthemepatisserie.com', 'wctheme' ); ?></a>
	</p>

<?php endif; ?>

<?php 
/**
 *	Wysyłka Własna
 *
 *
 */	
if ( $shipping == 'wctheme_free_shipping' ) : ?>

	<p><?php _e( 'Dziękujemy za zamówienie w wctheme Patisserie & Chocolaterie. Twoje zamówienie zostało wysłane i zostanie dziś przez nas dostarczone :) Mamy nadzieję, że będzie pysznie!', 'wctheme' ); ?></p>

	<p><?php _e( 'Jeśli masz Instagram lub Facebooka, podziel się swoimi wrażeniami, wrzucając zdjęcia lub relacje i oznaczając profil wctheme. Znajdziesz nas jako:', 'wctheme' ); ?></p>

	<p>
		<a href=""><?php _e( '@wctheme na Facebooku', 'wctheme' ); ?></a>
		<a href=""><?php _e( '@wctheme_patisserie na Instagramie', 'wctheme' ); ?></a>
	</p>

	<p><?php _e( 'Smacznego!', 'wctheme' ) ?></p>
	<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>

<?php endif; ?>

<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );

