<?php 

/**
 * Class wctheme_WC_Email
 */
class wctheme_WC_Email {

	/**
	 * wctheme_WC_Email constructor.
	 */
	public function __construct() {

		add_filter( 'woocommerce_email_classes', array( $this, 'register_email' ), 90, 1 );
		define( 'CUSTOM_WC_EMAIL_PATH', plugin_dir_path( __FILE__ ) );

	}

	/**
	 * @param array $emails
	 *
	 * @return array
	 */
	public function register_email( $emails ) {

		require get_template_directory() . '/inc/emails/email-contact.php';
		require get_template_directory() . '/inc/emails/wc-payment-error.php';
		require get_template_directory() . '/inc/emails/wc-ready-to-pickup.php';
		require get_template_directory() . '/inc/emails/wc-shipping.php';
		require get_template_directory() . '/inc/emails/wc-in-progress.php';

		$emails['WC_Contact_Email'] = new WC_Contact_Email();
		$emails['WC_Payment_Error_Email'] = new WC_Payment_Error_Email();
		$emails['WC_Customer_Pickup'] = new WC_Customer_Pickup();
		$emails['WC_Order_In_Shiping'] = new WC_Order_In_Shiping();
		$emails['WC_Order_In_Progress'] = new WC_Order_In_Progress_Email();

		return $emails;
		
	}
}

new wctheme_WC_Email();