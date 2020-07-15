<?php 

/**
 * Class WC_Payment_Error_Email
 */
class WC_Order_In_Progress_Email extends WC_Email {

	/**
	 * Create an instance of the class.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
    	
		$this->id          = 'wc_payment_error_email';
		$this->title       = __( 'Zamówienie jest w trakcie realizacji', 'wctheme' );
		$this->description = __( 'Wiadomośc wysyłana po zmianie statusu zamówienia na "W trakcie realizacji"', 'wctheme' );

		$this->customer_email = true;
		$this->heading     = __( 'W trakcie realizacji', 'wctheme' );
		$this->subject     = __( 'W trakcie realizacji', 'wctheme' );
    
		$this->template_html  = 'emails/wc-order-in-progress.php';
		$this->template_plain = 'emails/plain/wc-order-in-progress.php';
		$this->template_base  = CUSTOM_WC_EMAIL_PATH . 'templates/';
    
		parent::__construct();
	}

	/**
	 * Trigger Function that will send this email to the customer.
	 *
	 * @access public
	 * @return void
	 */
	function trigger( $order_id ) {
		$this->object = wc_get_order( $order_id );

		if ( version_compare( '3.0.0', WC()->version, '>' ) ) {
			$order_email = $this->object->billing_email;
		} else {
			$order_email = $this->object->get_billing_email();
		}

		$this->recipient = $order_email;


		if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
			return;
		}

		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
	}

	/**
	 * Get content html.
	 *
	 * @access public
	 * @return string
	 */
	public function get_content_html() {
		return wc_get_template_html( $this->template_html, array(
			'data'          => $this->data,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => false,
			'plain_text'    => false,
			'email'			=> $this
		), '', $this->template_base );
	}

	/**
	 * Get content plain.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		return wc_get_template_html( $this->template_plain, array(
			'data'          => $this->data,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => false,
			'plain_text'    => true,
			'email'			=> $this
		), '', $this->template_base );
	}
}

new WC_payment_error_Email();