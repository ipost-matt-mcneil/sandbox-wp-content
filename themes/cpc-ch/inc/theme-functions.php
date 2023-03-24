<?php 

/**
 * Theme Functions
 */

add_action( 'init', 'register_navigation' );

function register_navigation () {
	register_nav_menu( 'navigation', __( 'Main Navigation' ) );
	register_nav_menu( 'homepage_navigation', __( 'Homepage Navigation' ) );
	register_nav_menu( 'footer_navigation', __( 'Footer Navigation' ) );
}

add_action( 'wp_head', 'pingback_header' );

function pingback_header () {
  if ( is_singular() && pings_open() ) :
    echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
  endif;
}

add_filter( 'posts_where', 'hide_passworded_posts' );

function hide_passworded_posts ( $where = '' ) {
  if ( !is_single() && !is_admin() ) {
    $where .= " AND post_password = ''";
  }
  return $where;
}

function build_author ( $username ) {
	if ( is_plugin_active( 'cmb2/init.php' ) && is_plugin_active( 'cpc-contenthub/cpc-contenthub.php' )  ) {
		$hide_canada_post_author_checked = cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_hide_canada_post_as_author' );
		if ( $hide_canada_post_author_checked && ( $username == 'canadapost' || $username == 'canada-post' ) ) {
			return false;
		}
	}
	return true;
}

function build_title ( $title = null ) {
  $new_title = '';
  $title_array = preg_split( '/\s+/', $title );
  foreach ( $title_array as $title_piece ) {
    if ( strpos($title_piece , '-' ) !== false ) {
      $new_title .= '<span class="nowrap">' . $title_piece . '</span> ';
    } else {
      $new_title .= $title_piece .' ';
    }
  }
  return substr( $new_title, 0, -1 );
}

function build_category_icon ( $post_id = null ) {
	$categories = apply_filters( 'the_category_list', get_the_category( $post_id ), $post_id ); // Return all posts categories
	foreach ( $categories as $category ) {
		if ( get_term_meta($category->term_id, 'cpc_ch_category_cross_sell_category_icon', true ) ) {
			return '<div class="' . get_term_meta($category->term_id, 'cpc_ch_category_cross_sell_category_icon', true ) . '"></div>'; // Appends icon under certain categories
		}
	}
}

function build_breadcrumbs( $post_id = null, $term_id = null ) {
	$resources_ids 		= array( 
		(( isset(get_category_by_slug('marketing-resources')->term_id )) ? get_category_by_slug('marketing-resources')->term_id : ''), 
		(( isset(get_category_by_slug('marketing-ressources')->term_id )) ? get_category_by_slug('marketing-ressources')->term_id : ''), 
		(( isset(get_category_by_slug('shipping-resources')->term_id )) ? get_category_by_slug('shipping-resources')->term_id : ''), 
		(( isset(get_category_by_slug('expedition-ressources')->term_id )) ? get_category_by_slug('expedition-ressources')->term_id : ''), 
		(( isset(get_category_by_slug('ecommerce-resources')->term_id )) ? get_category_by_slug('ecommerce-resources')->term_id : ''), 
		(( isset(get_category_by_slug('cybercommerce-ressources')->term_id )) ? get_category_by_slug('cybercommerce-ressources')->term_id : ''), 
	);
	$breadcrumbs 					= array();
	$child_ids 						= array();
	$parent_ids 					= array();
	$term_id 							= ( $term_id ) ? $term_id : ( ( isset( get_queried_object()->term_id ) ) ? get_queried_object()->term_id : null );
	$parent_id 						= ( isset( get_queried_object()->parent  ) ) ? get_queried_object()->parent : null;
	$grandparent		 			= get_category( $parent_id );
	$grandparent_id 			= ( isset( $grandparent->parent )  ) ? $grandparent->parent : 0;
	$term_meta 						= get_term_meta( $term_id );
	$term_category_type		= ( isset( $term_meta[ 'cpc_ch_category_type' ][0] ) ) ? $term_meta[ 'cpc_ch_category_type' ][0] : null;
	$parent_meta 					= get_term_meta( $parent_id );
	$parent_category_type	= ( isset( $parent_meta[ 'cpc_ch_category_type' ][0] ) ) ? $parent_meta[ 'cpc_ch_category_type' ][0] : null;
	
	if ( ! $post_id && $term_category_type === 'resources' ) {
		array_push( $breadcrumbs, array( 'title' => __( 'Home', 'cpc-ch' ) , 'url' => get_home_url() ));
		array_push( $breadcrumbs, array( 'title' => get_cat_name( $parent_id ) , 'url' => get_term_link( $parent_id, 'category' ) ));
		return build_breadcrumbs_html( $breadcrumbs );
	}
	if ( $parent_category_type === 'resources' ) {
		array_push( $breadcrumbs, array( 'title' => get_cat_name( $grandparent_id ) , 'url' => get_term_link( $grandparent_id, 'category' ) ));
		array_push( $breadcrumbs, array( 'title' => get_cat_name( $parent_id ) , 'url' => get_term_link( $parent_id, 'category' ) ));
		return build_breadcrumbs_html( $breadcrumbs );
	}
	if ( $post_id ) {
		if ( is_category() && $term_id ) {
			if ( $parent_id != 0 ) {
				if ( $grandparent_id ) {
					array_push( $parent_ids, $grandparent_id );
				} else {
					array_push( $parent_ids, $parent_id );
				}
			} else {
				array_push( $parent_ids, $term_id );
			}
		}
		foreach ( get_the_category( $post_id ) as $category ) {	
			if ( $category->parent === 0 )  {
				array_push( $parent_ids, $category->cat_ID );
			}
		}
		if ( isset( $parent_ids[0] ) ) { 
			if( $parent_id != 0 ) {
				array_push( $child_ids, $term_id );
			}
			if ( sizeof( $child_ids ) === 0  ) {
				foreach ( get_the_category( $post_id ) as $category ) {
					if ( $category->parent != 0 && $category->parent === $parent_ids[0] )  {
						if ( ! in_array( $category->parent, $resources_ids ) ) {
							array_push( $child_ids, $category->term_id );
						}
					} 
				}
			}
			array_push( $breadcrumbs, array( 'title' => get_cat_name( $parent_ids[0] ) , 'url' => get_term_link( $parent_ids[0], 'category' ) ));
			if ( isset( $child_ids[0] ) ) { 
				array_push( $breadcrumbs, array( 'title' => get_cat_name( $child_ids[0] ) , 'url' => get_term_link( $child_ids[0], 'category' ) ));
			}
			return build_breadcrumbs_html( $breadcrumbs );
		}
		return;
	}
}

function build_breadcrumbs_html ( $breadcrumbs = null ) {
	$html = '';
	if ( $breadcrumbs ) {
		$html .= '<div class="breadcrumbs">';
		foreach ( $breadcrumbs as $key => $breadcrumb ) {

			// IA 5702 - Temporary fix for Magazine to hide second breadcrumb

			if( $key === 1) {
				if ( is_plugin_active( 'cmb2/init.php' ) && is_plugin_active( 'cpc-contenthub/cpc-contenthub.php' )  ) {
					if ( cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_hide_subcategories' ) ) {
						break;
					}
				}
			}
			$html .= '<div class="breadcrumbs__item">';
			$html .= '<a href="'.$breadcrumb['url'].'" class="breadcrumbs__link">';
			$html .= $breadcrumb['title'];
			$html .= '</a>';
			$html .= ' </div>';
		}
		$html .= '</div>';
	}
	return $html;
}

/* 	Commenting out but leaving for reference
	//CPG Custom Filter in WPML until resolution of https://wpml.org/forums/topic/template-path-functions-in-a-multi-instance-environment/
add_filter( 'wpml_template_paths_verify', 'wpml_templates_instance_aware', 10, 1);

function wpml_templates_instance_aware( $templates ) {
	if( is_array( $templates ) ) {
		$splitter = 'web/blogs/';
		$server_path = substr( ABSPATH, 0, -3);
		
		foreach( $templates as &$template) {
			if ( false !== strpos( $template, $splitter ) ) {
				$path_elements = explode( $splitter, $template );
				$template = $server_path . $splitter . $path_elements[1];
			}
		}

		unset($template);
	}
	
	return $templates;
} */

/**
 * Maintain tag order for IA-4169
 */

add_action( 'init', 'do_the_terms_in_order');

function do_the_terms_in_order () {
  global $wp_taxonomies;
  $wp_taxonomies['post_tag']->sort = true;
  $wp_taxonomies['post_tag']->args = array( 'orderby' => 'term_order' );
}

function get_blogs_path() {
	$path = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? "blogues" : "blogs";
	return $path;
}
function get_business_path() {
	$path = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? "entreprise" : "business";
	return $path;
}
function get_personal_path() {
	$path = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? "personnel" : "personal";
	return $path;
}

?>