<?php
/**
 * wctheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wctheme
 * @since wctheme 1.0
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wctheme_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'wctheme-product-thumbnail', 300, 300, true );
	add_image_size( 'wctheme-fullscreen', 1980, 9999 );


	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wctheme, use a find and replace
	 * to change 'wctheme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wctheme' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

}

add_action( 'after_setup_theme', 'wctheme_theme_support' );


/**
 * Register and Enqueue Styles.
 */
function wctheme_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'wctheme-style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'wctheme-style', 'rtl', 'replace' );

	wp_enqueue_style( 'wctheme-main', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version );
	wp_enqueue_style( 'wctheme-scrollbar', get_template_directory_uri() . '/assets/libs/perfect-scrollbar.css', array(), $theme_version );

}

add_action( 'wp_enqueue_scripts', 'wctheme_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function wctheme_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'wctheme-3d-carousel', get_template_directory_uri() . '/assets/libs/3dcarousel.js', array(), $theme_version, true );
	wp_enqueue_script( 'wctheme-scrollbar', get_template_directory_uri() . '/assets/libs/perfect-scrollbar.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'wctheme-validation', get_template_directory_uri() . '/assets/libs/jquery.validate.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'wctheme-js', get_template_directory_uri() . '/assets/js/scripts.min.js', array(), $theme_version, true );

}

add_action( 'wp_enqueue_scripts', 'wctheme_register_scripts' );


function myplugin_ajaxurl() {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}

add_action('wp_head', 'myplugin_ajaxurl');

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function wctheme_menus() {

	$locations = array(
		'header-left'  			=> __( 'Menu - Nagłówek - Lewa strona', 'wctheme' ),
		'header-right' 			=> __( 'Menu - Nagłówek - Prawa strona', 'wctheme' ),
		'footer-sitemap'   		=> __( 'Menu - Stopka - Mapa strony', 'wctheme' ),
		'footer-locations'   	=> __( 'Menu - Stopka - Lokalizacja', 'wctheme' ),
		'social'   				=> __( 'Menu - Media Społecznościowe', 'wctheme' ),
		'header-ecommerce'   	=> __( 'Menu - Nagłówek - Sklep', 'wctheme' ),
		'header-mobile' 		=> __( 'Menu - na urzadzenia mobilne', 'wctheme' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'wctheme_menus' );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wctheme_sidebar_registration() {

	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Sklep - panel boczny', 'wctheme' ),
				'id'          => 'shop_sidebar',
				'description' => __( 'Widgety dodane do tego panelu będą widoczne na liście produktów i kategorii.', 'wctheme' ),
			)
		)
	);

}

// add_action( 'widgets_init', 'wctheme_sidebar_registration' );

/**
 * Add ACF Plugin options page
 */
function wctheme_acf_op_init() {

    // Check function exists.
    if ( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __( 'Konfiguracja', 'wctheme' ),
            'menu_title'    => __( 'Konfiguracja', 'wctheme' ),
            'position' 		=> '65',
            'menu_slug'     => 'theme-general-settings',
        ));
    }
}

add_action('acf/init', 'wctheme_acf_op_init');

function my_acf_init() {
	acf_update_setting('google_api_key', 'xxxxxxxxxx');
}

add_action('acf/init', 'my_acf_init');


define( 'wctheme_TEMPLATES_PATH', plugin_dir_path( __FILE__ ) );

/**
 *	Require all functions
 */
require get_template_directory() . '/inc/pickpack-shipping-method.php';
require get_template_directory() . '/inc/wctheme-shipping-method.php';
require get_template_directory() . '/inc/wctheme-orders-csv-export.php';
//require get_template_directory() . '/inc/pickpack-api.php';
require get_template_directory() . '/inc/nav-walker.php';
require get_template_directory() . '/inc/functions.php';
require get_template_directory() . '/inc/cpt.php';
require get_template_directory() . '/inc/woocommerce.php';

/**
 *	Require ajax functions
 */
require get_template_directory() . '/inc/ajax.php';
require get_template_directory() . '/inc/emails/wctheme_emails.php';

/**
 * Change number or products per row to 4
 */
add_filter( 'loop_shop_columns', 'loop_columns', 999 );

if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 4; // 4 products per row
	}
}


add_action( 'wp', 'bbloomer_remove_zoom_lightbox_theme_support', 99 );
  
function bbloomer_remove_zoom_lightbox_theme_support() { 
   remove_theme_support( 'wc-product-gallery-zoom' );
   remove_theme_support( 'wc-product-gallery-lightbox' );
   // remove_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'template_redirect', function() {
    remove_theme_support( 'wc-product-gallery-zoom' );
    remove_theme_support( 'wc-product-gallery-lightbox' );
    // remove_theme_support( 'wc-product-gallery-slider' );
}, 100 );

function custom_admin_js() {
    $url = get_bloginfo('template_directory') . '/js/wp-admin.js';
    ?>
    	<style>
    		#woocommerce-order-data #order_data .order_data_column h3 {
    			display: none;
    		}
    	</style>
    	<script type="text/javascript">
    		jQuery(document).ready(function($){
    			$('#woocommerce-order-data #order_data .order_data_column h3').each(function(){
    				$(this).html($(this).html().replace( 'Płatność', 'Dane do wysyłki' ));
    				$(this).html($(this).html().replace( 'Wysyłka', 'Dane do płatności' ));
    				$(this).show();
    			})
    		});
    	</script>
    <?php
}
add_action('admin_footer', 'custom_admin_js');

function upload_svg_files( $allowed ) {
    if ( !current_user_can( 'manage_options' ) )
        return $allowed;
    $allowed['svg'] = 'image/svg+xml';
    return $allowed;
}
add_filter( 'upload_mimes', 'upload_svg_files');

function extra_profile_fields( $user ) { ?>
   
    <h3><?php _e('Kupony'); ?></h3>
   	<?php print_r(get_user_meta( $user->ID, 'wctheme_user_coupons', true )); ?>
<?php

}

// Then we hook the function to "show_user_profile" and "edit_user_profile"
add_action( 'show_user_profile', 'extra_profile_fields', 10 );
add_action( 'edit_user_profile', 'extra_profile_fields', 10 );

function sww_wc_free_shipping_label( $label, $method ) {

	if ( 0 == $method->cost ) {
		$label = 'Free shipping!';
	}

	return $label;
	
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'sww_wc_free_shipping_label', 10, 2 ); 

add_action('wp_enqueue_scripts', 'override_woo_frontend_scripts');
function override_woo_frontend_scripts() {
    wp_deregister_script('wc-checkout');
    wp_deregister_script('wc-cart');
    wp_deregister_script('wc-add-to-cart');
    wp_enqueue_script('wc-checkout', get_template_directory_uri() . '/woocommerce/js/checkout.js', array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
    wp_enqueue_script('wc-cart', get_template_directory_uri() . '/woocommerce/js/cart.js', array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
    wp_enqueue_script('wc-add-to-cart', get_template_directory_uri() . '/woocommerce/js/add-to-cart.js', array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
}

function custom_excerpt_length( $length ) {
    return 200;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );