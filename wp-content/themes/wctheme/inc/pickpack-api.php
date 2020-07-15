<?php

class PickPackAPI {

	/**
	 *	API host
	 *	string
	 *
	 */
	private $host;

	/**
	 *	API testmode
	 *	bool
	 *
	 */
	private $test;

	/**
	 *	API user
	 *	string
	 *
	 */
	private $user;

	/**
	 *	API password
	 *	string
	 *
	 */
	private $password;

	/**
	 *	API ClientID
	 *	string
	 *
	 */
	private $clientId;

	/**
	 *	API ClientSecret
	 *	string
	 *
	 */
	private $clientSecret;

	/**
	 *	cURL instance
	 *
	 */
	protected $curl;

	/**
	 *	class constructor
	 *
	 *
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 *	init
	 *	setup all connection data
	 *	
	 *	@return void
	 *
	 */
	public function init() {

		$this->host = 'https://api.pickpack.com';

		$this->test 			= get_field( 'pickpack_test', 'options' );
		$this->user 			= get_field( 'pickpack_user', 'options' );
		$this->password 		= get_field( 'pickpack_password', 'options' );
		$this->clientId 		= get_field( 'pickpack_clientid', 'options' );
		$this->clientSecret 	= get_field( 'pickpack_clientsecret', 'options' );

		if ( $this->test ) {
			$this->host = 'https://dev-api.pickpack.com';
		}

	}

	public function auth() {

		$this->curl = curl_init();

		curl_setopt( $this->curl, CURLOPT_URL, $this->host . '/authorization/oauth2/token#PasswordGrant' );
		curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, false );

		curl_setopt( $this->curl, CURLOPT_POSTFIELDS, array(
			"grant_type" 		=> "password",
		  	"username" 			=> $this->user,
		  	"password" 			=> $this->password,
		  	"client_id" 		=> $this->clientId,
		  	"client_secret" 	=> $this->clientSecret,
		) );

		$data 		= curl_exec( $this->curl );

		curl_close( $this->curl );

		$response = json_decode( $data );

		if ( !$response->access_token ) {
			add_action( 'admin_notices', array( $this, 'wp_admin_auth_notice' ) );
		}

		return $response->access_token;

	}

	public function wp_admin_auth_notice( $message ) {
		?>
       	<div class="notice notice-error">
          	<p><?php _e( 'Wystapił błąd podczas autoryzacji z API PickPack. Sprawdź konfigurację lub spróbuj ponownie później.', 'wctheme' ); ?></p>
       	</div>
       	<?php
	}

	public function create_parcel_for_order( $order_id ) {

		$auth_header 	= $this->auth();
		$parcel_data 	= $this->create_parcel_object_from_order( $order_id );
		$data_string 	= json_encode( $parcel_data );

		$headers = array(
			'Content-Type: application/json',
	    	sprintf('Authorization: %s', $auth_header)
	  	);

		$this->curl 	= curl_init();

		curl_setopt( $this->curl, CURLOPT_URL, $this->host . '/parcel/v1/parcels/simple' );
		curl_setopt( $this->curl, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $this->curl, CURLOPT_POSTFIELDS, $data_string );

		$data 		= curl_exec( $this->curl );

		curl_close( $this->curl );
		$response = json_decode( $data );

		return $response;

	}

	public function create_parcel_object_from_order( $order_id ) {

		$wc_order 	= new WC_Order( $order_id );

		$parcel = array(
			"type"					=> "letter",
			"external_id"			=> "order_" . $order_id,
			"cod"					=> array(
			    "value"					=> $wc_order->get_total(),
			    "currency"				=> $wc_order->get_currency(),
			),
			"pickup_time_slot"		=> array(
			    "from"					=> "2020-05-04 11:00",
			    "to"					=> "2020-05-04 13:00",
			    "asap"					=> true,
			    "specific"				=> false
			),
			"delivery_time_slot"	=> array(
			    "from"					=> "2020-05-04 16:00",
			    "to"					=> "2020-05-04 18:00",
			    "asap"					=> false,
			    "specific"				=> false
			),
			"pickup_location"		=> array(
			    "name"					=> get_field( "company_name", "options" ),
			    "company_name"			=> get_field( "company_name", "options" ),
			    "street"				=> get_field( "street", "options" ),
			    "city"					=> get_field( "city", "options" ),
			    "number"				=> get_field( "number", "options" ),
			    "local_number"			=> get_field( "local_number", "options" ),
			    "post_code"				=> get_field( "post_code", "options" ),
			    "phone_number"			=> get_field( "phone_number", "options" ),
			),
			"delivery_location"		=> array(
			    "name"					=> $wc_order->get_shipping_first_name(),
			    "company_name"			=> $wc_order->get_shipping_first_name() . ' ' . $wc_order->get_shipping_last_name(),
			    "street"				=> $wc_order->get_shipping_address_1(),
			    "city"					=> $wc_order->get_shipping_city(),
			    "number"				=> "75",
			    "local_number"			=> "",
			    "post_code"				=> $wc_order->get_shipping_postcode(),
			    "phone_number"			=> $wc_order->get_billing_phone(),
			),
			"note"						=> wp_kses_post( nl2br( wptexturize( $wc_order->get_customer_note() ) ) ),
			"additional_services"		=> array(
			    "freezer",
			)
		);

		return $parcel;

	}

}
