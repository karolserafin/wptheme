<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

if ( ! class_exists( 'wcthemeWooCommerce' ) ) :

class wcthemeWooCommerce {

	public $data;

	private $pickpack;

	public function __construct() {

		// $this->pickpack = new PickPackAPI();

		/**
		 * 	Remove actions to reorder it
		 */
		remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 80 );
		add_action( 'woocommerce_after_variations_form', 'woocommerce_single_variation_add_to_cart_button', 90 );
		add_action( 'wctheme_woocommerce_single_product_title', 'woocommerce_template_single_title', 5 );
		add_action( 'wctheme_woocommerce_single_product_title', 'woocommerce_template_single_price', 10 );

		add_action( 'woocommerce_single_product_summary', array( $this, 'wctheme_product_shipping_informations' ), 20 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wctheme_product_allergical_informations' ), 30 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wctheme_display_product_subproducts' ), 20 );
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'wctheme_display_product_labels' ), 10 );
		add_action( 'woocommerce_product_card_labels', array( $this, 'wctheme_display_product_labels' ), 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'wctheme_display_product_labels' ), 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'wctheme_display_product_short_description' ), 10 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'wctheme_display_product_title' ), 10 );

		/**
		 *	AddCustom actions
		 *
		 */
		add_action( 'woocommerce_variation_options_pricing', array( $this, 'wctheme_add_product_additional_informations' ), 10, 3 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'wctheme_save_product_additional_informations' ), 10, 2 );
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'wctheme_add_product_cake_text_field' ), 10 );
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'wctheme_add_product_presentpack_text_field' ), 10 );
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'wctheme_add_additional_info_above_flavour' ), 10 );
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'wctheme_add_product_flavour_fields' ), 10 );
		add_filter( 'woocommerce_show_page_title', '__return_true', 1 );

		add_filter( 'woocommerce_available_variation', array( $this, 'wctheme_load_variation_settings_field' ), 10, 1 );
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'wctheme_add_cake_text_to_cart_item' ), 10, 3 );
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'wctheme_add_presentpack_to_cart_item' ), 20, 3 );
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'wctheme_add_product_flavour_to_cart_item' ), 30, 3 );
		add_filter( 'woocommerce_get_item_data', array( $this, 'wctheme_display_cake_text' ), 10, 2 );
		add_filter( 'woocommerce_get_item_data', array( $this, 'wctheme_display_presentpack' ), 10, 2 );
		add_filter( 'woocommerce_get_item_data', array( $this, 'wctheme_display_product_flavour' ), 10, 2 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'wctheme_product_add_to_cart_validation' ), 20, 4 );


		/**
		 *	Cart & Checkout
		 *
		 *
		 */
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
        remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

		add_action( 'wctheme_woocomerce_shipping_coupon', 'woocommerce_checkout_coupon_form', 10 );
        add_action( 'wctheme_woocommerce_pay_button', 'woocommerce_checkout_payment', 10 );
        add_action( 'woocommerce_before_cart', array( $this, 'wctheme_delete_remove_product_notice' ), 5 );

        add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
        add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'wctheme_remove_shipping_method_price' ), 10, 2 );

        add_action( 'woocommerce_checkout_fields', array( $this, 'wctheme_override_checkout_fields' ), 10 );
		add_action( 'woocommerce_checkout_process', array( $this, 'wctheme_checkout_fields_validation' ), 10 );
        add_action( 'woocommerce_default_address_fields', array( $this, 'wctheme_override_address_fields' ), 10 );
		add_action( 'woocommerce_order_review_shipping', array( $this, 'display_current_shipping_method_cost' ) );
        add_action( 'woocommerce_update_order_review_fragments', array( $this, 'wctheme_custom_shipping_table_update' ), 10 );
		add_action( 'woocommerce_checkout_create_order', array( $this, 'wctheme_save_custom_order_data' ), 20, 1 );
        add_action( 'wp_print_scripts', array( $this, 'wctheme_remove_password_strength' ), 10 );

		/**
		 *	Fee's on checkout page
		 *
		 */
		//add_action( 'woocommerce_after_checkout_form', array( $this, 'wctheme_add_checkout_script' ) );
		add_action( 'woocommerce_cart_calculate_fees', array( $this, 'add_location_fee' ) );
		add_action( 'woocommerce_cart_calculate_fees', array( $this, 'add_cakes_fee' ) );

        add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
        add_filter( 'woocommerce_add_error', array( $this, 'wctheme_customize_error_message' ) );
        add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'wctheme_remove_shipping_method_price' ), 10, 2 );
        add_filter( 'woocommerce_form_field' , array( $this, 'wctheme_remove_checkout_optional_text' ), 10, 4 );

		/**
		 *	My Account
		 *
		 *
		 */
		add_action( 'woocommerce_account_customer-coupons_endpoint', array( $this, 'wctheme_woocommerce_add_coupons_content' ) );
		add_action( 'init', array( $this, 'wctheme_woocommerce_add_coupons_endpoint' ) );
		add_action( 'woocommerce_thankyou', array( $this, 'wctheme_save_order_coupons' ) );

		add_filter( 'woocommerce_account_menu_items', array( $this, 'wctheme_woocommerce_myaccount_navigation' ), 10, 1 );
		add_filter( 'query_vars', array( $this, 'wctheme_woocommerce_customer_coupons_query_vars' ), 0 );
		add_action( 'woocommerce_register_form', array( $this, 'wctheme_add_register_form_checkbox' ) );

		/**
		 *	Orders
		 *
		 *
		 */
		add_action( 'init', array( $this, 'wctheme_register_custom_order_statuses' ) );
		add_action( 'woocommerce_order_status_payment-error', array( $this, 'wctheme_woocommerce_handle_payment_error_status' ) );
		add_action( 'woocommerce_order_status_shipment-ready', array( $this, 'wctheme_woocommerce_handle_shippment_ready_status' ) );
		add_action( 'woocommerce_order_status_shipping', array( $this, 'wctheme_woocommerce_handle_shipping_status' ) );
		add_action( 'woocommerce_order_status_order-processing', array( $this, 'wctheme_woocommerce_handle_procesing_status' ) );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'wctheme_add_cart_item_to_order_items' ), 10, 4 );
		add_action( 'woocommerce_admin_order_item_headers', array( $this, 'wctheme_woocommerce_admin_order_item_headers' ) );
		add_action( 'woocommerce_admin_order_item_values', array( $this, 'wctheme_admin_order_item_values' ), 10, 3 );
		add_action( 'add_meta_boxes', array( $this, 'wctheme_order_to_pdf_box' ) );
		add_action( 'woocommerce_after_checkout_shipping', array( $this, 'wctheme_present_checkout_checkbox' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'wctheme_present_checkout_checkbox_update_order_meta' ) );
		add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'wctheme_diaplay_admin_order_meta' ) );
		add_action( 'woocommerce_admin_order_data_after_shipping_address', array( $this, 'wctheme_after_shipping_order' ), 10, 1 );
		add_action( 'wp_ajax_wctheme_generate_order_pdf', array( $this, 'wctheme_generate_order_pdf' ) );
		add_action( 'wp_ajax_wctheme_generate_pickpack_order', array( $this, 'wctheme_generate_pickpack_order' ) );

		add_filter( 'wc_order_statuses', array( $this, 'add_wctheme_statuses_to_order_statuses' ) );


		/**
		 *
		 *	Orders
		 *	Admin area
		 *
		 *
		 */
		add_filter( 'manage_edit-shop_order_columns', array( $this, 'wctheme_add_shipping_date_order_column' ), 20 );
		add_filter( 'manage_edit-shop_order_columns', array( $this, 'wctheme_add_shipping_location_order_column' ), 21 );

		add_action( 'manage_shop_order_posts_custom_column', array( $this,'wctheme_add_shipping_date_column_content' ) );
		add_action( 'manage_shop_order_posts_custom_column', array( $this,'wctheme_add_shipping_location_column_content' ) );

	}

	public function wctheme_load_variation_settings_field( $variation ) {
		$variation['wctheme_size'] 	 		= sprintf( __( 'średnica: <strong>%s</strong>' ), get_post_meta( $variation[ 'variation_id' ], '_label_size', true ) );
		return $variation;
	}

	public function wctheme_add_checkout_script() { ?>
		<script type="text/javascript">jQuery(document).ready(function($){$('input[name="shipping_date"]').on( 'change',function(e){jQuery(document.body).trigger("updated_checkout");});});
		</script>
	<?php }

	public function wctheme_add_product_additional_informations( $loop, $variation_data, $variation ) {

		$product 		= new WC_Product( wp_get_post_parent_id( $variation->ID ) );

		if ( ! has_term( array( 'torty' ), 'product_cat', $product->get_id() ) ) {
			return;
		}

		echo '<div class="product-variation-row">';
		woocommerce_wp_text_input(
			array(
			 	'id'          	=> '_label_size['.$loop.']',
			 	'label'       	=> __( 'Średnica tortu', 'wctheme' ),
			 	'placeholder' 	=> '',
			 	'desc_tip'    	=> 'true',
			 	'wrapper_class' => "form-field form-row form-row-first",
			 	'description' 	=> __( 'Podaj średnicę tortu razem z jednostką, bez dodatkowego nagłówka np.: 18cm, 25cm, ', 'wctheme' ),
			 	'value'         => get_post_meta( $variation->ID, '_label_size', true ),
			)
		);
		woocommerce_wp_text_input(
			array(
			 	'id'          	=> '_label_persons['.$loop.']',
			 	'label'       	=> __( 'Ilość osób', 'wctheme' ),
			 	'placeholder' 	=> '',
			 	'desc_tip'    	=> 'true',
			 	'wrapper_class' => "form-row form-row-last form-field",
			 	'description' 	=> __( 'Podaj liczbę dla jakiej ten wariant tortu jest odpowiedni np.: 5-8, 15-22', 'wctheme' ),
			 	'value'         => get_post_meta( $variation->ID, '_label_persons', true ),
			)
		);
		echo '</div>';

	}

	public function wctheme_save_product_additional_informations( $variation_id, $i ) {
	    update_post_meta( $variation_id, '_label_size', wc_clean( wp_unslash( str_replace( ',', '.', $_POST['_label_size'][$i]) ) ) );
	    update_post_meta( $variation_id, '_label_persons', wc_clean( wp_unslash( str_replace( ',', '.', $_POST['_label_persons'][$i]) ) ) );
	}

	public function wctheme_product_shipping_informations() {

		global $product;

		$available_cats = get_field( 'shipping__info__categories', 'options' );
		foreach( $available_cats as $cat ) {
			if ( has_term( $cat->slug, 'product_cat', $product->get_id() ) ) {
				the_field( 'shipping_info', 'options' );
				break;
			}
		}

		the_field( 'shipping__rules', $product->get_id() );

	}

	public function wctheme_add_shipping_date_order_column( $columns ) {

		$new_columns = array();

	    foreach ( $columns as $column_name => $column_info ) {

	        $new_columns[ $column_name ] = $column_info;

	        if ( 'order_date' === $column_name ) {
	            $new_columns['order_shipping_date'] = __( 'Data realizacji', 'wctheme' );
	        }
	    }

	    return $new_columns;

	}

	public function wctheme_add_shipping_location_order_column( $columns ) {

		$new_columns = array();

	    foreach ( $columns as $column_name => $column_info ) {

	        $new_columns[ $column_name ] = $column_info;

	        if ( 'order_shipping_date' === $column_name ) {
	            $new_columns['order_shipping_location'] = __( 'Miejsce realizacji lub sposób wysyłki', 'wctheme' );
	        }
	    }

	    return $new_columns;

	}

	public function wctheme_add_shipping_date_column_content( $column ) {
		global $post;

		if ( 'order_shipping_date' === $column ) {
			$order    = wc_get_order( $post->ID );

			foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ):

				if ( 'local_pickup' == $shipping_item_obj->get_method_id() || 'wctheme_free_shipping' == $shipping_item_obj->get_method_id() || 'pickpack' == $shipping_item_obj->get_method_id() ) :
					$time = strtotime( get_post_meta( $order->get_order_number(), '_wctheme_shipping_date', true ) );
					echo date( 'd.m.Y', $time );
				endif;

			endforeach;

		}

	}

	public function wctheme_add_shipping_location_column_content( $column ) {
		global $post;

		if ( 'order_shipping_location' === $column ) {
			$order    = wc_get_order( $post->ID );

			foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) :

				if ( 'local_pickup' == $shipping_item_obj->get_method_id() ) :
					echo get_the_title( get_post_meta( $order->get_order_number(), '_wctheme_pickup_location', true ) );
				endif;

				if ( 'wctheme_free_shipping' == $shipping_item_obj->get_method_id() ) :
					echo __( 'Darmowa wysyłka wctheme', 'wctheme' );
				endif;

				if ( 'pickpack' == $shipping_item_obj->get_method_id() ) :
					echo __( 'Pickpack', 'wctheme' );
				endif;

				if ( 'flat_rate' == $shipping_item_obj->get_method_id() ) :
					echo __( 'Kurier DHL', 'wctheme' );
				endif;

			endforeach;
		}
	}

	public function wctheme_delete_remove_product_notice(){
		$notices = WC()->session->get('wc_notices', array());

		if ( !empty( $notices ) ) {
			foreach( $notices['success'] as $key => &$notice){
		        if( strpos( $notice, 'Usunięto' ) !== false) {
		            $added_to_cart_key = $key;
		            break;
		        }
		    }
		    unset( $notices['success'][$added_to_cart_key] );

		    WC()->session->set('wc_notices', $notices);
		}
	    
	}

	public function wctheme_product_allergical_informations() {

		global $product;

		$allergens 	= get_field( 'alergens', $product->get_id() );
		$return 	= '';
		$allergenscontainer = '<div>';

		if ( $allergens ) {

			$allergenscontainer = '<div class="allergens-container">';

			$return = '<h5>' . __( 'Alergeny', 'wctheme' ) . '</h5>';

			foreach( $allergens as $allergen ) {
				$return .= get_term( $allergen )->name . ', ';
			}

		}

		echo $allergenscontainer . rtrim( $return, ', ' ) . '</div>';

	}

	public function wctheme_add_product_cake_text_field() {

		global $product;

		if ( ! get_field( 'is_cake_text', $product->get_id() ) ) {
			return;
		}

		?>
			<div class="cake-text-container">
				<label for="cake_text"><?php _e( 'Wpisz tekst, który znajdzie się na torcie', 'wctheme' ); ?></label>
				<textarea placeholder="<?php _e( 'Tutaj wpisz teskt...', 'wctheme' ); ?>" name="cake_text" id="cake_text" cols="30" rows="10" maxlength="100"></textarea>
			</div>
		<?php

	}

	public function wctheme_add_product_presentpack_text_field() {

		global $product;

		if ( ! has_term( array( 'zestawy-prezentowe' ), 'product_cat', $product->get_id() ) ) {
			return;
		}

		?>
			<div class="cake-text-container">
				<label for="presentpack"><?php _e( 'Wpisz komentarz do zestawu prezentowego', 'wctheme' ); ?></label>
				<textarea placeholder="<?php _e( 'Tutaj wpisz teskt...', 'wctheme' ); ?>" name="presentpack" id="presentpack" cols="30" rows="10" maxlength="100"></textarea>
			</div>
		<?php

	}

	public function wctheme_add_cake_text_to_cart_item( $cart_item_data, $product_id, $variation_id ) {

		$cake_text = filter_input( INPUT_POST, 'cake_text' );

	    if ( empty( $cake_text ) ) {
	        return $cart_item_data;
	    }

	    $cart_item_data['cake_text'] = $cake_text;

	    return $cart_item_data;

	}

	public function wctheme_add_presentpack_to_cart_item( $cart_item_data, $product_id, $variation_id ) {

		$presentpack = filter_input( INPUT_POST, 'presentpack' );

	    if ( empty( $presentpack ) ) {
	        return $cart_item_data;
	    }

	    $cart_item_data['presentpack'] = $presentpack;

	    return $cart_item_data;

	}

	public function wctheme_display_cake_text( $item_data, $cart_item ) {
	    if ( empty( $cart_item['cake_text'] ) ) {
	        return $item_data;
	    }

	    $item_data[] = array(
	        'key'     => __( 'Treść', 'wctheme' ),
	        'value'   => wc_clean( $cart_item['cake_text'] ),
	        'display' => '',
	    );

	    return $item_data;

	}

	public function wctheme_display_presentpack( $item_data, $cart_item ) {
	    if ( empty( $cart_item['presentpack'] ) ) {
	        return $item_data;
	    }

	    $item_data[] = array(
	        'key'     => __( 'Komentarz', 'wctheme' ),
	        'value'   => wc_clean( $cart_item['presentpack'] ),
	        'display' => '',
	    );

	    return $item_data;

	}

	public function wctheme_display_product_labels() {

		global $post, $product;

		$labels 	= get_field( 'labels', $product->get_id() );
		$return 	= '<div class="product__labels">';

		?>
		<?php if ( $product->is_on_sale() ) : ?>

			<?php $return .= apply_filters( 'woocommerce_sale_flash', '<div class="product__label onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</div>', $post, $product ); ?>

		<?php
		endif;

		if ( !$product->managing_stock() && !$product->is_in_stock() ): ?>
			
			<?php $return .= '<div class="product__label out_of_stock">' . esc_html__( 'Out of stock', 'woocommerce' ) . '</div>'; ?>

		<?php 
		endif;

		if ( $labels ) {
			foreach( $labels as $label ) {
				$return .= '<div class="product__label" style="background-color:'.get_field( 'color', $label ).'">'.get_the_title( $label ) .'</div>';
			}
		}

		$return 	.= '</div>';
		echo $return;

	}

	public function wctheme_display_product_short_description() {
		global $product;
		echo '<div class="product__description">' . $product->get_short_description() . '</div>';
	}

	public function wctheme_display_product_title() {
    	echo '<h4 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'product__title' ) ) . '">' . get_the_title() . '</h4>';
	}

	

	public function wctheme_add_register_form_checkbox() {
		?>

			<p class="form-row " id="wctheme_present_field">
				<span class="woocommerce-input-wrapper">
					<label class="checkbox form__checkbox">
						<input type="checkbox" name="wctheme_present" id="wctheme_present" value="1" required>
						<?php printf( __( 'Przeczytałem/am i akceptuję <a href="%s">Regulamin sklepu</a>', 'wctheme' ), get_permalink( wc_get_page_id( 'terms' ) ) ) ?>
						<span></span>
					</label>
				</span>
			</p>


		<?php
	}

	public function wctheme_display_product_subproducts() {
		global $product;

		if ( ! get_field( 'subproducts', $product->get_id() ) ) {
			return;
		}

		$limit 			= get_field( 'product__subproducts__limit', $product->get_id() );
		$subproducts 	= get_field( 'product__subproducts', $product->get_id() );
		$return 		= '';
		$products 		= array();

		if ( $subproducts ) {

			$return = '<h5>' . __( 'Wybierz smaki', 'wctheme' ) . '</h5>';

			foreach( $subproducts as $sub ) {
				$wc_product = new WC_Product( $sub );

				if ( $wc_product->get_stock_quantity() && $wc_product->get_stock_quantity() >= $limit ) {
					$return .= '<p><strong>' . $wc_product->get_name() . '</strong> - ' . $wc_product->get_short_description() . '</p>';
				}
			}

		}

		echo '<div class="choose-flavors">' .  $return . '</div>';

	}

	public function wctheme_product_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id=null ) {

		if ( ! empty( $_REQUEST['flavour'] ) ) {

			$flavours 				= $_REQUEST['flavour'];

			$limit 					= get_field( 'product__subproducts__limit', $product_id );
			$available_flavours 	= get_field( 'product__subproducts', $product_id );
			$available 				= array();
			$total 					= 0;

			$terms = get_the_terms ( $product_id, 'product_cat' );
			foreach ( $terms as $term ) {
     			$cat_slug = $term->slug;
			}

			foreach ( $available_flavours as $flavour ) {
				$wc_product = new WC_Product( $flavour );

				if ( $wc_product->get_stock_quantity() && $wc_product->get_stock_quantity() >= $limit ) {

					$added_flavour 	 = $flavours[$wc_product->get_slug()];
		 			$total 			+= (int) $added_flavour;

				}

			}


			if ( $cat_slug == 'praliny' ) {

				// Custom text for "Praliny"

				if ( $total > $limit ) {
					wc_add_notice( sprintf( __( 'Za duża liczba wybranych pralin. Maksymalnie możesz wybrać <strong>%d</strong> sztuk.', 'wctheme' ), $limit ), 'notice' );
					$passed = false;
				}

				if ( $total < $limit ) {
					wc_add_notice( sprintf( __( 'Za mała ilość wybranych pralin. Maksymalnie możesz wybrać <strong>%d</strong> sztuk.', 'wctheme' ), $limit ), 'notice' );
					$passed = false;
				}

			} else {

				if ( $total > $limit ) {
					wc_add_notice( sprintf( __( 'Za duża ilość wybranych smaków. Maksymalna ilość wszystkich smaków do wyboru to <strong>%d</strong> sztuk', 'wctheme' ), $limit ), 'notice' );
					$passed = false;
				}

				if ( $total < $limit ) {
					wc_add_notice( sprintf( __( 'Za mała ilość wybranych smaków. Maksymalna ilość wszystkich smaków do wyboru to <strong>%d</strong> sztuk', 'wctheme' ), $limit ), 'notice' );
					$passed = false;
				}

			}


			if ( $total == $limit ) {
				$passed = true;
			}

		}

		if ( isset( $_REQUEST['presentpack'] ) ) {

			$presentpack 	= $_REQUEST['presentpack'];

			if ( ! strlen( $presentpack ) ) {
				wc_add_notice( __( 'Wpisz komentarz do zestawu prezentowego.', 'wctheme' ), 'notice' );
				$passed = false;
			} else {
				$passed = true;
			}

		}

		if ( isset( $_REQUEST['cake_text'] ) ) {

			$cake_text 		= $_REQUEST['cake_text'];

			if ( ! strlen( $cake_text ) ) {
				wc_add_notice( __( 'Podaj treść napisu.', 'wctheme' ), 'notice' );
				$passed = false;
			} else {
				$cake_in_cart = false;

				foreach( WC()->cart->get_cart() as $cart_item ) {
			      	if ( has_term( 'torty', 'product_cat', $cart_item['product_id'] ) ) {
				        $cake_in_cart = true;
				        break;
				    }
			   	}

			   	if ( ! $cake_in_cart ) {
			   		wc_add_notice( __( 'Aby dodac napis na tort musisz najpierw dodac tort do koszyka', 'wctheme' ), 'notice' );
					$passed = false;
			   	} else {
			   		$passed = true;
			   	}
			}

		}

		return $passed;

	}

	public function wctheme_add_additional_info_above_flavour() {

		global $product;

		$product_id = $product->get_id();
		$description_above_flavours = get_field('description_above_flavours', $product_id);

		if ( $description_above_flavours ) { ?>
		
		<div class="flavour-description">
			<?php echo $description_above_flavours; ?>
		</div>

		<?php }

	}

	public function wctheme_add_product_flavour_fields() {

		global $product;

		if ( ! get_field( 'subproducts', $product->get_id() ) ) {
			return;
		}

		$limit 			= get_field( 'product__subproducts__limit', $product->get_id() );
		$subproducts 	= get_field( 'product__subproducts', $product->get_id() );

		if ( $subproducts ) { ?>
			
			<div class="flavour-container">
			
			<?php
			foreach( $subproducts as $sub ) {
				$wc_product = new WC_Product( $sub );


				if ( $wc_product->get_stock_quantity() && $wc_product->get_stock_quantity() >= $limit ) {

					?>
						<div class="flavour-container__item">
						<h6><?php echo $wc_product->get_name(); ?></h6>
							<select name="flavour[<?php echo $wc_product->get_slug(); ?>]" id="flavour_<?php echo $wc_product->get_slug(); ?>" data-limit="<?php echo $limit; ?>">
								<?php for ($i=0; $i <= $limit; $i++) : ?>

									<option value="<?php echo $i; ?>" <?php if ( isset( $_REQUEST['flavour'] ) && $_REQUEST['flavour'][$wc_product->get_slug()] && $_REQUEST['flavour'][$wc_product->get_slug()] == $i ) : ?>selected<?php endif; ?>>
										<?php echo $i . __( ' szt.', 'wctheme' ); ?>
									</option>

								<?php endfor; ?>
							</select>

						</div>
					<?php

				}
			} ?>

			</div>
			
		<?php }

	}

	public function wctheme_add_product_flavour_to_cart_item( $cart_item_data, $product_id, $variation_id ) {

		if ( !empty( $_POST['flavour'] ) ) {

			$flavours 	= $_POST['flavour'];

			$limit 						= get_field( 'product__subproducts__limit', $product_id );
			$available_flavours 		= get_field( 'product__subproducts', $product_id );
			$available 					= array();
			$cart_item_data['flavour'] 	= array();

			foreach ( $available_flavours as $flavour ) {
		 		$wc_product = new WC_Product( $flavour );

		 		if ( $wc_product->get_stock_quantity() && $wc_product->get_stock_quantity() >= $limit ) {

					$added_flavour = $flavours[$wc_product->get_slug()];

				    $selected_flavour 	= array(
				    	'id' 				=> $wc_product->get_id(),
				    	'name' 				=> $wc_product->get_name(),
				    	'quantity' 			=> $added_flavour,
				    );

				    $cart_item_data['flavour'][] = $selected_flavour;

				}

		 	}

		}

		return $cart_item_data;

	}

	public function wctheme_display_product_flavour( $item_data, $cart_item ) {
	    if ( empty( $cart_item['flavour'] ) ) {
	        return $item_data;
	    }

	    $flavours = '';

	    foreach ( $cart_item['flavour'] as $flavour ) {
	    	if ( $flavour['quantity'] > 0 ) {
	    		$flavours .= $flavour['name'] . ': ' . $flavour['quantity'] . ' szt.<br>';
	    	}
	    }

	    $item_data[] = array(
	        'key'     => __( 'Wybrane smaki', 'wctheme' ),
	        'value'   => '<br>' . $flavours,
	        'display' => '',
	    );

	    return $item_data;

	}

	public function wctheme_remove_required_fields( $field ) {

		$field['billing']['billing_first_name']['required'] 	= false;
		$field['billing']['billing_last_name']['required'] 		= false;
		$field['billing']['billing_address_1']['required'] 		= false;
		$field['billing']['billing_city']['required'] 			= false;
		$field['billing']['billing_phone']['required'] 			= false;
		$field['billing']['billing_email']['required'] 			= false;
		$field['billing']['billing_postcode']['required'] 		= false;

		unset($fields['billing']['billing_postcode']['validate']);
    	unset($fields['shipping']['shipping_postcode']['validate']);

		return $field;

	}

	public function wctheme_customize_error_message( $error ) {
	    if ( strpos( $error, 'Billing ' ) !== false ) {
	        $error = str_replace("Billing ", "", $error);
	    }
	    if ( strpos( $error, 'Shipping ' ) !== false ) {
	        $error = str_replace("Shipping ", "", $error);
	    }
	    return $error;
	}

	public function wctheme_checkout_fields_validation() {

		$failure 						= false;
		$post_code 						= $_POST['postal_code'];
		$shipping_date 					= $_POST['shipping_date'];
		$shipping_time 					= $_POST['shipping_time'];
		$shipping_disabled_categories 	= get_field( 'disabled_categories_in_shipping', 'options' );

		if ( !$post_code ) {
			wc_add_notice( 'Kod pocztowy jest polem wymaganym.', 'error' );
			add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ), 100 );
			$failure = true;
			return;
		}

		if ( ! $shipping_disabled_categories ) {
			return;
		}

		if ( $_POST['validate'] && $_POST['validate'] === 'false' ) {
			wc_add_notice( 'Sposoby dostawy zamówienia zostały dostosowane do Twojego kodu pocztowego', 'success' );
			add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
			$failure = true;
			return;
		}

		// if ( $_POST['account_email'] ) {

		// 	if ( !filter_var( $_POST['account_email'], FILTER_VALIDATE_EMAIL ) ) {
		// 		wc_add_notice( __( 'Podaj prawidłowy adres e-mail, na który chcesz założyć nowe konto.', 'wctheme' ), 'error' );
		// 	}

		// }

		/**
		 *	Sprawdzanie warunków na produkty w koszyku
		 *
		 */
		foreach( WC()->cart->get_cart() as $cart_item ) {

	        $enabled    = get_post_meta( $cart_item['product_id'], 'wpas_schedule_sale_status', true );
	        $start      = get_post_meta( $cart_item['product_id'], 'wpas_schedule_order_st_time', true );
	        $end        = get_post_meta( $cart_item['product_id'], 'wpas_schedule_order_end_time', true );

	        /**
	         *	Sprawdzanie czy jest ustawiona i ograniczona dostępnośc czasowa dla jakiegoś produktu
	         *
	         */
	        if ( $enabled && $start && $end ) {
		        if ( strtotime( $_POST['shipping_date'] ) > $end || strtotime( $_POST['shipping_date'] ) < $start ) {
		        	$products_string 	= sprintf( '<a href="%s">%s</a>', get_permalink( $cart_item['product_id'] ), get_the_title( $cart_item['product_id'] ) );

		        	wc_add_notice( sprintf( __( 'W Twoim koszyku znajduje się produkt sezonowy -  %s, można go zamówić w określonym zakresie czasowym tj. od %s do %s. Zmień termin dostawy lub usuń ten produkt z koszyka. ', 'wctheme' ), $products_string, date( 'd-m-Y', $start ), date( 'd-m-Y', $end ) ), 'error' );

		        }
		    }

	    }

		if ( strpos( $_POST['shipping_method'][0], 'local_pickup' ) !== false ) {

			/**
			 *	Wybrano odbiór osobisty
			 *	Sprawdzanie czy została wybrana lokalizacja odbioru osobistego, data i godzina odbioru z lokalu
			 *
			 */
			$choosed_location 		= $_POST['location'];

			if ( !$choosed_location ) {

				wc_add_notice( __( 'Prosimy o wybranie miejsca odbioru zamówienia.', 'wctheme' ), 'error' );
				add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
				$failure = true;

			} else {

				if ( get_field( 'new__location', $choosed_location ) ) {

					$start 	= get_field( 'new__location__from', $choosed_location );
					$end 	= get_field( 'new__location__to', $choosed_location );

					if ( strtotime( $_POST['shipping_date'] ) > strtotime( $end ) || strtotime( $_POST['shipping_date'] ) < strtotime( $start ) ) {

			            wc_add_notice( sprintf( __( 'Odbiór osobisty w punkcie %s obowiązuje od %s do %s', 'wctheme' ), get_the_title( $choosed_location ), $start, $end), 'error' );
			            add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
			            $failure = true;

					}

				} else {

					if ( !$shipping_date ) {

						wc_add_notice( __( 'Prosimy o wybranie daty odbioru zamówienia.', 'wctheme' ), 'error' );
						add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
						$failure = true;

					}
					if ( !$shipping_time || $shipping_time == 0 ) {

						wc_add_notice( __( 'Prosimy o wybranie godziny odbioru zamówienia.', 'wctheme' ), 'error' );
						add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
						$failure = true;

					}

				}

			}

		}
		if ( strpos( $_POST['shipping_method'][0], 'pickpack' ) !== false ) {

			/**
			 *	Walidacja pickpack
			 *	@todo
			 *
			 */

			/**
			 *	Wybrano odbiór osobisty
			 *	Sprawdzanie czy została wybrana lokalizacja odbioru osobistego, data i godzina odbioru z lokalu
			 *
			 */

			if ( !$shipping_date ) {

				wc_add_notice( __( 'Prosimy o wybranie daty dostarczenia zamówienia.', 'wctheme' ), 'error' );
				add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
				$failure = true;

			}
			
			if ( !$shipping_time || $shipping_time == 0 ) {

				wc_add_notice( __( 'Prosimy o wybranie godziny dostarczenia zamówienia.', 'wctheme' ), 'error' );
				add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
				$failure = true;

			}

		}
		if ( strpos( $_POST['shipping_method'][0], 'wctheme_free_shipping' ) !== false ) {

			/**
			 *	Wybrano darmową dostawę wctheme
			 *
			 *
			 */
			$shipping_parts = explode( ':', $_POST['shipping_method'][0] );
			$settings 		= get_option( 'woocommerce_' . $shipping_parts[0] . '_' . $shipping_parts[1] . '_settings' );

			if ( !$shipping_date ) {

				wc_add_notice( __( 'Prosimy o wybranie daty dostarczenia zamówienia.', 'wctheme' ), 'error' );
				add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
				$failure = true;

			} else {
				if ( $settings ) {

					$start 		= $settings['start'];
			        $end 		= $settings['end'];

			        if ( strpos( $_POST['shipping_method'][0], 'wctheme_free_shipping' ) !== false ) {

			            if ( strtotime( $_POST['shipping_date'] ) > strtotime( $end ) || strtotime( $_POST['shipping_date'] ) < strtotime( $start ) ) {
				            wc_add_notice( sprintf( __( 'Darmowa dostawa na terenie Warszawy obowiązuje od %s do %s', 'wctheme' ), $start, $end), 'error' );
				            add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
				            $failure = true;
						}

			        }

				}

			}

		}

		if ( strpos( $_POST['shipping_method'][0], 'flat_rate' ) !== false ) {
			/**
			 *	Jezeli wybrana została inna forma dostarczenia niż odbiór osobisty lub pickpack
			 *	sprawdzamy czy jest tort w koszyku i informujemy klienta o tym,
			 *	że nie może go kupić
			 *
			 */
			foreach ( WC()->cart->get_cart() as $cart_item ) {

				if ( has_term( $shipping_disabled_categories, 'product_cat', $cart_item['product_id'] ) ) {

					wc_add_notice( sprintf( __( 'Produkt <a href="%s">%s</a> jest dostępny tylko do odbioru osobistego lub w dostawie tylko na terenie Warszawy. Usuń go lub zmień formę odbioru zamówienia.', 'wctheme' ), get_the_permalink( $cart_item['product_id'] ), get_the_title( $cart_item['product_id'] ) ), 'error' );

					add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
					$failure = true;

				}

			}
		}

		/**
		 *	Walidacja bramki płatności
		 *
		 *
		 */
		if ( $_POST['payment_method'] == 'payu' ) {

			if ( !isset( $_POST['payMethod'] ) ) {
				wc_add_notice( __( 'Prosimy o wybranie metody płatności.', 'wctheme' ), 'error' );
				add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
				$failure = true;
			}

		}

		if ( $_POST['user_type'] == 'company' ) {
			if ( empty( $_POST['billing_company'] ) ) {
				wc_add_notice( __( 'Podaj nazwę firmy.', 'wctheme' ), 'error' );
			}
			if ( empty( $_POST['billing_nip'] ) ) {
				wc_add_notice( __( 'Podaj NIP.', 'wctheme' ), 'error' );
			}
		}

		if ( !$failure && $_POST['terms'] != 'on' ) {
			wc_add_notice( __( 'Proszę zaakceptować regulamin sklepu.', 'wctheme' ), 'error' );
			add_filter( 'woocommerce_checkout_fields' , array( $this, 'wctheme_remove_required_fields' ) );
			$failure = true;
		}

	}

	public function add_location_fee() {

		if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
			return;
		}

		if ( isset( $_POST['post_data'] ) ) {
			parse_str( $_POST['post_data'], $post_data );
		} else {
			$post_data = $_POST;
		}

		if ( isset( $_POST['shipping_method'][0] ) ) {
			
			if ( strpos( $_POST['shipping_method'][0], 'local_pickup' ) !== false ) {

				if ( isset( $post_data['shipping_date'] ) && !empty( $post_data['shipping_date'] ) && isset( $post_data['location'] ) && !empty( $post_data['location'] ) ) {

					if ( get_post_meta( (int) $post_data['location'], 'new__location', true ) ) {

						$start 	= get_post_meta( (int) $post_data['location'], 'new__location__from', true );
						$end 	= get_post_meta( (int) $post_data['location'], 'new__location__to', true );

						if ( strtotime( $post_data['shipping_date'] ) < strtotime( $end ) || strtotime( $post_data['shipping_date'] ) > strtotime( $start ) || strtotime( $post_data['shipping_date'] ) == strtotime( $start ) ) {

							$fee 	= __( 'Dodatkowa opłata za odbiór w nowym punkcie', 'wctheme' );
							$price 	= get_post_meta( $post_data['location'], 'new__location__fee', true);
							WC()->cart->add_fee( $fee, $price, false, '' );

						}

					}

				}

			}

		}

	}

	public function add_cakes_fee( $cart ){
		if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
			return;
		}

		if ( isset( $_POST['post_data'] ) ) {
			parse_str( $_POST['post_data'], $post_data );
		} else {
			$post_data = $_POST;
		}

		if ( isset( $post_data['shipping_date'] ) && !empty( $post_data['shipping_date'] ) ) {

			$date_ship 	 	= date_create( $post_data['shipping_date'] );
			$date_now 		= date_create( date( 'Y-m-d' ) );
			$difference 	= date_diff( $date_now, $date_ship );

			if ( $difference->format( '%a' ) < 2 ) {

				$total_qty 	= 0;
				$total_fee 	= 0;

				foreach ( WC()->cart->get_cart() as $cart_item ) {

					if ( has_term( 'torty', 'product_cat', $cart_item['product_id'] ) ) {
						$total_qty 	+= $cart_item['quantity'];
					}

				}

				$total_fee 	= get_field( 'cakes_extra_price_next_day', 'options' ) * $total_qty;

				if ( $total_qty && $total_fee ) {
					if ( $total_qty > 1 ) {
						$fee = __( 'Dodatkowa opłata za realizację tortów na dzień następny', 'wctheme' );
					} else {
						$fee = __( 'Dodatkowa opłata za realizację tortu na dzień następny', 'wctheme' );
					}
					WC()->cart->add_fee( $fee, (float) $total_fee );
				}

			}

		}

	}

	public function wctheme_woocommerce_myaccount_navigation( $menu_links ) {

		$menu_links = array_slice( $menu_links, 0, 4, true )
		+ array( 'customer-coupons' => 'Moje rabaty' )
		+ array_slice( $menu_links, 3, NULL, true );

		unset( $menu_links['downloads'] );
		unset( $menu_links['dashboard'] );

		$menu_links['orders'] = __( 'Historia zamówień', 'wctheme' );
		$menu_links['edit-address'] = __( 'Moje adresy', 'wctheme' );
		$menu_links['edit-account'] = __( 'Ustawienia konta', 'wctheme' );

		return $menu_links;

	}

	public function wctheme_woocommerce_add_coupons_endpoint() {
		add_rewrite_endpoint( 'customer-coupons', EP_ROOT | EP_PAGES );
	}

	public function wctheme_woocommerce_customer_coupons_query_vars( $vars ) {
	    $vars[] = 'customer-coupons';
	    return $vars;
	}

	public function wctheme_woocommerce_add_coupons_content() {

		$coupons 		= array();
		$args 			= array(
			'numberposts' => -1,
		    'meta_key'    => '_customer_user',
		    'meta_value'  => get_current_user_id(),
		    'post_type'   => wc_get_order_types(),
		    'post_status' => array_keys( wc_get_order_statuses() ),
		);
		$customer_orders = get_posts($args);

		if ( $customer_orders ) :

			foreach ($customer_orders as $customer_order) :

				$wc_order = new WC_Order( $customer_order );

				foreach( $wc_order->get_coupon_codes() as $coupon) {

    				$wc_coupon 				= new WC_Coupon( $coupon );
    				$discount 				= wc_price( $wc_coupon->get_amount() );

    				if ( $wc_coupon->get_discount_type() == 'percent' ) {
    					$discount 				= $wc_coupon->get_amount() . '%';
    				}

        			$coupons[] 		= array(
        				'code' 					=> $coupon,
        				'discount' 				=> $discount,
        				'expires' 				=> $wc_coupon->get_date_expires(),
        				'status' 				=> __( 'Wykorzystany', 'wctheme' ),
        				'used' 					=> $wc_order->get_date_created(),
        			);

        		}

			endforeach;

		endif;

	 	$data 		= array(
	 		'coupons' 	=> $coupons,
	 	);
	 	wc_get_template( 'myaccount/customer-coupons.php', $data, '' );
	}

	public function wctheme_save_order_coupons( $order_id ) {

        $wc_order 	= new WC_Order( $order_id );
        $user_id  	= $wc_order->get_customer_id();

        if ( ! $user_id ) {
        	error_log('brak id uzytkownika');
			return;
		}

        $coupons     = get_user_meta( $user_id, 'wctheme_user_coupons', true );

        if ( is_array( $coupons ) ) {

        	error_log('są kupony w bazie');

        	if ( $wc_order->get_used_coupons() ) {

        		error_log('są kupony w zamówieniu');

    			foreach( $wc_order->get_used_coupons() as $coupon) {

    				$wc_coupon 				= new WC_Coupon( $coupon );
    				$discount 				= wc_price( $wc_coupon->get_amount() );

    				if ( $wc_coupon->get_discount_type() == 'percent' ) {
    					$discount 				= $wc_coupon->get_amount() . '%';
    				}

        			$coupons[] 		= array(
        				'code' 					=> $coupon,
        				'discount' 				=> $discount,
        				'expires' 				=> $wc_coupon->get_date_expires(),
        				'status' 				=> __( 'Wykorzystany', 'wctheme' ),
        				'used' 					=> $wc_order->get_date_created(),
        			);

        			error_log('dane kuponu' . json_encode($coupons));

        		}

        	}

        } else {

        	error_log('nie ma kuponów w bazie');
        	$coupons 	= array();

        	if ( $wc_order->get_used_coupons() ) {

        		error_log('są kupony w zamówieniu');
    			foreach( $wc_order->get_used_coupons() as $coupon) {

    				$wc_coupon 				= new WC_Coupon( $coupon );
    				$discount 				= wc_price( $wc_coupon->get_amount() );

    				if ( $wc_coupon->get_discount_type() == 'percent' ) {
    					$discount 				= $wc_coupon->get_amount() . '%';
    				}

        			$coupons[] 		= array(
        				'code' 					=> $coupon,
        				'discount' 				=> $discount,
        				'expires' 				=> $wc_coupon->get_date_expires(),
        				'status' 				=> __( 'Wykorzystany', 'wctheme' ),
        				'used' 					=> $wc_order->get_date_created(),
        			);

        			error_log('dane kuponu' . json_encode($coupons));
        		}

        	}

        }

        update_user_meta( $user_id, 'wctheme_user_coupons', $coupons );

	}

	public function wctheme_save_custom_order_data( $order ) {

		if ( isset( $_POST['payMethod'] ) ) {
			$meta = $_POST['payMethod'];
			$order->update_meta_data( '_wctheme_pay_method', $meta );
		}

		if ( isset( $_POST['user_type'] ) ) {

			if ( $_POST['user_type'] == 'company' ) {
				if ( isset( $_POST['billing_company'] ) ) {
					$meta = $_POST['billing_company'];
					$order->update_meta_data( '_wctheme_company_name', $meta );
				}
				if ( isset( $_POST['billing_nip'] ) ) {
					$meta = $_POST['billing_nip'];
					$order->update_meta_data( '_wctheme_company_nip', $meta );
				}
			}

		}

		if ( isset( $_POST['shipping_method'][0] ) ) {
			
			// Pikcpack
			if ( strpos( $_POST['shipping_method'][0], 'pickpack' ) !== false ) {
				$order->update_meta_data( '_wctheme_shipping_metod', 'pickpack' );
			}

			// Odbiór osobisty
			if ( strpos( $_POST['shipping_method'][0], 'local_pickup' ) !== false ) {
				$order->update_meta_data( '_wctheme_shipping_metod', 'local_pickup' );
			}

			// Kurier DHL
			if ( strpos( $_POST['shipping_method'][0], 'flat_rate' ) !== false ) {
				$order->update_meta_data( '_wctheme_shipping_metod', 'flat_rate' );
			}

			// wctheme darmowa wysyłka
			if ( strpos( $_POST['shipping_method'][0], 'wctheme_free_shipping' ) !== false ) {
				$order->update_meta_data( '_wctheme_shipping_metod', 'wctheme_free_shipping' );
			}

		}

		if ( isset( $_POST['location'] ) ) {
			$meta = $_POST['location'];
			$order->update_meta_data( '_wctheme_location', $meta );
		}

		if ( isset( $_POST['shipping_time'] ) ) {
			$meta = $_POST['shipping_time'];
			$order->update_meta_data( '_wctheme_shipping_time', $meta );
		}

		if ( isset( $_POST['shipping_date'] ) ) {
			$meta = $_POST['shipping_date'];
			$order->update_meta_data( '_wctheme_shipping_date', $meta );
		}

	}

	public function wctheme_add_cart_item_to_order_items( $item, $cart_item_key, $values, $order ) {

		/**
		 *	Przeniesienie wybranych smaków z cart_item_meta do order_item_meta
		 *
		 */
	    if ( ! empty( $values['flavour'] ) ) {
	    	$item->add_meta_data( __( 'Wybrane smaki', 'wctheme' ), $values['flavour'] );

	    	/**
			 *	Redukcja stocku dla smaków - dla opcji praliny i lody
			 *
			 */
	    	foreach( $values['flavour'] as $flavour ) {
	    		$new_stock = wc_update_product_stock( $flavour['id'], $flavour['quantity'], 'decrease' );
	    	}

	    }

	    /**
		 *	Przeniesienie napisu na tort cart_item_meta do order_item_meta
		 *
		 */
	    if ( !empty( $values['cake_text'] ) ) {
	    	$item->add_meta_data( __( 'Napis na tort', 'wctheme' ), $values['cake_text'] );
	    }

	    if ( !empty( $values['presentpack'] ) ) {
	    	$item->add_meta_data( __( 'Komentarz do zestawu prezentowego', 'wctheme' ), $values['presentpack'] );
	    }

	}


	public function wctheme_woocommerce_admin_order_item_headers() {
	    echo '<th>'. __( 'Wybrane smaki', 'wctheme' ) .'</th>';
	}

	public function wctheme_admin_order_item_values( $product, $item, $item_id ) {

		$flavours 	= wc_get_order_item_meta( $item_id, 'Wybrane smaki' );
		$cake_text 	= wc_get_order_item_meta( $item_id, 'Napis na tort' );
		$display 	= '';

		if ( $flavours ) {

			foreach( $flavours as $flavour ) {
				if ( $flavour['quantity'] > 0 ) {
					$display .= $flavour['name'] . ': <strong>' . $flavour['quantity'] . '</strong><br>';
				}
			}

		}

		echo '<td>'. $display .'</td>';

	}

    public function wctheme_order_to_pdf_box() {
        global $post;
        add_meta_box( 'wctheme_order_fields', __( 'Wygeneruj PDF', 'wctheme' ), array( $this, 'wctheme_order_to_pdf_initiatior' ), 'shop_order', 'side', 'core' );
		add_meta_box( 'wctheme_order_courier', __( 'Przesyłka: Pickpack', 'wctheme' ), array( $this, 'wctheme_order_pickpack_courier' ), 'shop_order', 'side', 'core' );
    }

    public function wctheme_order_to_pdf_initiatior() {
    	global $post;
        echo '<a target="_blank" href="'. admin_url( 'admin-ajax.php?action=wctheme_generate_order_pdf&order_id=' . $post->ID ) .'" class="button button-primary pdf-action">Wygeneruj PDF</a>';
    }

    public function wctheme_order_pickpack_courier() {
    	global $post;

    	if ( get_post_meta( $post->ID, '_pickpack_uuid', true ) ) {
    		echo __( 'Przesyłka została utworzona', 'wctheme' );
    	} else {
    		echo '<a target="_blank" href="'. admin_url( 'admin-ajax.php?action=wctheme_generate_pickpack_order&order_id=' . $post->ID ) .'" class="button button-primary pdf-action">Zamów kuriera</a>';
    	}

    }

    public function wctheme_add_notice_package_not_created() {
    	?>
       	<div class="notice notice-error">
          	<p><?php _e( 'Wystapił błąd podczas autoryzacji z API PickPack. Sprawdź konfigurację lub spróbuj ponownie później.', 'wctheme' ); ?></p>
       	</div>
       	<?php
    }

    public function wctheme_generate_pickpack_order() {

    	$response = $this->pickpack->create_parcel_for_order( $_GET['order_id'] );

    	/**
    	 *	Check API response & update all necessary post meta data
    	 *	then redirect to post edit screen
    	 *
    	 */
    	if ( $response && property_exists( $response, 'uuid' ) ) {
    		update_post_meta( $_GET['order_id'], '_pickpack_uuid', $response->uuid );
    	} else {
    		add_action( 'admin_notices', array( $this, 'wctheme_add_notice_package_not_created' ) );
    		wp_safe_redirect( admin_url( 'post.php?post=' . $_GET['order_id'] . '&action=edit' ) );
    	}

    	wp_safe_redirect( admin_url( 'post.php?post=' . $_GET['order_id'] . '&action=edit' ) );
    	die;

    }

    public function wctheme_generate_order_pdf() {

    	try {

	    	$order 		= new WC_Order( $_GET['order_id'] );

	    	ob_start();
		    include dirname(__FILE__).'/template/order_pdf.php';
		    $content = ob_get_clean();

		    $content = mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' );

			$html2pdf = new Html2Pdf('P', 'A4', 'pl', true, 'UTF-8', array(15, 5, 15, 5) );
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->pdf->SetTitle( 'Zamówienie numer ' . $_GET['order_id'] );
			$html2pdf->writeHTML($content, false);
			$html2pdf->output( 'zamowienie_' . $_GET['order_id'] . '.pdf' );

		} catch (Html2PdfException $e) {
			$html2pdf->clean();

    		$formatter = new ExceptionFormatter($e);
    		echo $formatter->getHtmlMessage();
		}

		die;

    }

    public function wctheme_register_custom_order_statuses() {

    	register_post_status( 'wc-paid', array(
	        'label'                     => __( 'Opłacone', 'wctheme' ),
	        'public'                    => true,
	        'exclude_from_search'       => false,
	        'show_in_admin_all_list'    => true,
	        'show_in_admin_status_list' => true,
	        'label_count'               => _n_noop( 'Opłacone (%s)', 'Opłacone (%s)' )
	    ) );

	    register_post_status( 'wc-order-processing', array(
	        'label'                     => __( 'W trakcie realizacji', 'wctheme' ),
	        'public'                    => true,
	        'exclude_from_search'       => false,
	        'show_in_admin_all_list'    => true,
	        'show_in_admin_status_list' => true,
	        'label_count'               => _n_noop( 'W trakcie realizacji (%s)', 'W trakcie realizacji (%s)' )
	    ) );

	    register_post_status( 'wc-payment-error', array(
	        'label'                     => __( 'Błąd płatności', 'wctheme' ),
	        'public'                    => true,
	        'exclude_from_search'       => false,
	        'show_in_admin_all_list'    => true,
	        'show_in_admin_status_list' => true,
	        'label_count'               => _n_noop( 'Błąd płatności (%s)', 'Błąd płatności (%s)' )
	    ) );

	    register_post_status( 'wc-shipment-ready', array(
	        'label'                     => __( 'Gotowe do odbioru', 'wctheme' ),
	        'public'                    => true,
	        'exclude_from_search'       => false,
	        'show_in_admin_all_list'    => true,
	        'show_in_admin_status_list' => true,
	        'label_count'               => _n_noop( 'Gotowe do odbioru (%s)', 'Gotowe do odbioru (%s)' )
	    ) );

	    register_post_status( 'wc-shipping', array(
	        'label'                     => __( 'Wysłane', 'wctheme' ),
	        'public'                    => true,
	        'exclude_from_search'       => false,
	        'show_in_admin_all_list'    => true,
	        'show_in_admin_status_list' => true,
	        'label_count'               => _n_noop( 'Wysłane (%s)', 'Wysłane (%s)' )
	    ) );

    }

    public function add_wctheme_statuses_to_order_statuses( $order_statuses ) {

	    $new_order_statuses = array();

	    foreach ( $order_statuses as $key => $status ) {

	    	$new_order_statuses['wc-processing'] = __( 'Nowe zamówienie' );

	        $new_order_statuses[ $key ] = $status;

	        //if ( 'wc-processing' === $key ) {
	        	$new_order_statuses['wc-order-processing'] = __( 'W trakcie realizacji', 'wctheme' );
	            $new_order_statuses['wc-paid'] = __( 'Opłacone', 'wctheme' );
	            $new_order_statuses['wc-payment-error'] = __( 'Błąd płatności', 'wctheme' );
	            $new_order_statuses['wc-shipment-ready'] = __( 'Gotowe do odbioru', 'wctheme' );
	            $new_order_statuses['wc-shipping'] = __( 'Wysłane', 'wctheme' );
	        // }

	    }

	    return $new_order_statuses;
	}

	public function wctheme_woocommerce_handle_payment_error_status( $order_id ) {
		$mailer = WC()->mailer()->get_emails();
    	$mailer['WC_Payment_Error_Email']->trigger( $order_id );
	}

	public function wctheme_woocommerce_handle_shippment_ready_status( $order_id ) {
		$mailer = WC()->mailer()->get_emails();
    	$mailer['WC_Customer_Pickup']->trigger( $order_id );
	}

	public function wctheme_woocommerce_handle_procesing_status( $order_id ) {
		$mailer = WC()->mailer()->get_emails();
    	$mailer['WC_Order_In_Progress']->trigger( $order_id );
	}

	public function wctheme_woocommerce_handle_shipping_status( $order_id ) {
		$mailer = WC()->mailer()->get_emails();
    	$mailer['WC_Order_In_Shiping']->trigger( $order_id );
	}

	public function wctheme_present_checkout_checkbox( $checkout ) {

	    woocommerce_form_field( 'wctheme_present', array(
	        'type'          => 'checkbox',
	        'label_class'   => array('form__checkbox'),
	        'input_class'   => array(),
	        'label'         => __( 'Zakupy na prezent (nie dołączymy paragonu, fakturę zakupową wysyłamy na wskazany w zamówieniu adres mailowy Zamawiającego)', 'wctheme' ),
	        'required'  	=> false,
	        'default' 		=> 0,
	    ) );

	}

	public function wctheme_present_checkout_checkbox_update_order_meta( $order_id ) {
	    if ( $_POST['wctheme_present'] ) update_post_meta( $order_id, '_wctheme_present', esc_attr( $_POST['wctheme_present'] ) );
	    if ( $_POST['location'] ) update_post_meta( $order_id, '_wctheme_pickup_location', esc_attr( $_POST['location'] ) );

	    // Zapis danych shipping - same automatycznie nie chcą się zapisywać
	    if ( $_POST['shipping_wctheme_postcode'] ) update_post_meta( $order_id, '_shipping_wctheme_postcode', esc_attr( $_POST['shipping_wctheme_postcode'] ) );
	    if ( $_POST['shipping_first_name'] ) update_post_meta( $order_id, '_shipping_first_name', esc_attr( $_POST['shipping_first_name'] ) );
	    if ( $_POST['shipping_last_name'] ) update_post_meta( $order_id, '_shipping_last_name', esc_attr( $_POST['shipping_last_name'] ) );
	    if ( $_POST['shipping_company'] ) update_post_meta( $order_id, '_shipping_company', esc_attr( $_POST['shipping_company'] ) );
	    if ( $_POST['shipping_address_1'] ) update_post_meta( $order_id, '_shipping_address_1', esc_attr( $_POST['shipping_address_1'] ) );
	    if ( $_POST['shipping_city'] ) update_post_meta( $order_id, '_shipping_city', esc_attr( $_POST['shipping_city'] ) );
	    if ( $_POST['billing_notes'] ) update_post_meta( $order_id, '_billing_notes', esc_attr( $_POST['billing_notes'] ) );
	    if ( $_POST['shipping_address_building'] ) update_post_meta( $order_id, '_shipping_address_building', esc_attr( $_POST['shipping_address_building'] ) );
	    if ( $_POST['shipping_address_apartment'] ) update_post_meta( $order_id, '_shipping_address_apartment', esc_attr( $_POST['shipping_address_apartment'] ) );
	}

	public function wctheme_after_shipping_order( $order ) {
		global $post;

		$shipping_building 			= get_post_meta( $post->ID, '_shipping_address_building', true );
		$shipping_apartment 		= get_post_meta( $post->ID, '_shipping_address_apartment', true );
		$shipping_postcode 			= get_post_meta( $post->ID, '_shipping_wctheme_postcode', true );

		if ( $shipping_building ) {
			echo sprintf( __( '<p><strong>Numer budynku:</strong><br>%s</p>', 'wctheme' ), $shipping_building );
		}

		if ( $shipping_apartment ) {
			echo sprintf( __( '<p><strong>Numer lokalu:</strong><br>%s</p>', 'wctheme' ), $shipping_apartment );
		}
	}

	public function wctheme_diaplay_admin_order_meta( $order ) {
		global $post;

		$present 				= get_post_meta( $post->ID, '_wctheme_present', true );
		$location 				= get_post_meta( $post->ID, '_wctheme_location', true );
		$shipping_time 			= get_post_meta( $post->ID, '_wctheme_shipping_time', true );
		$shipping_date 			= get_post_meta( $post->ID, '_wctheme_shipping_date', true );

		$billing_building 		= get_post_meta( $post->ID, '_billing_address_building', true );
		$billing_apartment 		= get_post_meta( $post->ID, '_billing_address_apartment', true );

		$billing_nip 			= get_post_meta( $post->ID, '_wctheme_company_nip', true );
		$billing_notes 			= get_post_meta( $post->ID, '_billing_notes', true );

		foreach ( $order->get_items() as $item ) {
			$cake_text = wc_get_order_item_meta( $item->get_ID(), 'Napis na tort' );
		}

		if ( $billing_building ) {
			echo sprintf( __( '<p><strong>Numer budynku:</strong><br>%s</p>', 'wctheme' ), $billing_building );
		}

		if ( $billing_apartment ) {
			echo sprintf( __( '<p><strong>Numer lokalu:</strong><br>%s</p>', 'wctheme' ), $billing_apartment );
		}

		if ( $billing_notes ) {
			echo sprintf( __( '<p><strong>Uwagi dla kuriera:</strong><br>%s</p>', 'wctheme' ), $billing_notes );
		}

		if ( $present ) {
			echo __( '<p><strong>Zakup na prezent:</strong><br>Tak</p>', 'wctheme' );
		}

		foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) :
			if ( 'local_pickup' == $shipping_item_obj->get_method_id() ) {
				echo sprintf( __( '<p><strong>Odbiór osobisty z cukierni:</strong><br>%s</p>', 'wctheme' ), get_the_title( $location ) );

				if ( $shipping_time && $shipping_date ) {
					echo sprintf( __( '<p><strong>Data i godzina odbioru:</strong><br>%s %s</p>', 'wctheme' ), $shipping_date, $shipping_time );
				}
			}
			if ( 'flat_rate' == $shipping_item_obj->get_method_id() ) {
				// Kurier DHL
			}
			if ( 'wctheme_free_shipping' == $shipping_item_obj->get_method_id() ) {
				//Darmowa wysyłka wctheme
			}
			if ( 'pickpack' == $shipping_item_obj->get_method_id() ) {
				if ( $shipping_time && $shipping_date ) {

					$ship 	= wctheme_ready_for_pickpack_send(); // Zakresy kiedy wctheme musi przygotować przesyłke
					$range 	= return_pickpack_time_range(); // Zakresy kiedy kurier dostarcza przesyłkę
					$key 	= array_search( $shipping_time, $range );

					echo sprintf( __( '<p><strong>Data realizacji zamówienia:</strong><br>%s</p>', 'wctheme' ), $shipping_date );

					if ( $ship[$key] ) {
						echo sprintf( __( '<p><strong>Godzina odbioru przez kuriera:</strong><br>%s</p>', 'wctheme' ), $ship[$key] );
						echo sprintf( __( '<p><strong>Godzina dostarczenia:</strong><br>%s</p>', 'wctheme' ), $range[$key] );
					}
					
				}
				
			}
		endforeach;

		if ( $billing_nip ) {
			echo sprintf( __( '<p><strong>NIP:</strong><br>%s</p>', 'wctheme' ), $billing_nip );
		}

		if ( $cake_text ) {
			echo sprintf( __( '<p><strong>Treść napisu na torcie:</strong><br>%s</p>', 'wctheme' ), $cake_text );
		}

	}

    public function wctheme_override_checkout_fields( $fields ) {
        
        $fields['billing']['billing_first_name']['placeholder'] 		= __( 'Imię*', 'wctheme' );
        $fields['billing']['billing_last_name']['placeholder'] 			= __( 'Nazwisko*', 'wctheme' );
        $fields['billing']['billing_postcode']['placeholder'] 			= __( 'Kod pocztowy*', 'wctheme' );
        $fields['billing']['billing_city']['placeholder'] 				= __( 'Miejscowość*', 'wctheme' );
        $fields['billing']['billing_phone']['placeholder'] 				= __( 'Numer telefonu*', 'wctheme' );
        $fields['billing']['billing_email']['placeholder'] 				= __( 'Adres e-mail*', 'wctheme' );

        $fields['shipping']['shipping_first_name']['placeholder'] 		= __( 'Imię*', 'wctheme' );
        $fields['shipping']['shipping_last_name']['placeholder'] 		= __( 'Nazwisko*', 'wctheme' );
        $fields['shipping']['shipping_postcode']['placeholder'] 		= __( 'Kod pocztowy*', 'wctheme' );
        $fields['shipping']['shipping_city']['placeholder'] 			= __( 'Miejscowość*', 'wctheme' );


        $fields['billing']['billing_first_name']['class'] = [];
        $fields['billing']['billing_last_name']['class'] = [];
        $fields['shipping']['shipping_first_name']['class'] = [];
        $fields['shipping']['shipping_last_name']['class'] = [];

        $fields['billing']['billing_address_building'] = [
            'label' => __( 'Nr budynku', 'wctheme' ),
            'placeholder' => _x( 'Nr budynku*', 'placeholder', 'wctheme' ),
            'required' => false,
            'class' => array( 'uk-width-1-2 uk-width-1-5@m uk-display-inline-block' ),
            'priority' => 51
        ];
        $fields['billing']['billing_notes'] = [
            'label' => __( 'Informacje dodatkowe do adresu', 'wctheme' ),
            'placeholder' => _x( 'Informacje dodatkowe do adresu', 'placeholder', 'wctheme' ),
            'required' => false,
            'priority' => 90
        ];
        $fields['shipping']['shipping_address_building'] = $fields['billing']['billing_address_building'];

        $fields['billing']['billing_address_apartment'] = [
            'label' => __( 'Nr lokalu', 'wctheme' ),
            'placeholder' => _x( 'Nr lokalu', 'placeholder', 'wctheme' ),
            'required' => false,
            'class' => array( 'uk-width-1-2 uk-width-1-5@m uk-display-inline-block' ),
            'priority' => 52
        ];
        $fields['shipping']['shipping_address_apartment'] = $fields['billing']['billing_address_apartment'];
        
        unset($fields['billing']['billing_wctheme_postcode']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['shipping']['shipping_postcode']);
        unset($fields['shipping']['shipping_company']);
        unset($fields['shipping']['shipping_nip']);

        $fields['account']['account_password']['priority']    = 10;

		unset( $fields['account']['account_username'] );

        return $fields;
    }

    public function wctheme_override_address_fields( $address_fields ) {
        $address_fields['address_1']['class'] = [ 'uk-width-1-1 uk-width-3-5@m uk-display-inline-block' ];
        $address_fields['address_1']['placeholder'] = __('Nazwa ulicy*', 'wctheme');
        $address_fields['address_2']['placeholder'] = __('Informacje dodatkowe do adresu', 'wctheme');
        $address_fields['address_2']['priority'] = 100;

        $address_fields['wctheme_postcode'] = [
		    'label' 		=> __('Kod pocztowy', 'wctheme'),
		    'placeholder' 	=> _x('Kod pocztowy*', 'placeholder', 'wctheme'),
		    'required' 		=> true,
		    'class' 		=> array('form-row-wide'),
		    'priority' 		=> 53,
		];

		$address_fields['company'] = [
		    'label' 		=> __('Nazwa firmy', 'wctheme'),
		    'placeholder' 	=> _x('Nazwa firmy*', 'placeholder', 'wctheme'),
		    'required' 		=> false,
		    'class' 		=> array('form-row-wide', 'checkout-company', 'uk-hidden'),
		    'priority' 		=> 2,
		];

		$address_fields['nip'] = [
		    'label' 		=> __('NIP', 'wctheme'),
		    'placeholder' 	=> _x('NIP*', 'placeholder', 'wctheme'),
		    'required' 		=> false,
		    'class' 		=> array('form-row-wide', 'checkout-nip', 'uk-hidden'),
		    'priority' 		=> 3,
		];

        return $address_fields;
    }

    public function wctheme_custom_shipping_table_update( $fragments ) {
        ob_start();
        ?>
        <div class="shipping__options uk-hidden uk-margin-medium-bottom">
            <h2><?php _e( 'Sposób dostawy', 'wctheme' ); ?></h2>
            <?php wc_cart_totals_shipping_html(); ?>
            <p class="checkout__delivery__info checkout__delivery__info--zone1"><?php echo __('* Koszt dostawy na terenie Warszawy to 40 zł, niezależnie od adresu i odległości. Produkty wctheme przewożone są przez firmę PickPack, samochodem chłodnią przystosowanym do przewożenia delikatnych produktów cukierniczych.', 'wctheme'); ?></p>
            <p class="checkout__delivery__info checkout__delivery__info--zone2"><?php echo __('* Koszt dostawy do lokalizacji położonych na obrzeżach Warszawy - 55 zł. Produkty wctheme przewożone są przez firmę PickPack, samochodem chłodnią przystosowanym do przewożenia delikatnych produktów cukierniczych.', 'wctheme'); ?></p>
        </div>
        <?php
        $woocommerce_shipping_methods = ob_get_clean();

        $fragments['.shipping__options'] 	= $woocommerce_shipping_methods;
        return $fragments;

    }

    public function wctheme_remove_shipping_method_price( $label, $method ) {
	    return $method->get_label();
	}

    public function display_current_shipping_method_cost() {

    	foreach( WC()->session->get('shipping_for_package_0')['rates'] as $method_id => $rate ) {

		    if( WC()->session->get('chosen_shipping_methods')[0] == $method_id ) {
		        $rate_label 		= $rate->label;
		        $rate_cost_excl_tax = floatval($rate->cost);

		        $rate_taxes = 0;

		        foreach ($rate->taxes as $rate_tax)
		            $rate_taxes += floatval($rate_tax);

		        $rate_cost_incl_tax = $rate_cost_excl_tax + $rate_taxes;

		        $price 	= __( 'Za darmo', 'wctheme' );
		        if ( WC()->cart->get_shipping_total() > 0 ) {
		        	$price = WC()->cart->get_cart_shipping_total();
		        }

		        echo '<th colspan="2">'.$rate_label.': </th><td>'. $price .'</td>';
		        break;
		    }
		}

    }

    public function wctheme_remove_checkout_optional_text( $field, $key, $args, $value ) {
        if( is_checkout() && ! is_wc_endpoint_url() ) {
            $optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
            $field = str_replace( $optional, '<span></span>', $field );
        }
        return $field;
    }

    /**
     * Remove password strength check.
     */
    public function wctheme_remove_password_strength() {
        wp_dequeue_script( 'wc-password-strength-meter' );
    }

    public function wctheme_add_to_cart_fragment( $fragments ) {
        global $woocommerce;

        ob_start();

        ?>
        <span class="cart-items-count count"><?= $woocommerce->cart->cart_contents_count; ?></span>
        <?php
        $fragments['span.cart-items-count'] = ob_get_clean();
        return $fragments;
    }
}

new wcthemeWooCommerce();

endif;