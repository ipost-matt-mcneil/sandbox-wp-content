<?php 

/**
 * Homepage Functions
 */

function build_homepage_feature_query () {
  $uncategorized  = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? get_cat_ID( 'Non classifié(e)' ) : get_cat_ID( 'Uncategorized' );
  $meta_key       = 'cpc_ch_feature_article_homepage-feature'; // 'Homepage Feature' variable
  return $args    = array( 
    'post_status' => 'publish', // Return only published posts
    'no_found_rows' => true,
    'update_post_term_cache' => false,
    'has_password'   => false,
    'meta_query' => array( // Return posts with 'Homepage Feature' check and without
      'relation' => 'AND',
      array(
        'relation' => 'OR',
        array(
            'key' => $meta_key,
            'compare' => 'NOT EXISTS'
        ),
        array(
          'relation' => 'OR',
          array(
            'key' => $meta_key,
            'value' => 0,
            'compare' => '>',
          ),
          array(
            'key' => $meta_key,
            'value' => '',
            'compare' => '=',
          ),
        ),
      ),
      array(
        'key' => 'cpc_ch_feature_article_not-listed',
        'compare' => 'NOT EXISTS',
      ),
    ),
    'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ), // Order by 'Homepage Feature' first followed by the rest in descending date order
    'posts_per_page' => 1,
    'category__not_in' => array( $uncategorized ) // Do not return uncategorized posts
  );
}

function build_homepage_featured_list_query () {
  
  $uncategorized  = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? get_cat_ID( 'Non classifié(e)' ) : get_cat_ID( 'Uncategorized' );
  $meta_key       = 'cpc_ch_feature_article_homepage-featured-list'; // 'Homepage Featured List' variable
  return $args    = array( 
    'post_status' => 'publish', // Return only published posts
    'no_found_rows' => true,
    'update_post_term_cache' => false,
    'has_password'   => false,
    'meta_query' => array( // Return posts with 'Homepage Featured List' check and without
      'relation' => 'AND',
      array(
        'relation' => 'OR',
        array(
            'key' => $meta_key,
            'compare' => 'NOT EXISTS'
        ),
        array(
          'relation' => 'OR',
          array(
            'key' => $meta_key,
            'value' => 0,
            'compare' => '>',
          ),
          array(
            'key' => $meta_key,
            'value' => '',
            'compare' => '=',
          ),
        ),
      ),
      array(
        'key' => 'cpc_ch_feature_article_not-listed',
        'compare' => 'NOT EXISTS',
      ),
    ),
    'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ), // Order by 'Homepage Featured List' first followed by the rest in descending date order
    'posts_per_page' => 4, // Return 4 posts per page
    'category__not_in' => array( $uncategorized ) // Do not return uncategorized posts
  );
}

function build_homepage_categories_query () {
  $uncategorized  = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? get_cat_ID( 'Non classifié(e)' ) : get_cat_ID( 'Uncategorized' );
  return $args    = array( 
    'post_status' => 'publish', // Return only published posts
    'update_post_meta_cache' => false,
    'no_found_rows' => true,
    'parent' => 0, // Return only top level categories
    'hide_empty'=> 0,
    'exclude' => array( $uncategorized ) // Ignores 'Uncategorized'
  );
}

function build_homepage_categories_list_query ( $category_id ) {
  $meta_key       = 'cpc_ch_feature_article_category-feature'; // Category feature variable
  return $args    = array( 
    'post_status' => 'publish', // Return only published posts
    'no_found_rows' => true,
    'category__and' => array( $category_id ), // Return only posts under current category
    'update_post_term_cache' => false,
    'has_password'   => false,
    'meta_query' => array( // Return posts with 'Category' check and without
      'relation' => 'AND',
      array(
        'relation' => 'OR',
        array(
            'key' => $meta_key,
            'compare' => 'NOT EXISTS'
        ),
        array(
          'relation' => 'OR',
          array(
            'key' => $meta_key,
            'value' => 0,
            'compare' => '>',
          ),
          array(
            'key' => $meta_key,
            'value' => '',
            'compare' => '=',
          ),
        ),
      ),
      array(
        'key' => 'cpc_ch_feature_article_not-listed',
        'compare' => 'NOT EXISTS',
      ),
    ),
    'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ), // Order by 'Category Featured List' first followed by the rest in descending date order
    'posts_per_page' => 5
  );
}

function build_homepage_navigation() {
  if ( has_nav_menu( 'homepage_navigation' )  && is_plugin_active( 'cmb2/init.php' ) && is_plugin_active( 'cpc-contenthub/cpc-contenthub.php' )  ) {
    $language   = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? 'fr' : 'en';
    $heading    = ( $language === 'en' ) ? cmb2_get_option( 'cpc_ch_theme_options', 'cpc_tag_nav_en' ) : $tag_heading = cmb2_get_option( 'cpc_ch_theme_options', 'cpc_tag_nav_fr' );
    $navigation = wp_nav_menu( array(
      'theme_location'  => 'homepage_navigation',
      'menu_class'      => 'ribbon__menu',
      'container'       => 'ul',
      'echo'            => false
    )); 
    $html    = '<div class="ribbon">';
    $html   .= '<div class="ribbon__container">';
    $html   .= '<div class="row">';
    $html   .= '<div class="columns large-4 medium-12 small-12">';
    $html   .= '<h3 class="ribbon__heading">' . $heading .'</h3>';
    $html   .= '</div>';
    $html   .= '<div class="columns large-8 medium-12 small-12">';
    $html   .= '<nav role="navigation" aria-label="' . __( 'Supporting navigation', 'cpc-ch' ) .'">';
    $html   .= $navigation;
    $html   .= '</nav>';
    $html   .= '</div>';
    $html   .= '</div>';
    $html   .= '</div>';
    $html   .= '</div>';
    return $html;
  }
}

?>