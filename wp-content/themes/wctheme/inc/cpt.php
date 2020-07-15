<?php
/**
 *	Custom Post types
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wctheme_locations_post_type() {
	$supports = array(
		'title',
		'editor',
		'thumbnail',
		'custom-fields',
		'revisions',
	);
	$labels = array(
		'name' 				=> _x( 'Lokale', 'plural', 'wctheme' ),
		'singular_name' 	=> _x( 'Lokal', 'singular', 'wctheme' ),
		'menu_name' 		=> _x( 'Lokale', 'admin menu', 'wctheme' ),
		'name_admin_bar' 	=> _x( 'Lokal', 'admin bar', 'wctheme' ),
		'add_new' 			=> _x( 'Dodaj lokal', 'add new', 'wctheme' ),
		'add_new_item' 		=> __( 'Dodaj nowy lokal', 'wctheme' ),
		'new_item' 			=> __( 'Dodaj lokal', 'wctheme' ),
		'edit_item' 		=> __( 'Edytuj lokal', 'wctheme' ),
		'view_item' 		=> __( 'Zobacz lokal', 'wctheme' ),
		'all_items' 		=> __( 'Wszystkie lokale', 'wctheme' ),
		'search_items' 		=> __( 'Szukaj lokalu', 'wctheme' ),
		'not_found' 		=> __( 'Brak lokali', 'wctheme' ),
	);
	$args = array(
		'supports' 			=> $supports,
		'labels' 			=> $labels,
		'public' 			=> true,
		'query_var' 		=> true,
		'rewrite' 			=> array('slug' => 'lokal'),
		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'menu_icon'         => 'dashicons-store'
	);

	register_post_type( 'locations', $args );
}

add_action( 'init', 'wctheme_locations_post_type' );


function wctheme_labels_post_type() {
	$supports = array(
		'title',
		'custom-fields',
	);
	$labels = array(
		'name' 				=> _x( 'Labele', 'plural', 'wctheme' ),
		'singular_name' 	=> _x( 'Label', 'singular', 'wctheme' ),
		'menu_name' 		=> _x( 'Labele', 'admin menu', 'wctheme' ),
		'name_admin_bar' 	=> _x( 'Label', 'admin bar', 'wctheme' ),
		'add_new' 			=> _x( 'Dodaj label', 'add new', 'wctheme' ),
		'add_new_item' 		=> __( 'Dodaj nowy label', 'wctheme' ),
		'new_item' 			=> __( 'Dodaj label', 'wctheme' ),
		'edit_item' 		=> __( 'Edytuj label', 'wctheme' ),
		'view_item' 		=> __( 'Zobacz label', 'wctheme' ),
		'all_items' 		=> __( 'Wszystkie label\'e', 'wctheme' ),
		'search_items' 		=> __( 'Szukaj labeli', 'wctheme' ),
		'not_found' 		=> __( 'Brak labeli', 'wctheme' ),
	);
	$args = array(
		'supports' 			=> $supports,
		'labels' 			=> $labels,
		'public' 			=> true,
		'query_var' 		=> true,
		'rewrite' 			=> array('slug' => 'label'),
		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'menu_icon'         => 'dashicons-tag'
	);

	register_post_type( 'labels', $args );
}

add_action( 'init', 'wctheme_labels_post_type' );