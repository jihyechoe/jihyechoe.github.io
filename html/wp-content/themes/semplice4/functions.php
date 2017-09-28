<?php

// -----------------------------------------
// semplice
// functions.php
// -----------------------------------------

// -----------------------------------------
// launch semplice after activation
// -----------------------------------------

function launch_semplice() {
	// home
	$home = '#dashboard';
	// if onboarding is true, set onboarding as homepage
	if(semplice_is_onboarding()) {
		$home = '#onboarding/start';
	}
	// launch semplice
	wp_redirect(admin_url('admin.php?page=semplice-admin' . $home));
}

add_action('after_switch_theme', 'launch_semplice');

// -----------------------------------------
// get theme info
// -----------------------------------------

function semplice_theme($meta) {

	// theme info array
	$theme_info = array(
		'version' => '4.0.6',
		'edition' => 'studio',
		'php_version' => PHP_VERSION
	);

	// return theme info
	return $theme_info[$meta]; 
}

// -----------------------------------------
// get theme settings
// -----------------------------------------

function semplice_settings($type) {
	// get settings
	return json_decode(get_option('semplice_settings_' . $type), true);
}

// -----------------------------------------
// basic semplice theme setup
// -----------------------------------------

if (!function_exists('semplice_setup')) {

	// semplice setup function
	function semplice_setup() {
		
		// add post-thumbnail support
		add_theme_support('post-thumbnails');

		// html5 support for the search form
		add_theme_support('html5', array('search-form'));
		
		// remove wp-texturize
		remove_filter('the_content', 'wptexturize');

		// add title tag support
		add_theme_support('title-tag');

		// register main menu
		register_nav_menu('semplice-main-menu', 'Semplice Main Menu');

		// admin notices
		semplice_admin_notices();
		
	}
}

// setup the theme
add_action('after_setup_theme','semplice_setup');

// add svg to allowed file upload type
function cc_mime_types($mime_types){
	$mime_types['svg'] = 'image/svg+xml';
	return $mime_types;
}

add_filter('upload_mimes', 'cc_mime_types');

// change archive url
function semplice_init() {
	global $wp_rewrite;
    $wp_rewrite->date_structure = 'archives/%year%/%monthnum%/%day%';
}
add_action('init', 'semplice_init');

// -----------------------------------------
// admin functions, custom css and api endpoints
// -----------------------------------------

// mobile detect
require get_template_directory() . '/includes/mobile_detect.php';
$detect = new Mobile_Detect;

// helper functions
require get_template_directory() . '/includes/helper.php';

// apis and classes
require get_template_directory() . '/admin/editor/rest_api.php';
require get_template_directory() . '/includes/content.php';
require get_template_directory() . '/admin/rest_api.php';
require get_template_directory() . '/rest_api.php';

// register custom api endpoints
function semplice_api_init() {
	// classes
	global $editor_api;
	global $admin_api;
	global $frontend_api;
	// register routes on api init
	$editor_api->register_routes();
	$admin_api->register_routes();
	$frontend_api->register_routes();
}

add_action('rest_api_init', 'semplice_api_init');

// custom css
require get_template_directory() . '/includes/custom_css.php';

// admin functions
if(is_admin()) {
	require get_template_directory() . '/admin/functions.php';
}

// -----------------------------------------
// get semplice content
// -----------------------------------------

if(!is_admin()) {
	$semplice_content = array();

	function semplice_get_content() {

		// globals
		global $post;
		global $semplice_content;

		// paged
		$paged = get_query_var('paged', 1); 

		// instance of content class
		$content = new semplice_get_content;

		// check taxonomy
		$term = false;
		if(is_category()) {
			$term = get_term_by('id', get_query_var('cat'), 'category');
		} else if(is_tag()) {
			$term = get_term_by('name', get_query_var('tag'), 'post_tag');
		}

		// post id
		if(is_object($post)) {
			$post_id = $post->ID;
		} else {
			$post_id = 'notfound';
		}

		// fetch content
		$semplice_content = $content->get(semplice_format_id($post_id, false), is_preview(), $paged, $term);
	}

	add_action('wp', 'semplice_get_content');
}

