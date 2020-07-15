<?php

class wctheme_Nav_Walker extends Walker_Nav_Menu {
 
   function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
 
      	global $wp_query;

      	$menu 		= wp_get_nav_menu_object($args->menu);
      	$indent 		= ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $submenu_image_right = get_field('submenu_image_right', 'options');

      	if ( ( $args->theme_location == 'header-left' || $args->theme_location == 'header-right' ) && get_field( 'dropdown', $item ) ) {
      		$item->classes[] = 'item__dropdown';
      	}

      	$megamenu 		= '';

      	if ( $args->theme_location == 'header-left' && get_field( 'dropdown', $item ) ) {
			  $megamenu 		= '<div class="dropdown__menu">
			  <div class="uk-container uk-container-large">
			  <div uk-grid>
			  <div class="uk-width-1-2@xl uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl center-dropdown-menu">';
      		$megamenu		.= '<ul class="uk-column-1-2">';
      		foreach ( get_field( 'categories', $menu ) as $term ) :
      			$megamenu		.= sprintf( '<li data-term="%s"><a href="%s">%s</a></li>', $term->slug, get_term_link( $term->term_id ), $term->name );
      		endforeach;
			  $megamenu 		.= '</ul>
			  </div>
			  <div class="uk-width-1-2@xl uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl img-container">
			  <div>';
        foreach ( get_field( 'categories', $menu ) as $term ) :
          $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true ); 
          $image        = wp_get_attachment_url( $thumbnail_id );
          if ( $image ) {
            $megamenu    .= "<img src='{$image}' alt='{$term->name}' data-term='{$term->slug}'' />";
          } 
          endforeach;

        if ( !empty( $submenu_image_right ) ) {
          $megamenu .= "<img src='$submenu_image_right' alt='' class='submenu_image_right' />";
        }

        $megamenu .= '</div></div></div></div></div>';
      	}

      	if ( $args->theme_location == 'header-right' && get_field( 'dropdown', $item ) ) {
			  $megamenu 		= '<div class="dropdown__menu">
			  <div class="uk-container uk-container-large">
			  <div uk-grid>
			  <div class="uk-width-1-2@xl uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl center-dropdown-menu">';
      		$megamenu		.= '<ul>';
            $i = 0;
            if( have_rows( 'locations', $menu ) ):
               while ( the_repeater_field( 'locations', $menu ) ) :
                   $megamenu       .= sprintf( '<li data-term="%s"><a href="%s">%s</a></li>', $i, esc_attr( $item->url . '?location=' . get_sub_field( 'url_param', $menu ) ), get_sub_field( 'title', $menu ) );   
                   $i++;
               endwhile;  
            endif; 

			  $megamenu 		.= '</ul>
			  </div>
			  <div class="uk-width-1-2@xl uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl img-container"><div>';
            $i = 0;
            if( have_rows( 'locations', $menu ) ):
   			   while ( the_repeater_field( 'locations', $menu ) ) :
                   $megamenu       .= sprintf( '<img src="%s" alt="%s" data-term="%d" />', get_sub_field( 'image', $menu ), get_sub_field( 'title', $menu ), $i );
                   $i++;
               endwhile; wp_reset_query(); 
            endif;
			  if ( !empty( $submenu_image_right ) ) {
          $megamenu .= "<img src='$submenu_image_right' alt='' class='submenu_image_right' />";
        }
        $megamenu 		.= '</div></div></div></div></div>';
      	}

      	$class_names 	= $value = '';
      	$classes 		= empty( $item->classes ) ? array() : (array) $item->classes;
      	$class_names 	= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
      	$class_names 	= ' class="'. esc_attr( $class_names ) . '"';
      	$output 		.= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
 
      	$attributes 	= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
      	$attributes 	.= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
      	$attributes 	.= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
      	$attributes 	.= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
  
      	$item_output 	= $args->before;
      	$item_output 	.= '<a'. $attributes .'>';
      	$item_output 	.= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
      	$item_output 	.= $args->link_after;

      	if( $args->theme_location == 'header-left' && get_field( 'dropdown', $item ) ) {
      		$item_output 	.= '<span class="dropdown__arrow"></span>';
      	}

      	$item_output 	.= '</a>';
      	$item_output 	.= $megamenu;

      	$item_output 	.= $args->after;
 
      	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

   }
 
}

class wctheme_mobile_Nav_Walker_Nav_Menu extends Walker_Nav_Menu {
     function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        if ( 'header-mobile' == $args->theme_location ) {
            $submenus = 0 == $depth || 1 == $depth ? get_posts( array( 'post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $item->ID, 'fields' => 'ids' ) ) ) ) : false;
            $item_output .= ! empty( $submenus ) ? ( 0 == $depth ? '<span class="arrow"></span>' : '<span class="sub-arrow"></span>' ) : '';
        }
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}