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

	function wctheme_pickpack_shipping_method_init() {

		if ( ! class_exists( 'WC_PickPack_Shipping_Method' ) ) {

			class WC_PickPack_Shipping_Method extends WC_Shipping_Method {

				/**
		         * Constructor for your shipping class
		         *
		         * @access public
		         * @return void
		         */
		        public function __construct( $instance_id = 0 ) {
		            $this->id                 	= 'pickpack';
		            $this->instance_id          = absint( $instance_id );
		            $this->title       			= __( 'PickPack', 'wctheme' );
		            $this->method_title	 		= __( 'Kurier PickPack', 'wctheme' );
		            $this->method_description 	= __( 'Wysyłka PickPack', 'wctheme' );
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

		            add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		        }

		        /**
	             * Init form fields.
	             */
	            public function init_form_fields() {

	                $this->instance_form_fields = array(
	                    'title' 				=> array(
	                        'title'       			=> __( 'Kurier PickPack', 'wctheme' ),
	                        'type'        			=> 'text',
	                        'description' 			=> __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
	                        'default'     			=> __( 'Kurier PickPack', 'wctheme' ),
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
						'cost'       			=> array(
							'title'             	=> __( 'Cost', 'woocommerce' ),
							'type'              	=> 'text',
							'placeholder'       	=> '',
							'description'       	=> '',
							'default'          	 	=> '0',
							'desc_tip'          	=> true,
							'sanitize_callback' 	=> array( $this, 'sanitize_cost' ),
						),
	                );
	            }

		        /**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
	                $this->add_rate( array(
	                    'label'   	=> $this->title,
	                    'package' 	=> $package,
	                    'cost' 		=> $this->cost,
	                ) );
	            }
			}			

		}

	}

	add_action( 'woocommerce_shipping_init', 'wctheme_pickpack_shipping_method_init' );

	function wctheme_add_pickpack_shipping_method( $methods ) {
	    $methods['pickpack'] = 'WC_PickPack_Shipping_Method'; 
	    return $methods;
	}

	add_filter( 'woocommerce_shipping_methods', 'wctheme_add_pickpack_shipping_method' );

}