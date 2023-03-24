<?php 

/**
 * Header Functions
 */

function register_menu() {
  register_nav_menus(
    array(
      'menu-1' => esc_html__( 'Primary', 'cpc-ch' ),
    )
  );
}

function build_skip_to_main_content() {
  if ( ! is_amp() ) {
    $html  = '<a href="#main" class="header__skip-to-main-content" aria-label="' . __( 'Skip to Main Content', 'cpc-ch' ) .'">' . __( 'Skip to Main Content', 'cpc-ch' ) .'</a>';
    return $html;
  }
}

function build_hamburger() {
  $html   = '<div class="header__hamburger">';
  if ( has_nav_menu( 'navigation' ) ) {
    $html  .= '<span class="hamburger icon icon--hamburger" ';
    $html  .= ( is_amp() ) ? 'on="tap:sidebar.open" ' : '';
    $html  .= 'role="button" tabindex="0"></span>';
  }
  $html  .= '</div>';
  return $html;
}

function build_logo() {
  $language       = ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? 'fr' : 'en';
  $logo_desktop   = get_template_directory_uri() . '/img/logo-desktop-' . $language . '.svg';
  $logo_mobile    = get_template_directory_uri() . '/img/logo-mobile.svg';  
  $logo_url       = 'https://www.canadapost-postescanada.ca' . ( ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) ? '/scp/fr/accueil.page' : '/cpc/en/home.page' );
  $site           = __( 'Canada Post', 'cpc-ch' );
  if ( is_plugin_active( 'cmb2/init.php') && is_plugin_active( 'cpc-contenthub/cpc-contenthub.php')  ) {
    $site         = cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_site_name' ) ? cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_site_name' ) : $site;
    $logo_desktop = cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_logo_desktop_' . $language ) ? cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_logo_desktop_' . $language ) : $logo_desktop;
    $logo_mobile  = cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_logo_mobile_' . $language ) ? cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_logo_mobile_' . $language ) : $logo_mobile;
    $logo_url     = ( cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_site_name' ) ) ? get_site_url() . "/" : $logo_url ;
  }
  $html  = '<div class="header__logo">';
  $html .= '<a href="' . $logo_url . '" title="' . __( $site, 'cpc-ch' ) .'" aria-label="' . __( $site, 'cpc-ch' ) .'">';   
  if ( is_amp() ) {
    $html .= '<amp-img class="logo logo--mobile" src="' . $logo_mobile . '" alt="' . __( $site, 'cpc-ch' ) . '" height="32"></amp-img>';
  } else {
    $html .= '<img class="logo logo--desktop" src="' . $logo_desktop . '" alt="' . __( $site, 'cpc-ch' ) . '">';
    $html .= '<img class="logo logo--mobile" src="' . $logo_mobile . '" alt="' . __( $site, 'cpc-ch' ) . '">';
  }
  $html .= '</a>'; 
  $html .= '</div>'; 
  return $html;
}

function build_main_navigation() {
  $html   = ( ! is_amp() ) ? '<div class="header__navigation">' : '';
  if ( has_nav_menu( 'navigation' ) ) {
    $navigation   = wp_nav_menu( array(
      'theme_location'  => 'navigation',
      'menu_class'      => 'navigation__menu',
      'container'       => 'ul',
      'link_after'      => '<span class="navigation__chevron icon icon--chevron"></span>',
      'echo'            => false
    )); 
    if( ! is_amp() ) {
      $navigation   = preg_replace( '/(\>)\s*(\<)/m', '$1$2', $navigation );
      $navigation   = preg_replace( '~\ menu-item-(.*?)\"~', '"' , $navigation );
      $navigation   = str_replace( 'sub-menu', 'navigation__submenu', $navigation );
      $navigation   = str_replace( 'navigation__item--is-parent"><a ', 'navigation__item--is-parent"><a aria-expanded="false" href="#" ', $navigation );
      $navigation   = str_replace( 'navigation__item--is-current-parent"><a ', 'navigation__item--is-current-parent"><a aria-expanded="false" href="#" ', $navigation );
    } else {
      $navigation   = preg_replace( '/(\>)\s*(\<)/m', '$1$2', $navigation );
      $navigation   = preg_replace( '~\ menu-item-(.*?)\"~', '"' , $navigation );
      $navigation   = str_replace( 'navigation__item--is-parent">', 'navigation__item--is-parent"><amp-accordion><section>', $navigation );
      $navigation   = str_replace( '</ul></li>' , '</ul></section></amp-accordion></li>' , $navigation );
      $navigation   = preg_replace('/<amp-accordion><section><a (.*?)<\/a>/', '<amp-accordion><section><header $1</header>', stripslashes( $navigation ) );
      $navigation   = preg_replace('/<header href="(.*?)"/', '<header ', stripslashes( $navigation ) );
    }
    $html   .= ( is_amp() ) ? '<amp-sidebar id="sidebar" layout="nodisplay" side="left" class="navigation">' : '';
    $html   .= ( ! is_amp() ) ? '<div class="navigation">' : '';
    $html   .= '<div class="navigation__hamburger">';
    $html   .= ( ! is_amp() ) ? '<span class="hamburger hamburger--is-active icon icon--close" tabindex="0"></span>' : '';
    $html   .= ( is_amp() ) ? '<span class="icon icon--close" on="tap:sidebar.close" tabindex="0" role="button"></span>' : '';
    $html   .= '</div>';
    $html   .= '<div class="navigation__container">';
    $html   .= '<nav role="navigation" aria-label="' . __( 'Main navigation', 'cpc-ch' ) . '">';
    $html   .= $navigation;
    $html   .= '</nav>';
    $html   .= '</div>';
    $html   .= ( ! is_amp() ) ? '<div class="navigation__overlay"></div>' : '';
    $html   .= ( ! is_amp() ) ? '</div>' : '';
    $html   .= ( is_amp() ) ? '</amp-sidebar>' : '';
  }
  $html   .= ( ! is_amp() ) ? '</div>' : '';
  return $html;
}

function build_search() {
  if ( is_plugin_active( 'cmb2/init.php') && ! is_amp() && has_nav_menu( 'navigation' ) ) {
    $html    = '<div class="header__search">';
    $html   .= '<a href="#" class="search__button search__button--is-desktop" id="searchBtn" aria-label="' . __( 'Search', 'cpc-ch' ) . '">' . __( 'Search', 'cpc-ch' ) . '<span class="icon icon--search search__icon"></span></a>';
    $html   .= '<a href="#" class="search__button search__button--is-mobile" id="searchMobileBtn" aria-label="' . __( 'Search', 'cpc-ch' ) . '"><span class="icon icon--search"></span></a>';
    $html   .= '<input type="hidden" id="search_auto_suggest_trigger" value="' .cmb2_get_option( 'cpc_ch_theme_options', 'cpc_search_auto_suggest_trigger' ) . '" />';
    $html   .= '<input type="hidden" id="type_ahead_url" value="' . cmb2_get_option( 'cpc_ch_theme_options', 'cpc_type_ahead_url' ) .'" />';
    $html   .= '</div>';
    return $html;
  }
}

function build_language() {
  if ( ! is_amp() ) {
    $translation_nav   = wp_nav_menu( array(
      'theme_location'  => 'translation_menu',
      'container_class' => 'header__language'
    )); 

    return $translation_nav;
  }
}

?>