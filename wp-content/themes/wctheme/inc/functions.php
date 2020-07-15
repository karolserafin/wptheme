<?php

function get_terms_and_conditions_url() {
    $url            = '';
    $terms_page_id = (int) get_option( 'woocommerce_terms_page_id' );
 
    if ( ! empty( $terms_page_id ) && get_post_status( $terms_page_id ) === 'publish' ) {
        $url = (string) get_permalink( $terms_page_id );
    }
 
    return $url;
}

/**
 *	wctheme_articles_pagination
 *
 *	@param $paged 		(int)
 *	@param $max_page 	(int)
 *
 */
function wctheme_articles_pagination( $paged=1, $max_page=999999 ) {

    global $wp_query;

	$total = 999999999;
    if( ! $paged )
        $paged = get_query_var('paged');
    if( ! $max_page )
        $max_page = $wp_query->max_num_pages;
 
    $pages =  paginate_links( array(
        'base'       => str_replace( $total, '%#%', esc_url( get_pagenum_link( $total ) ) ),
        'format'     => '?paged=%#%',
        'current'    => max( 1, $paged ),
        'total'      => $max_page,
        'mid_size'   => 1,
        'prev_text'  => __( '', 'wctheme' ),
        'next_text'  => __( '', 'wctheme' ),
        'type'       => 'array'
    ) );

    if( is_array( $pages ) ) {
        // $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<div class="pagination-wrap"><ul class="pagination">';
        foreach ( $pages as $page ) {
			echo "<li>$page</li>";
        }
		echo '</ul></div>';
	}

}

function wctheme_woocommerce_category_description() {

    if ( is_product_category() ) {
        global $wp_query;
        $term = $wp_query->get_queried_object();
        echo $term->description;
    }

}

add_action('woocommerce_category_description', 'wctheme_woocommerce_category_description', 2);

function wctheme_categories_filter() {

    $exclude    = array( 15 );
    $opt_terms  = get_field( 'disabled_categories', 'options' );

    if ( !empty( $opt_terms ) ) {

        foreach( $opt_terms as $term ) {
            $exclude[] = $term->term_id;
        }

    }

    return get_terms( array(
        'exclude'       => $exclude,
        'taxonomy'      => 'product_cat',
        'hide_empty'    => false,
        'orderby'       => 'menu_order',
    ) );

}

function wctheme_get_current_category_slug() {

    if ( is_product_category() ) {
        global $wp_query;
        $term = $wp_query->get_queried_object();
        return $term->slug;
    }

}

function wctheme_get_locations_list() {

    $args       = array(
        'post_type'         => 'locations',
        'posts_per_page'    => -1,
    );

    $query      = new WP_Query( $args );
    $locations  = array();

    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) : $query->the_post();

            $locations[]    = array(
                'id'            => get_the_ID(),
                'name'          => get_the_title(),
                'availability'  => array(
                    'monday'            => array(
                        'opening'           => get_field( 'availability_monday' )['opening'],
                        'closing'           => get_field( 'availability_monday' )['closing'],
                        'range'             => wctheme_generate_location_select_options( get_field( 'availability_monday' )['opening'], get_field( 'availability_monday' )['closing'] ),
                        'is_open'           => get_field( 'availability_monday' )['is_open'],
                    ),
                    'tuesday'           => array(
                        'opening'           => get_field( 'availability_tuesday' )['opening'],
                        'closing'           => get_field( 'availability_tuesday' )['closing'],
                        'range'             => wctheme_generate_location_select_options( get_field( 'availability_tuesday' )['opening'], get_field( 'availability_tuesday' )['closing'] ),
                        'is_open'           => get_field( 'availability_tuesday' )['is_open'],
                    ),
                    'wednesday'         => array(
                        'opening'           => get_field( 'availability_wednesday' )['opening'],
                        'closing'           => get_field( 'availability_wednesday' )['closing'],
                        'range'             => wctheme_generate_location_select_options( get_field( 'availability_wednesday' )['opening'], get_field( 'availability_wednesday' )['closing'] ),
                        'is_open'           => get_field( 'availability_wednesday' )['is_open'],
                    ),
                    'thursday'          => array(
                        'opening'           => get_field( 'availability_thursday' )['opening'],
                        'closing'           => get_field( 'availability_thursday' )['closing'],
                        'range'             => wctheme_generate_location_select_options( get_field( 'availability_thursday' )['opening'], get_field( 'availability_thursday' )['closing'] ),
                        'is_open'           => get_field( 'availability_thursday' )['is_open'],
                    ),
                    'friday'            => array(
                        'opening'           => get_field( 'availability_friday' )['opening'],
                        'closing'           => get_field( 'availability_friday' )['closing'],
                        'range'             => wctheme_generate_location_select_options( get_field( 'availability_friday' )['opening'], get_field( 'availability_friday' )['closing'] ),
                        'is_open'           => get_field( 'availability_friday' )['is_open'],
                    ),
                    'saturday'          => array(
                        'opening'           => get_field( 'availability_saturday' )['opening'],
                        'closing'           => get_field( 'availability_saturday' )['closing'],
                        'range'             => wctheme_generate_location_select_options( get_field( 'availability_saturday' )['opening'], get_field( 'availability_saturday' )['closing'] ),
                        'is_open'           => get_field( 'availability_saturday' )['is_open'],
                    ),
                    'sunday'            => array(
                        'opening'           => get_field( 'availability_sunday' )['opening'],
                        'closing'           => get_field( 'availability_sunday' )['closing'],
                        'range'             => wctheme_generate_location_select_options( get_field( 'availability_sunday' )['opening'], get_field( 'availability_sunday' )['closing'] ),
                        'is_open'           => get_field( 'availability_sunday' )['is_open'],
                    ),
                ),
            );

        endwhile;

    }

    return $locations;

}

function wctheme_generate_location_select_options( $opening, $closing ) {

    if ( ! $opening && ! $closing ) {
        return;
    }

    $start              = (int) substr( $opening, 0, strpos( $opening, ":" ) );
    $end                = (int) substr( $closing, 0, strpos( $closing, ":" ) );
    $step               = 3;
    $total              = $end - $start;
    $segments           = intdiv( $total, $step );
    $result             = array();
    $response           = array( __( 'Wybierz godzinę odbioru', 'wctheme' ) );

    if ( $total > 3 ) {
        for ( $i = 0 ; $i <= $segments; $i++ ) { 
            if ( $i == 0 ) {
                $result[]   = array(
                    'start'     => $start,
                    'end'       => $start+3,
                );
            } else {
                if ( $result[$i-1]['end']+3 > $end ) {
                    $result[]   = array(
                        'start'     => $result[$i-1]['end'],
                        'end'       => $end,
                    );
                } else {
                    $result[]   = array(
                        'start'     => $result[$i-1]['end'],
                        'end'       => $result[$i-1]['end']+3,
                    );
                }
            }
        }

        foreach ( $result as $range ) {
            $response[] = wctheme_format_hour_to_string( $range['start'] ) . ' - ' . wctheme_format_hour_to_string( $range['end'] );
        }
    } else {
        $response[]     = wctheme_format_hour_to_string( $start ) . ' - ' . wctheme_format_hour_to_string( $end );
    }    

    return $response;

}

function wctheme_format_hour_to_string( $hour ) {
    if ( ! $hour ) {
        return;
    }

    if ( $hour < 10 ) {
        return (string) '0' . $hour . ':00';
    }

    return (string) $hour . ':00';

}

function wctheme_get_enabled_gateways_list() {

    $gateways           = WC()->payment_gateways->get_available_payment_gateways();
    $enabled_gateways   = [];

    if( $gateways ) {

        foreach( $gateways as $gateway ) {

            if( $gateway->enabled == 'yes' ) {
                $enabled_gateways[] = $gateway;
            }

        }

    }

    return $enabled_gateways;

}

