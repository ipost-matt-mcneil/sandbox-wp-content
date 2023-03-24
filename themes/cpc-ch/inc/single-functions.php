<?php 

/**
 * Single Functions
 */

add_filter( 'the_content', 'build_single' );

function build_single ( $html ) {
  $html = preg_replace( '/(\>)\s*(\<)/m', '$1$2', $html ); // Removes white space between tags
  $html = preg_replace( '/<p[^>]*>[\s|&nbsp;]*<\/p>/', '', $html ); // Removes empty paragraph tags
  return $html;
} 

add_filter( 'init', 'reset_reading_time' );

function reset_reading_time () {
 if ( is_plugin_active( 'reading-time-wp/rt-reading-time.php' ) ) {
    global $reading_time_wp;
    remove_filter( 'the_content', array( $reading_time_wp, 'rt_add_reading_time_before_content' ) );
  }
}

function build_reading_time () {
  if ( is_plugin_active( 'reading-time-wp/rt-reading-time.php' ) ) {
    
    $reading_time_postfix           = __('minute read', 'cpc-ch');
    $reading_time_postfix_singular  = __('minute read ', 'cpc-ch');

    $html   =  '<div class="reading-time">';
    $html   .= '<span class="reading-time__icon icon icon--time"></span>';
    $html   .= '<span class="reading-time__text">';
    $html   .= do_shortcode( '[rt_reading_time label="" postfix="' . $reading_time_postfix . '" postfix_singular="' . $reading_time_postfix_singular . '"]' );
    $html   .= '</span>';
    $html   .= '</div>';

    return $html;
  }
}

function build_published_date () {
  if ( is_plugin_active( 'cmb2/init.php' )  ) {
    if ( cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_display_published_date' ) ) {
      $no_author = ( build_author( get_the_author_meta( 'user_nicename' ) ) ) ? '' : ' published--no-author';
      return (  get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? '<div class="published'. $no_author .'">'. get_the_date( 'j F Y' ) .'</div>' : '<div class="published'. $no_author .'">'. get_the_date( 'F j, Y' )  . '</div>';
    }
  }
}

/**
 * Build Tables Component
 * Creates custom table component
 */

add_filter( 'the_content', 'build_tables' );

function build_tables ( $html ) {
  $html   = preg_replace( '~<table style="(.*?)">~', '<table>' , $html );
  $html   = preg_replace( '~<tr style="(.*?)">~', '<tr>' , $html );
  $html   = preg_replace( '~<td style="(.*?)">~', '<td>' , $html );
  $html   = ( is_amp() ) ? str_replace( '<table', '<div class="table myTableTestAmp"><amp-carousel width="100" height="1" layout="responsive" type="carousel" controls><div tabindex="0" class="amp-carousel-button amp-carousel-button-prev" role="button" aria-disabled="true"><span class="table__icon table__icon--is-prev icon icon--arrow-black"></span>' . __( 'Prev', 'cpc-ch' ) . '</div><div tabindex="0" class="amp-carousel-button amp-carousel-button-next" role="button" aria-disabled="false">' . __( 'Next', 'cpc-ch' ) . '<span class="table__icon table__icon--is-next icon icon--arrow-black"></span></div><table class="table__table myTableTest2Amp" border="0"', $html ) : $html;
  
  $html   = ( ! is_amp() ) ? str_replace( '<table', '<div class="table myTableTest"><a href="#" class="table__prev table__prev--is-active"><span class="table__icon table__icon--is-prev icon icon--arrow-black"></span>' . __( 'Prev', 'cpc-ch' ) . '</a><a href="#" class="table__next table__next--is-active">' . __( 'Next', 'cpc-ch' ) . '<span class="table__icon table__icon--is-next icon icon--arrow-black"></span></a><table class="table__table myTableTest2" border="0"', $html ) : $html;
  
  $html   = ( is_amp() ) ? str_replace( '</table>', '</table></amp-carousel></div>', $html ) : $html;
  $html   = ( ! is_amp() ) ? str_replace( '</table>', '</table></div>', $html ) : $html;
  $html   = str_replace( '<tr>', '<tr class="table__row">', $html );
  $html   = str_replace( '<td>', '<td class="table__cell">', $html );
  $html   = str_replace( '<tbody><tr class="table__row">', '<tbody><tr class="table__row table__row--is-first">', $html );
  $html   = str_replace( '<tbody><tr class="table__row">', '<tbody><tr class="table__row table__row--is-first">', $html );
  $html   = str_replace( '<tr class="table__row"><td class="table__cell">', '<tr class="table__row"><td class="table__cell table__cell--is-first">', $html );
  $html   = str_replace( '<tr class="table__row table__row--is-first"><td class="table__cell">', '<tr class="table__row table__row--is-first"><td class="table__cell table__cell--is-first">', $html );
  $html   = preg_replace( '~<td class="table__cell table__cell--is-first">(.*?)</td><td class="table__cell">~', '<td class="table__cell table__cell--is-first">$1</td><td class="table__cell table__cell--is-active">' , $html );
  return $html;
}

add_filter('the_content', 'build_cta', 10, 1);

function build_cta ( $content ) {
  if ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-wysiwyg', true ) ) {
    $html = '<div class="article-cta--container ' . ( ( ! $featureImage = get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-image', true ) ) ? 'no-feature--image'  : '' ) . '">';
    $html .= '<div class="article-cta--image large-4 medium-12" style="background-image: url(' . ( ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-image', true ) ? get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-image', true ) : '' )) . ')">';
    $html .= '</div>';
    $html .= '<div class="article-cta--content ' . ( ( $featureImage = get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-image', true ) ) ? 'large-8 medium-12 small-12' : '') .'">';
    $html .= '<h3>' . ( ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-title', true ) ? get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-title', true ) : '' )) . '</h3>';
    $html .= '<p>' . ( ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-wysiwyg', true ) ? get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-wysiwyg', true ) : '' ))  . '</p>';

    $ariaLabel = ((get_post_meta(get_the_ID(), 'cpc_ch_cta_article-cta-button-aria-label', true) ? get_post_meta(get_the_ID(), 'cpc_ch_cta_article-cta-button-aria-label', true) : ''));

    $html .= '<a aria-label="'.$ariaLabel.'" id="' . ( ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-analytics', true ) ? get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-analytics', true ) : '' )) . '" ' . ( ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-button-target', true ) ? 'target="_blank"' : '' )) . ' class="button" href="' . ( ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-button-url', true ) ? get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-button-url', true ) : '' )) . '">' . ( ( get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-button-title', true ) ? get_post_meta( get_the_ID(), 'cpc_ch_cta_article-cta-button-title', true ) : '' ))  .'</a>';
    $html .= '</div>';
    $html .= '</div>';
    return $content . $html;
  }
  return $content;
}

add_filter( 'the_content', 'build_sources', 10, 2 );

function build_sources ( $html ) {
  if ( is_plugin_active( 'cmb2/init.php' )  ) {
    $post_meta = get_post_meta( get_the_ID() );
    if ( isset( $post_meta[ 'cpc_ch_article_sources_group' ][ 0 ] ) ) {
      $sources_items  = maybe_unserialize( $post_meta[ 'cpc_ch_article_sources_group' ][ 0 ] );
      $count          = 1;
      $new_html   = '<div class="sources">';
      $new_html  .= '<div class="sources__label">'. __( 'Sources', 'cpc-ch' ) .'</div>';
      foreach ( $sources_items as $sources_item ) {
        $new_html  .= sprintf( '<div class="sources__item"><sup>' . $count .'</sup> %s</div>', $sources_item[ 'cpc_ch_article_sources_text' ] );
        $count++;
      }
      $new_html  .= '</div>';
      if ( $new_html ) return $html . $new_html;
    }
  }
  return $html;
}

add_filter( 'the_content', 'build_tags' , 10, 3 );

function build_tags ( $html ) {
  if ( ! is_amp() && is_single() ) {
    $tags         = get_the_tags();
    $tags_array   = array();
    if ( $tags ) {
      $new_html   = '<div class="tags">';
      foreach( $tags as $tag ) {
        array_push( $tags_array, '<a href="'.get_tag_link( $tag->term_id ).'" class="tags__link">' . $tag->name . '</a>');
      }
      $new_html   .= '<span class="tags__label">' . __('Tagged','cpc-ch') . '</span>' . implode( '', $tags_array );
      $new_html   .= '</div>';
      if ( $new_html ) return $html . $new_html;
    }
  }
  return $html;
}

add_filter( 'the_content', 'build_share', 10, 4 );

function build_share ( $content ) {
  if ( is_plugin_active( 'cmb2/init.php' ) && is_single() ) {
    $facebook_quote = get_post_meta( get_the_ID(), 'cpc_ch_social_sharing_text', true ) ?: esc_html(get_the_title());
    $twitter_text   = get_post_meta( get_the_ID(), 'cpc_ch_social_sharing_twitter_text', true ) ?: get_the_title();
    $twitter_link   = get_post_meta( get_the_ID(), 'cpc_ch_social_sharing_twitter_link', true ) ?: get_permalink();
    $twitter_link   = ( filter_var( $twitter_link, FILTER_VALIDATE_URL ) ) ? $twitter_link : get_permalink();
    $twitter_link   = urlencode( utf8_encode( $twitter_link ) );
    $email_subject  = __('From Canada Post: ', 'cpc-ch') . esc_html( get_the_title() );
    $email_body     = get_permalink();
    if (doing_filter('get_the_excerpt')) return false;

    if ( is_amp() ) {
      $html     = '<amp-social-share tabindex="0" class="icon icon--social icon--facebook js-social" width="10" height="20" type="facebook" role="button" data-param-quote="' . $facebook_quote . '" data-param-app_id="2196595330625536"></amp-social-share>';
      $html    .= '<amp-social-share tabindex="0" class="icon icon--social icon--twitter js-social"  width="21" height="17" type="twitter" role="button" data-param-text="' . $twitter_text . '" data-param-url="' . $twitter_link . '"></amp-social-share>';
      $html    .= '<amp-social-share tabindex="0" class="icon icon--social icon--linkedin js-social" width="21" height="20" type="linkedin" role="button" data-param-title="' . $facebook_quote . '"></amp-social-share>';
      $html    .= '<amp-social-share tabindex="0" class="icon icon--social icon--email js-social"   width="24" height="15" type="email" role="button" data-param-subject="' . $email_subject . '" data-param-body="' . $email_body . '"></amp-social-share>';
    } else {
      $html     = '<span tabindex="0" class="icon icon--social icon--facebook js-social" data-url="'. get_permalink() . '" data-quote="' . $facebook_quote . '" role="button" aria-label="' . __('Share post on Facebook', 'cpc-ch') . '"></span>';
      $html    .= '<span tabindex="0" class="icon icon--social icon--twitter js-social"  data-href="http://twitter.com/intent/tweet/?text=' . urlencode( $twitter_text ) . "&url=" . $twitter_link . '"  role="button" aria-label="' . __('Share post on Twitter', 'cpc-ch') . '"></span>';
      $html    .=  '<span tabindex="0" class="icon icon--social icon--linkedin js-social" data-href="http://www.linkedin.com/shareArticle?mini=true&url=' . substr( urlencode( utf8_encode( get_permalink() ) ), 0, 1024 ) . '" role="button" aria-label="' . __('Share post on LinkedIn', 'cpc-ch') . '"></span>';
      $html    .= '<a href="mailto:?subject=' . $email_subject . '&body=' . $email_body . '?ecid=2012ext709" aria-label="' . __('Email post', 'cpc-ch') . '"><span class="icon icon--social icon--email"  role="button" aria-label="' . __('Email post', 'cpc-ch') . '"></span></a>'; 
    }
    if ( $content ) return $content . '<div class="share">' . $html . '</div>';
    return $html;
  }
  return $content;
}

add_filter( 'the_content', 'build_author_bio', 10, 5 );

function build_author_bio ( $html ) {
  if ( is_plugin_active( 'cmb2/init.php' ) && is_single() ) {
    if( ( get_the_author_meta('user_nicename') != 'canadapost' || get_the_author_meta('user_nicename') != 'canada-post' ) && get_the_author_meta( 'description' ) != '' && get_the_author_meta( 'cpc_user_description_fr', get_the_author_meta('ID') ) != '' ) { 
      $new_html   = '<div class="bio bio--is-article">';
      $new_html  .= '<div class="bio__img-wrapper ' . (( get_the_author_meta( 'cpc_user_profile_pic', get_the_author_meta('ID') ) && get_the_author_meta( 'cpc_user_profile_pic_display', get_the_author_meta('ID') ) ) ? '' : 'bio__img-wrapper--no-profile-picture' ) .'">';
      $new_html  .= ( ! is_amp() ) ? '<img src="' . get_the_author_meta( 'cpc_user_profile_pic', get_the_author_meta('ID') ) .'" alt="' . get_the_author() .'" class="bio__img" />' : '';
      $new_html  .= ( is_amp() ) ? '<amp-img src="' . get_the_author_meta( 'cpc_user_profile_pic', get_the_author_meta('ID') ) .'" alt="' . get_the_author() .'" class="bio__img" height="100px" width="100px"></amp-img>' : '';
      $new_html  .= '</div>';
      $new_html  .= '<div class="bio__text-wrapper">';
      $new_html  .= '<div class="bio__text">';
      $new_html  .= (  get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? '<span>'. get_the_author_meta( 'cpc_user_description_fr', get_the_author_meta('ID') ) .'<span>' : '<span>'. get_the_author_meta( 'description' ) . '<span>';
      $new_html  .= '<a href="' . get_author_posts_url( get_the_author_meta('ID'), get_the_author_meta('user_nicename') ) . '" class="bio__link">'. __('Read more by ','cpc-ch') .' '. get_the_author_meta('display_name') . ' <span class="bio__icon icon icon--arrow"></span></a>';
      $new_html  .= '</div>';
      $new_html  .= '</div>';
      $new_html  .= '</div>';
      if ( $new_html ) return $html . $new_html;
    }
  }
  return $html;
}

// Non-admin User Registration - when a user is registered on Business blog, automatically register then on Business FR (Entreprise)
add_action( 'gform_user_registered', 'add_user_to_alt_lang_site', 10, 4 );

function add_user_to_alt_lang_site( $user_id, $feed, $entry, $user_pass ) {
  $blog_id = get_current_blog_id();
  $fr_blog_id = ( $blog_id == 2 ) ? 5 : 0;
  if ( $fr_blog_id != 5 ) {
    return false;  
  }
  $result  = add_user_to_blog( $fr_blog_id, $user_id, "contributor");
}

?>