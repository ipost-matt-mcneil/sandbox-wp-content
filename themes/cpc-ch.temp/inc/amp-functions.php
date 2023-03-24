<?php 

/**
 * AMP Functions
 */

function is_amp() {
	return ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() && is_single() ) ? true : false;
}

/**
 * Set AMP Templates
 */

function set_amp_templates ( $file, $type, $post ) {
	$file = ( 'single' === $type ) ? realpath(dirname(__FILE__) . '/../single.php') : '';
	return $file;
}

add_filter( 'amp_post_template_file', 'set_amp_templates', 10, 3 );

/**
 * Build AMP Scripts
 */

function build_amp_scripts () {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'cmb2/init.php' ) && is_plugin_active( 'cpc-contenthub/cpc-contenthub.php' )  ) {
		$additional_css_amp = ( cmb2_get_option( 'cpc_ch_theme_options', 'cpc_additional_css_amp' ) ) ? cmb2_get_option( 'cpc_ch_theme_options', 'cpc_additional_css_amp' ) : '';
		$additional_css_amp = trim(preg_replace('/\s+/', ' ', $additional_css_amp ));
		if ( is_amp() ) {
			echo '<script async src="https://cdn.ampproject.org/v0.js"></script>'. PHP_EOL;
			echo '<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>' . PHP_EOL;
			echo '<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>' . PHP_EOL;
			echo '<script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>' . PHP_EOL;
			echo '<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>' . PHP_EOL;
	    echo '<script async custom-element="amp-user-notification" src="https://cdn.ampproject.org/v0/amp-user-notification-0.1.js"></script>' . PHP_EOL;
	    echo '<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>' . PHP_EOL;
	    echo '<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>' . PHP_EOL;
			echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300">'. PHP_EOL;
			echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">' . PHP_EOL;
			echo '<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>' . PHP_EOL;
			echo '<style amp-custom>' . file_get_contents( realpath(dirname(__FILE__) .  '/../dist/style.amp.css') ). $additional_css_amp . '</style>' . PHP_EOL;
		}
	}
}

add_action( 'wp_head', 'build_amp_scripts' );

/**
 * Build AMP Content
 */

function build_amp_content ( $html ) {
	if ( is_amp() ) {
		$html = build_amp_img ( $html );
	}
	return $html;
}

add_filter( 'the_content' , 'build_amp_content' );

/**
 * Build AMP Image
 */

function build_amp_img ( $html ) {
	$html = preg_replace('/<img .*? src="([^"]*)" alt="([^"]*)" width="([^"]*)" height="([^"]*)" .*?>/', '<amp-img src="$1" width="$3" height="$4" layout="responsive" alt="$2" class="article-img"></amp-img>', $html);
	// pick up any image that are not full-sized
	$html = preg_replace('/<img src="([^"]*)" alt="([^"]*)" width="([^"]*)" height="([^"]*)" .*?>/', '<amp-img src="$1" width="$3" height="$4" alt="$2"></amp-img>', $html);
	return $html;
}

function disable_plugins_on_amp () {
	if ( is_amp() ) {
		// stop dtm css and javascript to insert to header and footer
		remove_action('wp_head', 'SDIDTM_wp_header', 1);
		remove_action('wp_footer', 'SDIDTM_wp_footer', 100000);
		// stop schema css and javascript to insert to header
		remove_action('wp_enqueue_scripts', 'schema_wp_frontend_scripts_and_styles');
	}
}

add_action( 'wp_head', 'disable_plugins_on_amp', 0);

?>