// -----------------------------------------
// frontend css
// -----------------------------------------

function frontend_css() {

	// globals
	global $semplice_custom_css;

	// webfonts
	$frontend_css = $semplice_custom_css->webfonts();

	// custom css
	$frontend_css .= '
		<style type="text/css" id="semplice-custom-css">
			' . $semplice_custom_css->grid('frontend') . '
			' . $semplice_custom_css->typography(false) . '
			' . $semplice_custom_css->blog(false) . '
			' . $semplice_custom_css->advanced(true) . '
		</style>
	';

	// get post id
	$post_id = semplice_get_id();

	// search and replace
	$search  = array('#content-holder', 'body');
	$replace = array('#content-' . $post_id, '#content-' . $post_id);

	// post css
	$frontend_css .= '
		<style type="text/css" id="' . $post_id . '-post-css">
			' . semplice_get_post_css_js('css', $post_id) . '
			' . str_replace($search, $replace, $semplice_custom_css->navigation()) . '
		</style>
	';

	// return
	echo $frontend_css;
}

add_action('wp_head', 'frontend_css');

// -----------------------------------------
// frontend js
// -----------------------------------------

function frontend_js() {

	// get post id
	$post_id = get_the_ID();

	// get motion js
	$motion_js = semplice_get_post_css_js('js', $post_id);

	if(!empty($post_id) && !empty($motion_js)) {
		// motion js
		echo '
			<script type="text/javascript" id="' . $post_id . '-motion-js">
				' . $motion_js . '
			</script>
		';
	}
}

add_action('wp_footer', 'frontend_js', 300);

// -----------------------------------------
// global custom javascript
// -----------------------------------------

function custom_javascript() {

	// get advanced content
	$advanced = json_decode(get_option('semplice_customize_advanced'), true);
	// is array?
	if(is_array($advanced)) {
		// check if custom js is there and not empty
		if(isset($advanced['custom_js']) && !empty($advanced['custom_js'])) {
			echo '<script type="text/javascript" id="semplice-custom-javascript">' . $advanced['custom_js'] . '</script>';
		}
	}
}

add_action('wp_footer', 'custom_javascript', 300);

// -----------------------------------------
// body classes
// -----------------------------------------

function semplice_body_classes($classes) {

	// check if dashboard or not
	if(!is_admin()) {
		$classes[] = 'is-frontend';
	}

	// app mode
	if(semplice_get_mode('frontend_mode') == 'static') {
		$classes[] = 'static-mode';
	} else {
		$classes[] = 'dynamic-mode';
	}

	// preview
	if(is_preview()) {
		$classes[] = 'is-preview';
	}

	return $classes;
}

add_filter('body_class','semplice_body_classes');

// -----------------------------------------
// custom post types
// -----------------------------------------

require get_template_directory() . '/includes/post-types/portfolio.php';
require get_template_directory() . '/includes/post-types/footer.php';

// -----------------------------------------
// localize script defaults
// -----------------------------------------

function semplice_localize_script_defaults() {

	// mode defaults
	$frontend_mode = semplice_get_mode('frontend_mode');

	// frontpage id
	if(get_option('page_on_front')) {
		$front_page = get_option('page_on_front');
	} else {
		$front_page = 'posts';
	}

	// create output array
	$output = array(
		'default_api_url' 		=> untrailingslashit(semplice_rest_url()),
		'semplice_api_url'		=> home_url() . '/wp-json/semplice/v1/frontend',
		'template_dir'			=> get_template_directory_uri(),
		'category_base'			=> semplice_get_category_base(),
		'tag_base'				=> semplice_get_tag_base(),
		'nonce'  				=> wp_create_nonce('wp_rest'),
		'frontend_mode'			=> $frontend_mode,
		'site_name'				=> get_bloginfo('name'),
		'base_url'				=> home_url(),
		'frontpage_id'			=> $front_page,
		'blog_home'				=> get_post_type_archive_link('post'),
		'sr_status'				=> semplice_get_sr_status(),
		'is_preview'			=> is_preview(),
		'password_form'			=> semplice_post_password(true, false),
		'gallery'				=> array(
			'prev'  => get_svg('frontend', 'icons/arrow_left'),
			'next'  => get_svg('frontend', 'icons/arrow_right'),
			//'lightbox_prev' => setIcon('lightbox_prev'),
			//'lightbox_next' => setIcon('lightbox_next'),
		),
	);

	// get transition options
	$transition_customize = json_decode(get_option('semplice_customize_transitions'), true);

	// add items for the dynamic version
	if($frontend_mode != 'static') {

		// assign navbars html and css
		$output['menus'] = semplice_get_menus();
		
		// assign post ids
		$output['post_ids'] = semplice_get_post_ids();

		// get transitions
		require get_template_directory() . '/includes/transitions.php';

		// set transition defaults
		$transitions = array(
			'in' => $transition_atts['presets']['fade']['in'],
			'out' => $transition_atts['presets']['fade']['out'],
		);

		// merge default options into array
		$transitions = array_merge($transitions, $transition_atts['options']);

		// get transition presets
		if(get_option('semplice_customize_transitions')) {
			
			// check it and add it to transitions
			if(null !== $transition_customize && isset($transition_customize['status']) && $transition_customize['status'] != 'disabled') {
				// get presets for in and out transition
				if(isset($transition_customize['preset']) && $transition_customize['preset'] != 'fade') {
					// set preset
					$transitions['preset'] = $transition_customize['preset'];
					// set in and out defaults
					$transitions['in'] = $transition_atts['presets'][$transition_customize['preset']]['in'];
					$transitions['out'] = $transition_atts['presets'][$transition_customize['preset']]['out'];
				}
				
				// get option values
				$options = array(
					'out' => array('duration', 'easing'),
					'in' => array('duration', 'easing'),
				);

				foreach ($options as $option => $option_values) {
					foreach ($option_values as $key => $value) {
						if(isset($transition_customize[$value . '_' . $option]) && !empty($transition_customize[$value . '_' . $option])) {
							// assign value
							$transitions[$option][$value] = $transition_customize[$value . '_' . $option];
						}
					}
				}
				// set status
				$transitions['status'] = 'enabled';
			}
		}
		// assign transitions to the array
		$output['transition'] = $transitions;
	}

	// scroll reveal options
	$sr_atts = array('sr_viewFactor', 'sr_distance', 'sr_easing', 'sr_duration', 'sr_opacity', 'sr_scale');
	// loop through atts
	foreach ($sr_atts as $attribute) {
		if(isset($transition_customize[$attribute])) {
			$output['sr_options'][str_replace('sr_', '', $attribute)] = $transition_customize[$attribute];
		}
	}

	// return
	return $output;
}

// -----------------------------------------
// enqueue scripts
// -----------------------------------------

function semplice_frontend_scripts() {
	// style css
	wp_enqueue_style('semplice-stylesheet', get_stylesheet_uri(), array(), semplice_theme('version'));

	// fontend styles
	wp_enqueue_style('semplice-frontend-stylesheet', get_template_directory_uri() . '/assets/css/frontend.min.css', false, semplice_theme('version'));

	// mediaelement css
	wp_enqueue_style('mediaelement');

	// semplice frontend javascript
	wp_enqueue_script('semplice-frontend-js', get_template_directory_uri() . '/assets/js/frontend.min.js', array('jquery', 'mediaelement'), semplice_theme('version'), true);
	wp_localize_script('semplice-frontend-js', 'semplice', semplice_localize_script_defaults());
}

add_action('wp_enqueue_scripts', 'semplice_frontend_scripts');

// -----------------------------------------
// misc functions
// -----------------------------------------

function get_svg($mode, $icon) {
	// mode
	if($mode == 'backend') {
		$svg = file_get_contents('assets/images/admin/' . $icon . '.svg', true);
	} else {
		$svg = file_get_contents('assets/images/frontend/' . $icon . '.svg', true);
	}
	// return the svg source code
	return $svg;
}
?>