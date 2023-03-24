<?php 

/**
 * Campaign Functions
 */

function build_campaign_query () {
  $tags               = get_the_tags(); 
  $uncategorized_en   = get_cat_ID( 'Uncategorized' );
  $uncategorized_fr   = get_cat_ID( 'Non classifié(e)' );
  $tag_id             = ( $tags[0] ) ? $tags[0]->term_id : false; 
  $meta_key           = 'cpc_ch_feature_article_campaign-feature'; // 'Campaign Feature' variable
  return $args    = array( 
    'post_status' => 'publish', // Return only published posts
    'tag_id' => $tag_id, // Return only posts under current tag
    'meta_query' => array( // Return posts with 'Campaign Feature' check and without
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
    'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ), // Order by 'Camapign Feature' first followed by the rest in descending date order
    'posts_per_page' => 99, // Return 99 posts per page
    'category__not_in' => array( $uncategorized_en, $uncategorized_fr ) // Do not return uncategorized posts
  );
}

?>