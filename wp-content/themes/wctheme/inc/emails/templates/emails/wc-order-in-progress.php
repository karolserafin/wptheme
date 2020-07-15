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

<p><?php _e( 'Dziękujemy za zamówienie w wctheme Patisserie & Chocolaterie. Właśnie szykujemy Twoje zamówienie! Wkrótce powiadomimy Cię o dalszych krokach. Mamy nadzieję, że będzie pysznie!', 'wctheme' ); ?></p>

<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>

<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );

