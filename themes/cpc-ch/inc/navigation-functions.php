<?php 

/**
 * Navigation Functions
 */


define( 'NAVIGATION_ITEM', 'navigation__item' );
define( 'IS_PARENT', 'navigation__item--is-parent' );
define( 'IS_CURRENT', 'navigation__item--is-current' );
define( 'IS_CURRENT_PARENT', 'navigation__item--is-current-parent' );
define( 'IS_LAST', 'navigation__item--is-last' );
define( 'IS_DROPDOWN', 'navigation__item--is-dropdown' );
define( 'IS_OVERVIEW', 'navigation__item--is-overview' );

$menu_titles = 	__( 'All posts in Cybercommerce', 'cpc-ch' ) .
				__( 'All posts in Marketing', 'cpc-ch' ) .
				__( 'All posts in Expédition', 'cpc-ch' );

function build_nav ( $items , $args ) {

	$page_id 					= get_queried_object_id();
	$current 					= '';
	$last 						= '';
	$new_items 					= array();
	$parents 					= array();

	if( $args->theme_location == 'navigation' ) {


		function add_navigation_item( $title, $url, $parent, $id, $classes ) {
				$item = array('title' => $title,'url' => $url,'menu_item_parent' => $parent,'ID' => '','db_id' => '','object_id'=> $id, 'classes' => $classes, 'target' => '', 'xfn' => '', 'current' => '' );
			return (object) $item;
		}

		function add_current_parent ( $items ) {
			for ( $i=0 ; $i<sizeof( $items ) ; $i++ ){
				if ( in_array( IS_CURRENT , $items[$i]->classes ) ) {
					$parent_id = $items[$i]->menu_item_parent;
					for ( $j=0 ; $j<sizeof( $items ) ; $j++ ) {
						if( $items[$j]->ID == $parent_id ) {
							array_push( $items[$j]->classes, IS_CURRENT_PARENT );
						}
					}
				}
			}
			return $items;
		}

		for ( $i=1 ; $i<count( $items )+1 ; $i++ ) {
			if( $items[$i]->menu_item_parent && $items[$i]->menu_item_parent != 0 ) {
				$current = ( $items[$i]->object_id == $page_id ) ? IS_CURRENT : '';
				for ( $j=1 ; $j<count( $items )+1 ; $j++ ){
					if( $items[$j]->ID == $items[$i]->menu_item_parent ) {
						if ( !in_array( $items[$i]->menu_item_parent, $parents ) ) {
							$new_items[] = add_navigation_item( __( 'All posts in '.$items[$j]->title, 'cpc-ch' ), $items[$j]->url, $items[$i]->menu_item_parent, $items[$j]->object_id, array( NAVIGATION_ITEM , IS_DROPDOWN , IS_OVERVIEW ));
						}
						if( ( $i + 1 ) <= count( $items ) ) {
							$last = ( $items[$i+1]->menu_item_parent==0 ) ? IS_LAST : '';
						}
						$items[$i]->classes = array( NAVIGATION_ITEM, IS_DROPDOWN , $current, $last );
						$new_items[] = $items[$i];
						$parents[] = $items[$i]->menu_item_parent;     
					}
				}
			} else {
				$current = ( $items[$i]->object_id == $page_id ) ? IS_CURRENT_PARENT : '';
				if( in_array( 'menu-item-has-children', $items[$i]->classes ) ) {
					$items[$i]->classes = array( NAVIGATION_ITEM , IS_PARENT , $current );
				} else {
					$items[$i]->classes = array( NAVIGATION_ITEM , $current );
				}
				$new_items[] = $items[$i]; 
				$current = '';
			}
		}
	$new_items 	= add_current_parent( $new_items );
	
} 
	if( $args->theme_location == 'navigation' )
		return $new_items; 
	return $items;  
}

if (! has_filter( 'wp_nav_menu_objects', 'build_nav' ))
	add_filter( 'wp_nav_menu_objects', 'build_nav', 10, 2 );


?>