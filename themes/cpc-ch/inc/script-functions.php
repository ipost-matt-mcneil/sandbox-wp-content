<?php

// Implemented for Yoast Plugin issue - Updates the network home URL to correct base for plugin activation
// TODO - Investigate actual cause of issue
add_filter( 'network_home_url', 'subsite_network_home', 10, 10 );

/**
 * Function for `network_home_url` filter-hook.
 * 
 * @param string      $url         The complete network home URL including scheme and path.
 * @param string      $path        Path relative to the network home URL. Blank string if no path is specified.
 * @param string|null $orig_scheme Scheme to give the URL context. Accepts 'http', 'https', 'relative' or null.
 *
 * @return string
 */
function subsite_network_home( $url, $path, $orig_scheme ){

	$values = parse_url($url);
	$values['path'] = "/blogs/";
	$url = "https://" . $values['host'] . $values['path'];

	return $url;
}

// Optinmonster - Provide access to lower user roles
add_filter( 'optin_monster_api_menu_cap', function( $cap ) { return 'edit_pages'; } );

/**
 * Script Functions
 */

add_action('wp_head', 'build_additional_css');

function build_additional_css()
{
	if (is_plugin_active('cmb2/init.php') && is_plugin_active('cpc-contenthub/cpc-contenthub.php' && !is_amp())) {
		if (cmb2_get_option('cpc_ch_theme_options', 'cpc_additional_css') && !is_amp()) {
			$additional_css = cmb2_get_option('cpc_ch_theme_options', 'cpc_additional_css');
			$additional_css = trim(preg_replace('/\s+/', ' ', $additional_css));
			echo '<style>' . $additional_css . '</style>';
		}
	}
}

/**
 * Build Fusion
 */

function build_fusion()
{
	$segment  = (get_blog_details()->path) ? str_replace('blogs', '', str_replace('/', '', get_blog_details()->path)) : '';
	if (is_single() && !is_amp() && ($segment === 'business' || $segment === 'personal')) {
		$segment_id       = ($segment === 'business') ? 2 : 6;
		$segment_name_en  = ($segment === 'business') ? 'Business Services' : 'Personal';
		$segment_name_fr  = ($segment === 'business') ? 'Services aux entreprises' : 'Personnel';
		$categories       = array();
		$subcategories    = array();
		if (get_the_category(get_the_ID())) {
			foreach (get_the_category(get_the_ID()) as $category) {
				($category->parent === 0)  ? array_push($categories, $category->slug) : array_push($subcategories, $category->slug);
			}
		}
		$category      = (isset($categories[0])) ? $categories[0] : '';
		$subcategory   = (isset($subcategories[0])) ? $subcategories[0] : '';
		$html    = '<meta name="language" content="' . ((get_bloginfo('language') === 'fr' || get_bloginfo('language') === 'fr-CA') ? 'fr' : 'en') . '" />' . PHP_EOL;
		$html   .= '<meta http-equiv="content-language" content="' . ((get_bloginfo('language') === 'fr' || get_bloginfo('language') === 'fr-CA') ? 'fr_CA' : 'en_CA') . '" />' . PHP_EOL;
		$html   .= '<meta name="cattype" content="' . $segment . '" />' . PHP_EOL;
		$html   .= '<meta name="category" content="' . $category . '" />' . PHP_EOL;
		$html   .= '<meta name="subcategory" content="' . $subcategory . '" />' . PHP_EOL;
		$html   .= '<meta name="category_landing" content="' . $category . '" />' . PHP_EOL;
		$html   .= '<meta name="date.published" content="' . get_the_date('Y-m-d') . '" />' . PHP_EOL;
		$html   .= '<meta name="phead" content="' . get_the_title() . '" />' . PHP_EOL;
		$html   .= '<meta name="segment" content="' . ((get_bloginfo('language') === 'fr' || get_bloginfo('language') === 'fr-CA') ? $segment_name_fr : $segment_name_en) . '" />' . PHP_EOL;
		$html   .= '<meta name="segmentid" content="2" />' . PHP_EOL;
		$html   .= '<meta name="sns" content="' . $segment . '" />' . PHP_EOL;
		return $html;
	}
}


function build_scripts()
{
	if (!is_amp()) {

		$suffix  = ((WP_ENV !== 'production') && (WP_ENV !== 'staging')) ? 'dev' : 'min';

		wp_enqueue_style('cpc-ch-styles', get_template_directory_uri() . '/dist/style.' . $suffix . '.css');
		wp_enqueue_script('cpc-ch-scripts', get_template_directory_uri() . '/dist/script.' . $suffix . '.js', array(), '', true);
		wp_enqueue_script('jquery-core');
	}

	// jQuery dependency from the Adobe DTM Tracking scripts
	// Please don't create/use jQuery in our code, as we shouldn't create
	// a dependency on it
	wp_enqueue_script('cpc-ch-scripts', '/cpc/assets/cpc/js/lib/jquery.js', array(), '', true);
}