function wctheme_get_user_favourites_products() {

    if ( isset( $_COOKIE['favoritesProducts'] ) ) {
        $favoriteProducts   = $_COOKIE['favoritesProducts'];
        $favorites          = explode(',', $favoriteProducts);

        if ( $favorites ) {
            return $favorites;
        }

    }

    return array();

}

function wctheme_get_first_available_shipping_day() {

    global $woocommerce;

    foreach ( $woocommerce->cart->get_cart() as $cart_item ) {

        if ( has_term( 'torty', 'product_cat', $cart_item['product_id'] ) ) {

            $product_item = $cart_item['data'];

            if ( ! empty( $product_item ) && $product_item->is_type( 'variation' ) ) {

                if ( $product_item->get_variation_attributes() ) {

                    $attr       = $product_item->get_variation_attributes()['attribute_pa_ilosc_osob'];
                    if ( $attr ) {

                        // $attribute  = substr( $attr, 0, strpos( $attr, "-" ) );

                        if ( $attr != '8-10' ) {
                            return true;
                        }

                    }

                }

            }

        }

    }

    return false;

}

// add_filter( 'get_terms', 'wctheme_get_subcategry_terms', 10, 3 );

function wctheme_get_subcategry_terms( $terms, $taxonomies, $args ) {
    
    if( is_admin() && 'product_cat' !== $taxonomies[0] ) {
        return $terms;
    }

    $data       = [];
    $new_terms  = [];

    $opt_terms  = get_field( 'disabled_categories', 'options' );

    if ( empty( $opt_terms ) ) {
        return $terms;
    }

    foreach( $opt_terms as $term ) {
        $data[] = $term->slug;
    }
    
    $mwd_opt1 = in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop();
    $mwd_opt2 = in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_front_page();
    $mwd_opt3 = in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_home();
    $mwd_opt5 = in_array( 'product_cat', $taxonomies ) && ! is_admin();
    
    if ( $mwd_opt1 || $mwd_opt2 || $mwd_opt3 || $mwd_opt5 ) {
    
        foreach ( $terms as $key => $term ) {
            
            if ( $term->slug ) {
                if ( ! in_array( $term->slug, $data ) ) {
                    $new_terms[] = $term;
                }
            }

        }
        
        $terms = $new_terms;
    }
    
    return $terms;
    
}

add_action( 'woocommerce_product_query', 'wctheme_remove_product_from_disabled_category' );

function wctheme_remove_product_from_disabled_category( $q ) {

    $data       = [];
    $new_terms  = [];

    $opt_terms  = get_field( 'disabled_categories', 'options' );

    if ( empty( $opt_terms ) ) {
        return;
    }

    foreach( $opt_terms as $term ) {
        $data[] = $term->slug;
    }
    
    // $q->set( 'orderby', 'menu_order' );

    $tax_query      = (array) $q->get('tax_query');
    $tax_query[]    = array(
        'taxonomy'     => 'product_cat',
        'field'        => 'slug',
        'terms'        => $data,
        'operator'     => 'NOT IN'
    );
    $q->set( 'tax_query', $tax_query );
}

add_filter( 'get_the_archive_title', 'modify_archive_title', 10, 1 );
 
