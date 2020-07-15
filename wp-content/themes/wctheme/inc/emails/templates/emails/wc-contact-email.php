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

	<h2><?php _e( 'Nowa wiadomośc z formularza kontaktowego' ); ?></h2>
	<p>
		<strong><?php _e( 'Temat wiadomości: ', 'wctheme' ); ?></strong><?php echo $data['subject']; ?>
	</p>
	<p>
		<strong><?php _e( 'Imie i nazwisko lub nazwa firmy: ', 'wctheme' ); ?></strong><?php echo $data['name']; ?>
	</p>
	<p>
		<strong><?php _e( 'Adres e-mail: ', 'wctheme' ); ?></strong><?php echo $data['contact']; ?>
	</p>
	<p>
		<strong><?php _e( 'Numer telefonu: ', 'wctheme' ); ?></strong><?php echo $data['phone']; ?>
	</p>
	<p>
		<strong><?php _e( 'Wiadomość', 'wctheme' ); ?></strong><br>
		<?php echo $data['message']; ?>
	</p>

<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );

