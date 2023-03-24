<?php 

/**
 * Footer Functions
 */

function build_footer_navigation() {
  $html    = '<div class="footer__navigation">';
  $html   .= '<nav role="navigation" aria-label="' . __( 'Footer navigation', 'cpc-ch' ) .'">';
  if ( has_nav_menu( 'footer_navigation' ) ) {
    $locations    = get_nav_menu_locations();
    $navigation   = wp_get_nav_menu_items( $locations['footer_navigation'] );
    if ( $navigation ) {
    foreach ( $navigation as $navigation_item ) {
        $html .= '<a href="' . $navigation_item->url . '"  class="footer__link footer__link--list">' . $navigation_item->title . '</a>';
      }
    }
  }
  $html  .= '</nav>';
  $html  .= '</div>';
  return $html;
}


// Enqueue the Instagram embed.js script once at the bottom of the page
add_filter( 'wp_footer', 'footer_enqueue_insta_embed_script', 999 );
function footer_enqueue_insta_embed_script() {
  if( !is_amp() ) :
    ?>
      <script async defer src="//www.instagram.com/embed.js"></script>
    <?php
  endif;
}


?>