function modify_archive_title( $title ) {
    
    if ( is_month() ) {
        $title = sprintf( __( 'Aktualności: %s', 'wctheme' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
    }
 
    return $title;
 
}

function get_blog_base_url() {

    $args = array(
        'post_type'     => 'page',
        'fields'        => 'ids',
        'nopaging'      => true,
        'meta_key'      => '_wp_page_template',
        'meta_value'    => 'page-blog.php'
    );

    $pages = get_posts( $args );

    return get_permalink( $pages[0] );

}

add_action( 'pre_get_posts', 'change_archive_per_page_limit' );

function change_archive_per_page_limit( $query ) {

    if ( ! is_admin() && $query->is_main_query() ) {
        if ( is_month() ) {

            $query->set( 'posts_per_page', 11 );
        }
    }
    
}

add_action( 'woocommerce_product_query', 'apply_products_filter_on_query' );

function apply_products_filter_on_query( $query ) {

    if ( is_shop() ) {

        $query->set( 'posts_per_page', 12 );
        // $query->set( 'orderby', 'menu_order' );

        if ( !empty( $_GET['category'] ) ) {
            $tax_query[]    = array(
                'taxonomy'     => 'product_cat',
                'field'        => 'slug',
                'terms'        => $_GET['category'],
                'operator'     => 'IN'
            );
            $query->set( 'tax_query', $tax_query );
        }

        if ( !empty( $_GET['tag'] ) ) {
            $tax_query[]    = array(
                'taxonomy'     => 'product_tag',
                'field'        => 'slug',
                'terms'        => array( $_GET['tag'] ),
                'operator'     => 'IN'
            );
            $query->set( 'tax_query', $tax_query );
        }             

    }

}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

function wctheme_check_product_availability_dates() {

    $start_range    = array();
    $end_range      = array();
    $enabled        = 0;

    foreach( WC()->cart->get_cart() as $cart_item ) {
        
        $enabled    = get_post_meta( $cart_item['product_id'], 'wpas_schedule_sale_status', 'true' );
        $start      = get_post_meta( $cart_item['product_id'], 'wpas_schedule_order_st_time', true );
        $end        = get_post_meta( $cart_item['product_id'], 'wpas_schedule_order_end_time', true );

        if ( $enabled && $start && $end ) {
            $enabled        = $enabled+1;
            $start_range[]  = $start;
            $end_range[]    = $end;
        }

    }

    if ( ! empty( $start_range ) && ! empty( $end_range ) ) {
        $range = array(
            'message'   => sprintf( __( 'Masz w koszyku produkty sezonowe, które mozna zamówić w określonym zakresie czasowym tj. od %s do %s.', 'wctheme' ), date( 'd-m-Y', max($start_range) ), date( 'd-m-Y', max($end_range) ) ),
            'start'     => date( 'd-m-Y', max( $start_range ) ),
            'end'       => date( 'd-m-Y', max( $end_range ) ),
        );

        return $range;
    }

    return false;

}

add_filter( 'fbl/user_data_login', 'wctheme_fb_login_modify_user_role' );

function wctheme_fb_login_modify_user_role( $user ) {
    $user['role']   = 'customer';
    return $user;
}

add_filter( 'woocommerce_my_account_my_orders_query', 'custom_my_account_orders', 10, 1 );

function custom_my_account_orders( $args ) {

    $args['posts_per_page'] = 10;
    return $args;
}

function get_page_id( $template_name ) {
    
    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'meta_query' => [
            [
                'key' => '_wp_page_template',
                'value' => $template_name.'.php',
                'compare' => '='
            ]
        ]
    ]);

    if ( !empty($pages) ) {
        
        foreach($pages as $pages__value) {
            return $pages__value->ID;
        }
    }
    
    return get_bloginfo('url');
}

function get_breadcrumb() {

    echo '<nav class="woocommerce-breadcrumb">';

    printf( '<a href="%s" rel="nofollow">%s</a>', home_url(), get_the_title( get_option('page_on_front') ) );

    if ( is_category() || is_single() ) {

        $news_page_id       = get_page_id( 'page-blog' );
        $news_page_url      = get_permalink( $news_page_id );
        $news_page_title    = get_the_title( $news_page_id );

        echo '&nbsp;/&nbsp;';
        echo '<a href="'. $news_page_url .'" title="' .$news_page_title . '">'. $news_page_title .'</a>';
        // the_category('&bull;');

        if ( is_single() ) {
            echo '&nbsp;/&nbsp;';
            echo mb_strimwidth( get_the_title() , 0, 50, "...");
        }

    } elseif ( is_page() ) {
        echo '&nbsp;/&nbsp;' . get_the_title();
    } elseif ( is_search() ) {
        echo '&nbsp;/&nbsp;';
        the_search_query();
    }

    echo '</nav>';

}

