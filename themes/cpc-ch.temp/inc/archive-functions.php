<?php

/**
 * Archive Functions
 */

function build_category_query ( $has_cross_sell = null ) {
    $meta_key 			= 'cpc_ch_feature_article_category-feature'; // Category feature variable
    $category_id 		= ( isset( get_queried_object()->term_id ) ) ? get_queried_object()->term_id : null; // Current category ID
    $posts_per_page 	= ( $has_cross_sell )  ? 10 : 11; // 11 posts per page (10 if there is a 'Inline Cross-Sell' set for this page)

    return $args    = array( 
        'post_status' => 'publish', // Return only published posts
        'no_found_rows' => true,
        'category__and' => array( $category_id ), // Return only posts under current category
        'update_post_term_cache' => false,
        'meta_query' => array( // Return posts with 'Category Feature' check and without
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
        'posts_per_page' => $posts_per_page, // Return 11/10 posts per page
    );
}

function build_subcategory_query ( $has_cross_sell = null ) {
    $meta_key 			= 'cpc_ch_feature_article_subcategory-features';
    $category_id 		= ( isset( get_queried_object()->term_id ) ) ? get_queried_object()->term_id : null; // Current category ID
    $posts_per_page 	= ( $has_cross_sell )  ? 10 : 11; // 11 posts per page (10 if there is a 'Inline Cross-Sell' set for this page)
    $category_type 		= get_term_meta(get_queried_object()->term_id, 'cpc_ch_category_type', true ) ; // Category Type 
    $posts_per_page 	= ( $category_type === 'events' )  ? 9 : $posts_per_page; // 9 posts per page if under 'Events'

    return $args    	= array( 
        'post_status' => 'publish', // Return only published posts
        'no_found_rows' => true,
        'category__and' => array( $category_id ), // Return only posts under current category
        'update_post_term_cache' => false,
        'meta_query' => array( // Return posts with 'Category Feature' check and without
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
        'posts_per_page' => $posts_per_page, // Return 4 posts per page
    );
}

function build_resources_query () {
    $meta_key 			= 'cpc_ch_feature_article_subcategory-features';
    $category_id 		= ( isset( get_queried_object()->term_id ) ) ? get_queried_object()->term_id : null; // Current category ID

    return $args    = array( 
        'post_status' => 'publish', // Return only published posts
        'no_found_rows' => true,
        'category__and' => array( $category_id ), 
        'update_post_term_cache' => false,
        'meta_query' => array( // Return posts with 'Category Feature' check and without
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
        'posts_per_page' => 100 // Return all posts
    );
}

function build_resources_list_query () {
    $category_id 		= ( isset( get_queried_object()->term_id ) ) ? get_queried_object()->term_id : null; 

    return $args = array( 
        'post_status' => 'publish', // Return only published posts
        'update_post_meta_cache' => false,
        'category__and' =>  array( $category_id ), // Return only posts under current category 
        'orderby' => array( 'date' => 'DESC' ), // Order by descending date order
        'posts_per_page' => 11, // Return 11 posts per page
        'meta_query' => array(
            array(
                'key' => 'cpc_ch_feature_article_not-listed',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );
}

function build_tag_list_query () {
    $uncategorized_en  	= get_cat_ID( 'Uncategorized' );
    $uncategorized_fr  	= get_cat_ID( 'Non classifié(e)' );
    $tag_slug 			= ( isset( get_queried_object()->slug ) ) ? get_queried_object()->slug : null;

    return $args	= array( 
        'post_status' => 'publish', // Return only published posts
        'update_post_meta_cache' => false,
        'tag' => array( $tag_slug ), // Return only posts under current tag
        'orderby' => array( 'date' => 'DESC' ), // Order by descending date order
        'posts_per_page' => 11, // Return 11 posts per page
        'category__not_in' => array( $uncategorized_en, $uncategorized_fr ),
        'meta_query' => array(
            array(
                'key' => 'cpc_ch_feature_article_not-listed',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );
}

function build_author_list_query () {
    $uncategorized_en  	= get_cat_ID( 'Uncategorized' );
    $uncategorized_fr  	= get_cat_ID( 'Non classifié(e)' );
    $author 			= get_user_by( 'slug', get_query_var( 'author_name' ) );
    $author_id 			= ( isset( $author->ID ) ) ? $author->ID : null;

    return $args	= array( 
        'post_status' => 'publish', // Return only published posts
        'update_post_meta_cache' => false,
        'author__in' => $author_id, // Return only posts under current user
        'orderby' => array( 'date' => 'DESC' ), // Order by descending date order
        'posts_per_page' => 11, // Return 11 posts per page
        'category__not_in' => array( $uncategorized_en, $uncategorized_fr ),
        'meta_query' => array(
            array(
                'key' => 'cpc_ch_feature_article_not-listed',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );
}

add_action( 'pre_get_posts', 'build_archive_pagination' );

function build_archive_pagination ( $query ) {
if ( $query->is_archive() && $query->is_main_query() && !is_admin() ) {
    $args = false;
    if ( is_category() && isset( get_queried_object()->term_id ) ) { // Is category page
        if ( get_term_meta(get_queried_object()->term_id, 'cpc_ch_category_type', true )  == 'resources' ) return; // Returns nothing if 'Resources' page
        if ( get_term_meta(get_queried_object()->parent, 'cpc_ch_category_type', true ) != 'resources' ) {
            $has_cross_sell = get_term_meta( get_queried_object()->term_id, 'cpc_ch_category_cross_sell_inline_title', true );
            $args 			= ( get_queried_object()->category_parent > 0  ) ? build_subcategory_query( $has_cross_sell ) : build_category_query( $has_cross_sell );
        } else {
            $args = build_resources_list_query();
        }
    }
    $args 		= ( is_tag() ) ? build_tag_list_query() : $args; // Is tag page
    $args 		= ( is_author() ) ? build_author_list_query()  : $args; // Is author page
    $results 	=  new WP_Query( $args ); 
    $ids 		= ( $results->posts ) ? wp_list_pluck( $results->posts, 'ID' ) : '';
    $query->set( 'post__not_in', $ids );
    $query->set( 'posts_per_page', 6 );
    $query->set( 'orderby', 'date DESC' );
    $query->set( 'meta_query', array(
        array(
              'key' => 'cpc_ch_feature_article_not-listed',
              'compare' => 'NOT EXISTS',
        ),
    ));
    
    }	
}
