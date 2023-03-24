<?php 

/**
 * Theme Settings
 */

/**
 * Allow title tag support
 */

add_theme_support( 'title-tag' );

/**
 * Allow post thumbnail support
 */

add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );

/**
 * Set default uploaded image dimensions
 */

set_post_thumbnail_size( 1440, 500, true );
add_image_size( 'thumbnail', 608, 342, true );
add_image_size( 'medium', 768, 431, true );
add_image_size( 'large', 1440, 500, true );
add_image_size( 'campaign', 1440, 212, true );

/**
 * Allow SVGs to be uploaded as images
 */

add_filter('upload_mimes', 'cc_mime_types');

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

/**
 * Hide default admin bar
 */

add_filter('show_admin_bar', '__return_false');

/**
 * Hide default emoji scripts
 */
	
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Hide RSS comment scripts
 */

add_filter( 'feed_links_show_comments_feed', '__return_false' );

/**
 * Hide WordPress generator tag
 */

remove_action('wp_head', 'wp_generator');

/**
 * Hide WPML generator tag
 */

global $sitepress;
remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag' ) );

/**
 * CCODO-108 - Remove Next/Prev meta tags added by Yoast as they are obsolete to Google
 * and causing AA accessbility issue
 */

add_filter( 'wpseo_next_rel_link', '__return_false' );
add_filter( 'wpseo_prev_rel_link', '__return_false' );

/**
 * Remove Gutenberg scripts
 */

function wps_deregister_styles() {
  wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );


/* Change of lang attribute in html tag for A11Y fix CCODWO-3953 */
add_filter('language_attributes', 'blogs_language_attributes');
function blogs_language_attributes($output)
{
  if (preg_match('#lang="[a-z-]+"#i', $output)) {
    if (strrpos($output, 'en-CA')) {
      $output = preg_replace('#lang="([a-z-]+)"#i', 'lang="en_CA"', $output);
    } else if (strrpos($output, 'fr-CA')) {
      $output = preg_replace('#lang="([a-z-]+)"#i', 'lang="fr_CA"', $output);
    }
  }
  return $output;
}

?>