if ( ! function_exists( 'filter_woocommerce_valid_order_statuses_for_payment' ) ) {

    function filter_woocommerce_valid_order_statuses_for_payment( $array, $instance ) {
        $custom_statuses = array( 'payment-error' );
        return array_merge($array, $custom_statuses);
    }

    add_filter( 'woocommerce_valid_order_statuses_for_payment', 'filter_woocommerce_valid_order_statuses_for_payment', 10, 2 );

}

function exclude_products_from_query() {
    
    $exclude        = array();
    $args           = array(
        'post_type'     => 'product',
        'meta_query'    => array(
            'relation'      => 'AND',
            array(
                'key'       => 'wpas_schedule_sale_status',
                'value'     => 1,
                'compare'   => '=',
            ),
            array(
                'key'       => 'wpas_schedule_sale_mode',
                'value'     => 0,
                'compare'   => '=',
            ),
        )
    );

    $products = get_posts( $args ); 

    foreach ($products as $product) :
        
        $today  = time();

        $start  = get_post_meta( $product->ID, '', true );
        $end    = get_post_meta( $product->ID, '', true );

        if ( $today > $end || $today < $start ) {
            $exclude[] = $product->ID;
        }

    endforeach;

    return $exclude;

}

add_action( 'restrict_manage_posts', 'add_meta_value_to_posts' );

function add_meta_value_to_posts( $post_type ){

    if ( $post_type == 'shop_order' ) {

        global $wpdb;
        $results = $wpdb->get_results( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'locations'", OBJECT );

        if ( $results ) {

            foreach ($results as $location) {
                $locations[$location->ID] = get_the_title($location->ID);
            }

            // Generate select field from meta values
            echo '<select name="_wctheme_pickup_location" id="_wctheme_pickup_location">';

                $all_selected = $_REQUEST['_wctheme_pickup_location'] == 'all' ? ' selected' : '';
                echo '<option value="all"'.$all_selected.'>Wszystkie lokalizacje</option>';

                foreach ( $locations as $id => $name ) {
                    $selected = $_REQUEST['_wctheme_pickup_location'] == $id ? ' selected' : '';
                    echo '<option value="'.$id.'"'.$selected.'>'.$name.'</option>';
                }

            echo '</select>';

        }

    }

}

// Hook parse_query to add new filter parameters
add_filter( 'parse_query', 'filter_posts_per_meta_value' );

function filter_posts_per_meta_value( $query ) {

    global $pagenow, $post_type;
    // Only add parmeeters if on shop_order and if all is not selected
    if( $pagenow == 'edit.php' && $post_type == 'shop_order' && !empty($_GET['_wctheme_pickup_location']) && $_GET['_wctheme_pickup_location'] != 'all' ) {

        $meta = array(
            array(
                'key'           => '_wctheme_pickup_location',
                'value'         => $_GET['_wctheme_pickup_location'],
                'compare'       => 'EXISTS',
            )
        );

        $query->set( 'meta_query', $meta );

    }

}

function display_shipping_dropdown(){

    if (is_admin() && !empty($_GET['post_type']) && $_GET['post_type'] == 'shop_order'){

        $exp_types = array(
            'pickpack' => __( 'Kurier PickPack', 'wctheme' ),
            'flat_rate' => __( 'Kurier DHL', 'wctheme' ),
            'local_pickup' => __( 'Odbiór osobisty', 'wctheme' ),
            'wctheme_free_shipping' => __( 'Kurier wctheme', 'wctheme' ),
        );


        ?>
        <select name="shipping_method">
            <option value="all"><?php _e('Wszystkie metody dostawy', 'wctheme'); ?></option>
            <?php
            $current_v = isset($_GET['shipping_method']) ? $_GET['shipping_method'] : '';
            foreach ($exp_types as $key => $label) {
                printf('<option value="%s"%s>%s</option>', $key, $label == $key? ' selected="selected"':'', $label );
            }
            ?>
        </select>
        <?php
    }
}
add_action( 'restrict_manage_posts', 'display_shipping_dropdown' );

add_filter( 'parse_query', 'filter_posts_by_shipping_value' );

function filter_posts_by_shipping_value( $query ) {

    global $pagenow, $post_type;
    // Only add parmeeters if on shop_order and if all is not selected
    if( $pagenow == 'edit.php' && $post_type == 'shop_order' && !empty($_GET['shipping_method']) && $_GET['shipping_method'] != 'all' ) {

        $meta = array(
            array(
                'key'           => '_wctheme_shipping_metod',
                'value'         => $_GET['shipping_method'],
                'compare'       => '=',
            )
        );

        $query->set( 'meta_query', $meta );

    }

}

add_action( 'wp_ajax_wctheme_generate_social_media_image', 'wctheme_generate_social_media_image' );
add_action( 'wp_ajax_nopriv_wctheme_generate_social_media_image', 'wctheme_generate_social_media_image' );

function wctheme_generate_social_media_image() {
    include 'template/product-social-image.php';
    die;
}

add_action( 'wp_ajax_wctheme_save_product_social_media_image', 'wctheme_save_product_social_media_image' );
add_action( 'wp_ajax_nopriv_wctheme_save_product_social_media_image', 'wctheme_save_product_social_media_image' );

function wctheme_save_product_social_media_image() {

    $product            = $_POST['product'];
    $image              = $_POST['image'];

    $upload_dir         = wp_upload_dir();
    $upload_path        = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

    $img                = $image;
    $img                = str_replace('data:image/png;base64,', '', $img);
    $img                = str_replace(' ', '+', $img);

    $decoded            = base64_decode($img);
    $filename           = 'share_'. $product .'.png';

    $hashed_filename    = md5( $filename . microtime() ) . '_' . $filename;
    $image_upload       = file_put_contents( $upload_path . $hashed_filename, $decoded );

    if( !function_exists( 'wp_handle_sideload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    if( !function_exists( 'wp_get_current_user' ) ) {
        require_once( ABSPATH . 'wp-includes/pluggable.php' );
    }

    $file               = array(
        'error'             => '',
        'tmp_name'          => $upload_path . $hashed_filename,
        'name'              => $hashed_filename,
        'type'              => 'image/png',
        'size'              => filesize( $upload_path . $hashed_filename ),
    );

    $file_return        = wp_handle_sideload( $file, array( 'test_form' => false ) );

    $filename           = $file_return['file'];
    $attachment         = array(
        'post_mime_type'     => $file_return['type'],
        'post_title'         => preg_replace('/\.[^.]+$/', '', basename($filename)),
        'post_content'       => '',
        'post_status'        => 'inherit',
        'guid'               => $upload_dir['url'] . '/' . basename($filename)
    );

    $attach_id          = wp_insert_attachment( $attachment, $filename, 289 );

    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $attach_data        = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    update_post_meta( $product, 'wctheme_share_image_link', $attach_id );

}

add_action( 'add_meta_boxes', 'wctheme_add_image_product_meta_box' );

function wctheme_add_image_product_meta_box() {
    add_meta_box( 'wctheme_order_courier', __( 'Wygeneruj grafikę', 'wctheme' ), 'wctheme_generate_image_action', 'product', 'side', 'core' );
}

function wctheme_generate_image_action() {
    global $post;
    echo '<a target="_blank" href="'. admin_url( 'admin-ajax.php?action=wctheme_generate_social_media_image&product=' . $post->ID ) .'" class="button button-primary pdf-action">Wygeneruj grafikę</a>';
}
