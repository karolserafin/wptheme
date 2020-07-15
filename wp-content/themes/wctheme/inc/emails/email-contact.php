<?php 

/**
 * Class WC_Contact_Email
 */
class WC_Contact_Email extends WC_Email {

	public $data = array();

	/**
	 * Create an instance of the class.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
    	
		$this->id          = 'wc_contact_email';
		$this->title       = __( 'Wiadomość z formularza kontaktowego', 'wctheme' );
		$this->description = __( 'Wiadomośc wysyłana po wypełnieniu formularza kontaktowego', 'wctheme' );

		$this->customer_email = true;
		$this->heading     = __( 'Wiadomość z formularza kontaktowego', 'wctheme' );
		$this->subject     = __( 'Wiadomość z formularza kontaktowego', 'wctheme' );
    
		$this->template_html  = 'emails/wc-contact-email.php';
		$this->template_plain = 'emails/plain/wc-contact-email.php';
		$this->template_base  = CUSTOM_WC_EMAIL_PATH . 'templates/';
    
		parent::__construct();
	}

	/**
	 * Trigger Function that will send this email to the customer.
	 *
	 * @access public
	 * @return void
	 */
	function trigger( $recipient, $subject, $name, $contact, $phone, $message ) {

		$this->data = array(
			'subject' 	=> $subject, 
			'name' 		=> $name, 
			'contact' 	=> $contact, 
			'phone' 	=> $phone, 
			'message' 	=> $message,
		);

		$this->recipient = $recipient;

		if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
			return;
		}

		return $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
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

new WC_Contact_Email();