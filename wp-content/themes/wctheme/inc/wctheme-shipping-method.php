<?php
/**
 *	PickPack shipping method
 *
 *
 *
 *
 */

/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	function wctheme_free_shipping_method_init() {

		if ( ! class_exists( 'WC_wctheme_Free_Shipping_Method' ) ) {

			class WC_wctheme_Free_Shipping_Method extends WC_Shipping_Method {

				/**
		         * Constructor for your shipping class
		         *
		         * @access public
		         * @return void
		         */
		        public function __construct( $instance_id = 0 ) {
		            $this->id                 	= 'wctheme_free_shipping';
		            $this->instance_id          = absint( $instance_id );
		            $this->title       			= __( 'Darmowa dostawa', 'wctheme' );
		            $this->method_title	 		= __( 'Darmowa dostawa wctheme', 'wctheme' );
		            $this->method_description 	= __( 'Darmowa dostawa realizowana przez wctheme', 'wctheme' );
		            $this->enabled            	= $this->get_option( 'enabled' );
		            $this->instance_form_fields = array(
						'enabled' => array(
							'title' 		=> __( 'Enable/Disable' ),
							'type' 			=> 'checkbox',
							'label' 		=> __( 'Enable this shipping method' ),
							'default' 		=> 'yes',
						),
						'title' => array(
							'title' 		=> __( 'Method Title' ),
							'type' 			=> 'text',
							'description' 	=> __( 'This controls the title which the user sees during checkout.' ),
							'default'		=> __( 'Test Method' ),
							'desc_tip'		=> true
						),
					);
		            $this->supports     = array(
	                    'shipping-zones',
	                    'instance-settings',
	                    'instance-settings-modal',
	                );
		            $this->init();
		        }

		        /**
		         * Init your settings
		         *
		         * @access public
		         * @return void
		         */
		        function init() {

		            $this->init_form_fields();
		            $this->init_settings();
		            $this->cost             = $this->get_option( 'cost' );
		            $this->title            = $this->get_option( 'title' );

		            // Save settings in admin if you have any defined
		            add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		        }

		        /**
	             * Init form fields.
	             */
	            public function init_form_fields() {

	                $this->instance_form_fields = array(
	                    'title' 				=> array(
	                        'title'       			=> __( 'Darmowa dostawa wctheme', 'wctheme' ),
	                        'type'        			=> 'text',
	                        'description' 			=> __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
	                        'default'     			=> __( 'Darmowa dostawa wctheme', 'wctheme' ),
	                        'desc_tip'    			=> true,
	                    ),
	                    'tax_status' 			=> array(
							'title'   				=> __( 'Tax status', 'woocommerce' ),
							'type'    				=> 'select',
							'class'   				=> 'wc-enhanced-select',
							'default' 				=> 'taxable',
							'options' 				=> array(
								'taxable' 				=> __( 'Taxable', 'woocommerce' ),
								'none'    				=> _x( 'None', 'Tax status', 'woocommerce' ),
							),
						),
						'start' 				=> array(
							'title'   				=> __( 'Data rozpoczęcia', 'wctheme' ),
							'type'    				=> 'text',
							'placeholder' 			=> __( 'Data w formacie dd-mm-rrrr' ),
							'default' 				=> date( 'd-m-Y' ),
						),
						'end' 					=> array(
							'title'   				=> __( 'Data zakończenia', 'wctheme' ),
							'type'    				=> 'text',
							'placeholder' 			=> __( 'Data w formacie dd-mm-rrrr' ),
							'default' 				=> date( 'd-m-Y' ),
						),
						'free_shipping' 		=> array(
							'title'   				=> __( 'Darmowa wysyłka od kwoty', 'wctheme' ),
							'type'    				=> 'text',
							'type'              	=> 'text',
							'placeholder'       	=> '',
							'description'       	=> __( 'Kwota zamówienia od jakiej przysługuje darmowa wysyłka', 'wctheme' ),
							'default'          	 	=> '0',
							'desc_tip'          	=> true,
						),
	                );
	            }

		        /**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $packagea
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {

					$this->add_rate( array(
	                    'label'   	=> $this->title,
	                    'package' 	=> $package,
	                    'cost' 		=> 0,
	                ) );
	                
	            }

	            public function is_available( $package ) {

	            	$available 	= false;
					$total 		= WC()->cart->cart_contents_total;

					if ( $total >= $this->get_option( 'free_shipping' ) ) {
						$available = true;
					}

					return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', $available, $package, $this );
				}

			}

		}

	}

	add_action( 'woocommerce_shipping_init', 'wctheme_free_shipping_method_init' );

	function wctheme_add_wctheme_free_shipping_method( $methods ) {
	    $methods['wctheme_free_shipping'] = 'WC_wctheme_Free_Shipping_Method';
	    return $methods;
	}

	add_filter( 'woocommerce_shipping_methods', 'wctheme_add_wctheme_free_shipping_method' );

}
