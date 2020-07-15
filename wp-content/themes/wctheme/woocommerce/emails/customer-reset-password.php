<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php _e( 'Dzień dobry!', 'wctheme' ); ?></p>

<p><?php _e( 'Dziękujemy za wiadomość. Poniżej znajdziesz link, który pozwoli Ci zresetować hasło. Gdy już to zrobisz, możesz dalej korzystać ze swojego konta w sklepie wctheme i zamawiać nasze słodkości :)', 'wctheme' ); ?></p>

<p>
	<a class="link" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>"><?php // phpcs:ignore ?>
		<?php esc_html_e( 'Click here to reset your password', 'woocommerce' ); ?>
	</a>
</p>

<p><?php _e( 'Smacznego!', 'wctheme' ) ?></p>
<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>

<?php
do_action( 'woocommerce_email_footer', $email );
