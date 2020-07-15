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

<p><?php _e( 'Dzień dobry!', 'wctheme' ); ?></p>

<p><?php _e( 'Dziękujemy za zamówienie w wctheme Patisserie & Chocolaterie. Twoje zamówienie czeka już gotowe do odbioru w wybranym przez Ciebie punkcie :) Mamy nadzieję, że będzie pysznie!', 'wctheme' ); ?></p>

<p><?php _e( 'Jeśli masz Instagram lub Facebooka, podziel się swoimi wrażeniami, wrzucając zdjęcia lub relacje i oznaczając profil wctheme. Znajdziesz nas jako:', 'wctheme' ); ?></p>

<p>
	<a href=""><?php _e( '@wctheme na Facebooku', 'wctheme' ); ?></a>
	<a href=""><?php _e( '@wctheme_patisserie na Instagramie', 'wctheme' ); ?></a>
</p>

<p><?php _e( 'Smacznego!', 'wctheme' ) ?></p>
<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>

<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );

