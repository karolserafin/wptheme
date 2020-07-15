<?php

function wctheme_contact_form() {

	$response 	= array();

	if ( ! isset( $_POST['subject'] ) || $_POST['subject'] == 0 ) {
		$response['error']['subject'] 	= __( 'To pole jest wymagane', 'wctheme' );
	}
	if ( ! isset( $_POST['name'] ) ) {
		$response['error']['name'] 		= __( 'To pole jest wymagane', 'wctheme' );
	}
	if ( ! isset( $_POST['email'] ) ) {
		$response['error']['email'] 	= __( 'To pole jest wymagane', 'wctheme' );
	}
	if ( ! isset( $_POST['phone'] ) ) {
		$response['error']['phone'] 	= __( 'To pole jest wymagane', 'wctheme' );
	}
	if ( ! isset( $_POST['message'] ) ) {
		$response['error']['message'] 	= __( 'To pole jest wymagane', 'wctheme' );
	}
	if ( ! isset( $_POST['rules'] ) ) {
		$response['error']['rules'] 	= __( 'To pole jest wymagane', 'wctheme' );
	}

	if ( ! empty( $response['error'] ) ) {
		echo json_encode( $response );
		die();
	}

	$subject 	= wctheme_get_contact_email_subject( $_POST['subject'] );
	$name 		= $_POST['name'];
	$contact 	= $_POST['email'];
	$phone 		= $_POST['phone'];
	$message	= $_POST['message'];

	$mailer = WC()->mailer()->get_emails();
    $result = $mailer['WC_Contact_Email']->trigger( get_option( 'admin_email' ), $subject, $name, $contact, $phone, $message );

    if ( $result ) {
    	$response['success']['message'] 		= __( 'Twoja wiadomość została wysłana. Odpowiemy na nią w ciągu 24 godzin.', 'wctheme' );
    	$response['success']['redirect'] 		= get_site_url();
    	$response['success']['button_text'] 	= __( 'Strona główna', 'wctheme' );
    } else {
    	$response['error']['message'] 			= __( 'Nie udało się wysłać wiadomości. Spróbuj ponownie później.', 'wctheme' );
    }

	echo json_encode( $response );
	die();

}

add_action( 'wp_ajax_wctheme_contact_form', 'wctheme_contact_form' );
add_action( 'wp_ajax_nopriv_wctheme_contact_form', 'wctheme_contact_form' );

function wctheme_get_contact_email_subject( $subject ) {

	$subjects = array(
        '',
		__( 'Oferta dla firm', 'wctheme' ),
		__( 'Oferta na wesele', 'wctheme' ),
		__( 'Franczyza i wpsółpraca', 'wctheme' ),
		__( 'Informacje ogólne', 'wctheme' ),
	);

	return $subjects[$subject];

}

function wctheme_get_contact_email_subjects() {
	return array(
        '',
		__( 'Oferta dla firm', 'wctheme' ),
		__( 'Oferta na wesele', 'wctheme' ),
		__( 'Franczyza i współpraca', 'wctheme' ),
		__( 'Informacje ogólne', 'wctheme' ),
	);
}

function wctheme_product_favourites( $id ) {

	$user           = get_current_user_id();
	$response 		= array(
		'message' 	=> __( 'Wystąpił błąd - spróbuj ponownie później', 'wctheme' ),
		'success' 	=> false,
	);

	if ( ! $user ) {
		$response['message'] = __( 'Aby dodać produkt do listy ulubionych - musisz się najpierw zalogować', 'wctheme' );
		wp_send_json( $response );
	}

    if ( $user ) {

    	$id 			= (int) $_POST['id'];
        $favourites     = get_user_meta( $user, 'wctheme_user_favourites', true );

        if ( is_array( $favourites ) ) {
        	if ( in_array( $id, $favourites ) ) {

        		$index = array_search( $id, $favourites );
        		array_splice( $favourites, $index, 1 );

        		update_user_meta( $user, 'wctheme_user_favourites', $favourites );

	        	$response 		= array(
					'message' 	=> __( 'Produkt został usunięty z listy ulubionych.', 'wctheme' ),
					'success' 	=> true,
				);

	        } else {

	        	$favourites[] = $id;

	            update_user_meta( $user, 'wctheme_user_favourites', $favourites );
	            $response 		= array(
					'message' 	=> __( 'Produkt został dodany do listy ulubionych.', 'wctheme' ),
					'success' 	=> true,
				);

	        }
        } else {
	    	update_user_meta( $user, 'wctheme_user_favourites', array( $id ) );
	    	$response 		= array(
				'message' 	=> __( 'Produkt został dodany do listy ulubionych.', 'wctheme' ),
				'success' 	=> true,
			);
        }

    }

    wp_send_json( $response );

}

add_action( 'wp_ajax_wctheme_product_favourites', 'wctheme_product_favourites' );
add_action( 'wp_ajax_nopriv_wctheme_product_favourites', 'wctheme_product_favourites' );

function wctheme_get_location_opening_time( $location_id ) {
    if ( !isset( $_POST['location_id'] ) || $_POST['location_id'] == 0 ) {
        $response['error'] = __( 'ID lokalu jest polem wymaganym', 'wctheme' );
    } else {
        $location_id = $_POST['location_id'];

        $response = array(
            'id' => $location_id,
            'name' => get_the_title( $location_id ),
            'availability' => array(
                0 => array(
                    'opening' => get_field( 'availability_monday', $location_id )['opening'],
                    'closing' => get_field( 'availability_monday', $location_id )['closing'],
                    'range' => wctheme_generate_location_select_options( get_field( 'availability_monday', $location_id )['opening'], get_field( 'availability_monday', $location_id )['closing'] ),
                    'is_open' => get_field( 'availability_monday', $location_id )['is_open'],
                ),
                1 => array(
                    'opening' => get_field( 'availability_tuesday', $location_id )['opening'],
                    'closing' => get_field( 'availability_tuesday', $location_id )['closing'],
                    'range' => wctheme_generate_location_select_options( get_field( 'availability_tuesday', $location_id )['opening'], get_field( 'availability_tuesday', $location_id )['closing'] ),
                    'is_open' => get_field( 'availability_tuesday', $location_id )['is_open'],
                ),
                2 => array(
                    'opening' => get_field( 'availability_wednesday', $location_id )['opening'],
                    'closing' => get_field( 'availability_wednesday', $location_id )['closing'],
                    'range' => wctheme_generate_location_select_options( get_field( 'availability_wednesday', $location_id )['opening'], get_field( 'availability_wednesday', $location_id )['closing'] ),
                    'is_open' => get_field( 'availability_wednesday', $location_id )['is_open'],
                ),
                3 => array(
                    'opening' => get_field( 'availability_thursday', $location_id )['opening'],
                    'closing' => get_field( 'availability_thursday', $location_id )['closing'],
                    'range' => wctheme_generate_location_select_options( get_field( 'availability_thursday', $location_id )['opening'], get_field( 'availability_thursday', $location_id )['closing'] ),
                    'is_open' => get_field( 'availability_thursday', $location_id )['is_open'],
                ),
                4 => array(
                    'opening' => get_field( 'availability_friday', $location_id )['opening'],
                    'closing' => get_field( 'availability_friday', $location_id )['closing'],
                    'range' => wctheme_generate_location_select_options( get_field( 'availability_friday', $location_id )['opening'], get_field( 'availability_friday', $location_id )['closing'] ),
                    'is_open' => get_field( 'availability_friday', $location_id )['is_open'],
                ),
                5 => array(
                    'opening' => get_field( 'availability_saturday', $location_id )['opening'],
                    'closing' => get_field( 'availability_saturday', $location_id )['closing'],
                    'range' => wctheme_generate_location_select_options( get_field( 'availability_saturday', $location_id )['opening'], get_field( 'availability_saturday', $location_id )['closing'] ),
                    'is_open' => get_field( 'availability_saturday', $location_id )['is_open'],
                ),
                6 => array(
                    'opening' => get_field( 'availability_sunday', $location_id )['opening'],
                    'closing' => get_field( 'availability_sunday', $location_id )['closing'],
                    'range' => wctheme_generate_location_select_options( get_field( 'availability_sunday', $location_id )['opening'], get_field( 'availability_sunday', $location_id )['closing'] ),
                    'is_open' => get_field( 'availability_sunday', $location_id )['is_open'],
                ),
            ),
        );

        $start  = get_field( 'new__location__from', $location_id );
        $end    = get_field( 'new__location__to', $location_id );
        $isNew  = get_field( 'new__location', $location_id );
        if ( $isNew && ( $start && $end ) ) {
            $response['days_range'] = array(
                'date_from'     => $start,
                'date_to'       => $end,
            );
            $response['is_new'] = $isNew;
        }

    }

    wp_send_json( $response );

}

add_action( 'wp_ajax_wctheme_get_location_opening_time', 'wctheme_get_location_opening_time' );
add_action( 'wp_ajax_nopriv_wctheme_get_location_opening_time', 'wctheme_get_location_opening_time' );

function wctheme_ready_for_pickpack_send() {
    return array(
        '10:00 - 12:00',
        '12:00 - 14:00',
        '14:00 - 16:00',
        '16:00 - 18:00',
        '18:00 - 20:00',
    );
}

function return_pickpack_time_range() {
    return array(
        '12:00 - 14:00',
        '14:00 - 16:00',
        '16:00 - 18:00',
        '18:00 - 20:00',
        '20:00 - 22:00',
    );
};

function wctheme_get_pickpack_time_range() {

    $response = array(
        'availability' => array(
            'range' => return_pickpack_time_range(),
        ),
    );

    wp_send_json( $response );

}

add_action( 'wp_ajax_wctheme_get_pickpack_time_range', 'wctheme_get_pickpack_time_range' );
add_action( 'wp_ajax_nopriv_wctheme_get_pickpack_time_range', 'wctheme_get_pickpack_time_range' );