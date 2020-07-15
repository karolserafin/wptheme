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

<p><?php _e( 'Wiemy, że próbowałeś/próbowałaś zamówić słodkości z wctheme Patisserie & Chocolaterie. Niestety wystąpił BŁĄD PŁATNOŚCI i Twoje zamówienie nie zostało sfinalizowane. Spróbuj dokonać płatności ponownie, bo chcielibyśmy osłodzić Twój dzień :)', 'wctheme' ); ?></p>

<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>

<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );

