<?php

class wctheme_Orders_Export {

	/**
	 *	Orders array
	 *
	 *
	 */
	public $orders 		= array();

	/**
	 *	Products array
	 *
	 *
	 */
	public $products 	= array();

	/**
	 *	__construct
	 *
	 *
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'wctheme_add_amin_scripts' ) );
		add_action( 'admin_menu', array( $this, 'wctheme_add_submenu_page' ), 99 );

		add_action( 'wp_ajax_wctheme_orders_csv', array( $this, 'run_action' ) );

	}

	public function wctheme_add_amin_scripts() {
		wp_enqueue_script( 'wctheme-admin-masked-input', get_template_directory_uri() . '/assets/js/maskedinput.min.js', array(), wp_get_theme()->get( 'Version' ) );
	}

	public function wctheme_add_submenu_page() {
		add_submenu_page( 'woocommerce', 'Eksport zamówień', 'Eksport zamówień', 'manage_options', 'wctheme-orders-export', array( $this, 'wctheme_woocommerce_orders_submenu' ) );
	}

	public function get_locations() {

		$args       = array(
	        'post_type'         => 'locations',
	        'posts_per_page'    => -1,
	    );

	    $query      = new WP_Query( $args );
	    $locations  = array();

	    if ( $query->have_posts() ) {

	        while ( $query->have_posts() ) : $query->the_post();

	            $locations[]    =  get_the_ID();

	        endwhile;

	    }

		return $locations;
	}

	public function wctheme_woocommerce_orders_submenu() {

		$locations = $this->get_locations();

		?>
			
			<dir class="wrap" style="padding: 0;">
				<h1><?php _e( 'Eksport zamówień', 'wctheme' ); ?></h1>

				<hr>

				<form id="orders-export" method="POST" style="margin-top: 20px;">

					<div class="alignleft actions bulkactions">
						<select name="location" id="location">
							<option value="-1"><?php _e( 'Lokalizacja', 'wctheme' ); ?></option>
							<?php foreach( $locations as $location ) : ?>
								<option value="<?php echo $location; ?>"><?php echo get_the_title( $location ) ?></option>
							<?php endforeach; ?>
						</select>
						<input type="text" class="wctheme-date-input" style="vertical-align: middle;" id="start_date" name="start_date" placeholder="<?php _e( 'Data początkowa', 'wctheme' ) ?>" />
						<input type="text" class="wctheme-date-input" style="vertical-align: middle;" id="end_date" name="end_date" placeholder="<?php _e( 'Data końcowa', 'wctheme' ) ?>" />
						<input type="submit" id="doaction" class="button action" value="Pobierz plik eksportu" />
					</div>

				</form>

			</div>

			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('.wctheme-date-input').mask("99-99-9999");

					$('#orders-export').submit(function(e){
						e.preventDefault();
						window.open('<?php echo admin_url('admin-ajax.php') ?>?action=wctheme_orders_csv&location=' + $('#location').val() + '&start_date=' + $('#start_date').val() + '&end_date=' + $('#end_date').val() )

					});
				});
			</script>

		<?php
	}

	public function run_action() {

		$this->get_orders();
		$this->prepare_data_to_display();

	}

	/**
	 *	get_orders
	 *
	 *
	 */
	public function get_orders() {

		$startdate 		= $_GET['start_date'];
		$enddate 		= $_GET['end_date'];
		$location 		= $_GET['location'];

		$args 			= array(
			'posts_per_page' 	=> -1,
			'post_type' 		=> 'shop_order',
			'post_status' 		=> 'any',
			'meta_query' 		=> array(
				'key' 				=> '_wctheme_pickup_location',
				'value' 			=> $location,
				'compare' 			=> '=',
			),
			'date_query' 		=> array(
				'after' 			=> $startdate,
				'before' 			=> $enddate,
				'inclusive' 		=> true,
			),
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();

				$this->orders[] = get_the_ID();

			endwhile;
		endif;

	}

	/**
	 *	prepare_data_to_display
	 *
	 *
	 */
	public function prepare_data_to_display() {

		$order_data 	= array();

		foreach( $this->orders as $order ) {

			$wc_order = wc_get_order( $order );

			$items 				= $wc_order->get_items();
			$order_items 		= array();

			foreach( $items as $item ) {

				$order_items[$item->get_product_id()] 		= array(
					'id' 				=> $item->get_product_id(),
					'name' 				=> get_the_title( $item->get_product_id() ),
					'quantity' 			=> $item->get_quantity(),
				);		

				if ( $this->products[$item->get_product_id()] ) {
					$this->products[$item->get_product_id()]['quantity'] = (int) $this->products[$item->get_product_id()]['quantity'] + $item->get_quantity();
				} else {
					$this->products[$item->get_product_id()] 	= array(
						'quantity' 			=> $item->get_quantity(),
					);
				}

			}

			foreach( $wc_order->get_items('shipping') as $item_id => $item_fee ) : 
				$shipping += wc_price($item_fee->get_total()); 
			endforeach;

			$order_data[] 			= array(
				'id' 					=> $order,
				'customer' 				=> $wc_order->get_billing_first_name() . ' ' . $wc_order->get_billing_last_name(),
				'phone' 				=> $wc_order->get_billing_phone(),
				'total' 				=> $wc_order->get_total(),
				'notes' 				=> get_post_meta( $wc_order->get_order_number(), '_billing_notes', true ),
				'shipping' 				=> $shipping,
				'items' 				=> $order_items,
			);

		}

		$this->prepare_csv( $order_data );

	}

	public function prepare_csv( $order_data ) {

		$delimeter 		= ',';
		$output 		= '';
		$filename 		= 'wctheme_orders';
		$headers 		= array( 'Numer zamówienia', 'Imię i nazwisko', 'Telefon' );

		foreach( $this->products as $key => $product ) {
			$headers[] = get_the_title( $key );
		}

		$headers[] = 'Uwagi do zamówienia';
		$headers[] = 'Kwota dostawy';
		$headers[] = 'Wartość zamówienia';

		if ( !empty( $order_data ) ) {

			// print_r($this->products);
			// die;

    		foreach( $headers as $header ) {
    			$output = $output . $header . $delimeter;
    		}
    		$output 	= substr($output, 0, -1);
    		$output    .= "\n";

    		foreach( $order_data as $order ) {

    			$output 	.= $order['id'] . $delimeter . $order['customer'] . $delimeter . $order['phone'] . $delimeter;

    			foreach( $this->products as $key => $product ) {
    				if ( $order['items'][$key] ) {
						$output .= $order['items'][$key]['quantity'] . $delimeter;
    				} else {
    					$output .= '0' . $delimeter;
    				}
					
				}

    			$output 	.= $order['notes'] . $delimeter . $order['shipping'] . $delimeter . $order['total'];
    			$output    	.= "\n";

    		}

    		$output 	.= '' . $delimeter . '' . $delimeter . 'Razem:' . $delimeter;

    		foreach( $this->products as $key => $product ) {
    			$output .= $product['quantity'] . $delimeter;
    		}

    		$output 	= substr($output, 0, -1);
    		$output    .= "\n";

		    header("Pragma: public");
		    header("Expires: 0");
		    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    header("Cache-Control: private", true);
		    header('Content-Encoding: UTF-8');
			header("Content-type: application/vnd.ms-excel; charset=UTF-8");
		    header("Content-Type: application/vnd.ms-excel");
		    header("Content-Disposition: attachment; filename=\"" . $filename . "_" . date('d-m-Y') . ".xls\";" );
		    //header("Content-Transfer-Encoding: binary");

		    echo $output;
		    exit;

		}

		exit;

	}

}

new wctheme_Orders_Export;