add_action('wp_enqueue_scripts', 'build_scripts');

function add_facebook_sdk()
{
	if (!is_amp()) { ?>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<script>
			window.fbAsyncInit = function() {
				const FBappId = '2196595330625536';
				FB.init({
					appId: FBappId,
					xfbml: false,
					version: 'v2.11'
				});
			};
		</script>
	<?php
		}
	}
	add_action('wp_enqueue_scripts', 'add_facebook_sdk');

	add_action('wp_enqueue_scripts', 'tracking_scripts');
	function tracking_scripts()
	{
		if (!is_amp()) {

			?>
		<!-- Start LinkedIn Pixel Code -->
		<script type="text/javascript">
			_linkedin_partner_id = "9198";
			window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
			window._linkedin_data_partner_ids.push(_linkedin_partner_id);
			(function() {
				var s = document.getElementsByTagName("script")[0];
				var b = document.createElement("script");
				b.type = "text/javascript";
				b.async = true;
				b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
				s.parentNode.insertBefore(b, s);
			})();
		</script><noscript><img src="https://px.ads.linkedin.com/collect/?pid=9198&amp;fmt=gif" alt="" style="display:none;" width="1" height="1"></noscript>

		<!-- End LinkedIn Pixel Code -->
		
		<!-- Start Facebook Pixel Code -->
		<script>
			! function(f, b, e, v, n, t, s) {
				if (f.fbq) return;
				n = f.fbq = function() {
					n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
				};
				if (!f._fbq) f._fbq = n;
				n.push = n;
				n.loaded = !0;
				n.version = '2.0';
				n.queue = [];
				t = b.createElement(e);
				t.async = !0;
				t.src = v;
				s = b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t, s)
			}(window, document, 'script',
				'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '614267586032718');
			fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=614267586032718&ev=PageView&noscript=1" /></noscript>
		<!-- End Facebook Pixel Code -->


		<!-- Twitter universal website tag code -->
		<script>
			let twitterLangId = '<?php if ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' ) {
										echo 'ny0qk';
									} else {
										echo 'ny0qm';
									} ?>';
			!(function(e, t, n, s, u, a) {
				e.twq || (s = e.twq = function() {
						s.exe ? s.exe(...arguments) : s.queue.push(arguments);
					}, s.version = '1.1', s.queue = [], u = t.createElement(n), u.async = !0, u.src = '//static.ads-twitter.com/uwt.js',
					a = t.getElementsByTagName(n)[0], a.parentNode.insertBefore(u, a));
			}(window, document, 'script', 'https://static.ads-twitter.com/uwt.js'));
			// Insert Twitter Pixel ID and Standard Event data below
			twq('init', twitterLangId);
			twq('track', 'PageView');
		</script>

		<!-- End Twitter universal website tag code -->

		<script>
			// Language Setter for external links for Canada Post
			//
			// This module will retrieve the current language and
			// set the appropriate cookie (LANG) so any agnostic pages
			// linked from blogs to canadapost-postescanada.ca will render in
			// the same language

			let pageLang = '<?php echo (get_bloginfo( 'language') == "fr-CA" ? 'fr' : 'en' ); ?>';

			switch (pageLang) {
				case 'en':
					CPcookieLang = 'e';
					break;
				case 'fr':
					CPcookieLang = 'f';
					break;
				default:
					CPcookieLang = 'e';
			}
			document.cookie = 'LANG=' + CPcookieLang + '; path=/blogs/';
		</script>

		<meta name="cattype" content="blogs" />
		<?php
				$_post_cats = get_the_category();
				if ($_post_cats) {
					?>
			<meta name="category" content="<?php echo $_post_cats[0]->slug; ?>" />
		<?php
				} else {
					?>
			<meta name="category" content="" />
		<?php
				}
				?>
	<?php
		}
	}

	add_action('wp_footer', 'tracking_scripts_foot');
	function tracking_scripts_foot()
	{
		?>
	<script type="text/javascript">
		_bizo_data_partner_id = "9198";

		var metaval = jQuery("meta[name='sns']").attr("content");
		if (metaval == "business") {
			(function() {
				var s = document.getElementsByTagName("script")[0];
				var b = document.createElement("script");
				b.type = "text/javascript";
				b.async = true;
				s.parentNode.insertBefore(b, s);
			})();
		}

		var _comscore = _comscore || [];
		_comscore.push({
			c1: "2",
			c2: "6035946"
		});
		(function() {
			var s = document.createElement("script"),
				el = document.getElementsByTagName("script")[0];
			s.async = true;
			s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
			el.parentNode.insertBefore(s, el);
		})();
	</script>
<?php
}

register_nav_menus(
	array(
		'translation_menu' => 'Translation Menu',
	)
);

?>