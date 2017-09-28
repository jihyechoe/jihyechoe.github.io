<?php

// -----------------------------------------
// semplice
// /includes/helper.php
// -----------------------------------------

// post queries
require get_template_directory() . '/includes/helper/post_queries.php';

// images
require get_template_directory() . '/includes/helper/images.php';

// thumbnails
require get_template_directory() . '/includes/helper/thumbnails.php';

// onboarding
require get_template_directory() . '/includes/helper/onboarding.php';

// grid
require get_template_directory() . '/includes/helper/grid.php';

// typography
require get_template_directory() . '/includes/helper/typography.php';

// navigation
require get_template_directory() . '/includes/helper/navigation.php';

// sharebox
require get_template_directory() . '/includes/helper/sharebox.php';

// styles
require get_template_directory() . '/includes/helper/styles.php';

// covers
require get_template_directory() . '/includes/helper/covers.php';

// licensing
require get_template_directory() . '/includes/helper/licensing.php';

// notices
require get_template_directory() . '/includes/helper/notices.php';

// -----------------------------------------
// show content
// -----------------------------------------

function semplice_show_content($id, $what) {

	// globals
	global $semplice_content;
	global $admin_api;

	// if password required show form instead of content (only on pages and projects)
	if($what != 'posts' && $what != 'taxonomy' && post_password_required()) {
		// get frontend mode
		$frontend_mode = semplice_get_mode('frontend_mode');
		// set spa
		$spa = false;
		// check if frontend mode is dynamic
		if($frontend_mode == 'dynamic') {
			$spa = true;
		}
		$semplice_content['html'] = semplice_post_password($spa, $id);
	}

	// echo content
	echo '
		<div id="content-holder" data-active-post="' . $id . '">
			' . $admin_api->customize['navigations']->get('html', false, false, false) . '
			<div id="content-' . $id . '" class="content-container active-content ' . semplice_hide_on_init($id) . '">
				<div class="sections">
					' . $semplice_content['html'] . '
				</div>
			</div>
		</div>
	';
}

// -----------------------------------------
// generate ram ids
// -----------------------------------------

function semplice_generate_ram_ids($ram, $is_encoded, $is_block) {

	// is encoded?
	if($is_encoded) {
		// decode ram
		$ram = json_decode($ram, true);
	}

	// output
	$output = $ram;

	// images array
	$images = '';
	$images_arr = array();
	$image_modules = array('image', 'gallerygrid', 'video', 'gallery');

	// change ids
	foreach ($ram['order'] as $section_id => $section) {
		// isset?
		if(isset($ram[$section_id]) && $section_id != 'cover') {
			// get background image and add to images_array
			$images .= semplice_get_background_image($ram[$section_id]['styles']['xl']);
			// create new seciton id
			$new_section_id = 'section_' . substr(md5(rand()), 0, 9);
			// add to array
			$output['order'][$new_section_id] = array(
				'row_id' => 'row_' . substr(md5(rand()), 0, 9),
				'columns' => array(),
			);
			// add section content to the output
			$output[$new_section_id] = $ram[$section_id];
			// delete old id rom new ram
			unset($output[$section_id]);
			unset($output['order'][$section_id]);
			foreach ($section['columns'] as $column_id => $column_content) {
				// get background image and add to images_array
				$images .= semplice_get_background_image($ram[$column_id]['styles']['xl']);
				// create new id
				$new_column_id = 'column_' . substr(md5(rand()), 0, 9);
				// add content to array
				$output['order'][$new_section_id]['columns'][$new_column_id] = array();
				// add section content to column
				$output[$new_column_id] = $ram[$column_id];
				// delete old id rom new ram
				unset($output[$column_id]);
				foreach ($column_content as $content_id) {
					// get background image and add to images_array
					$images .= semplice_get_background_image($ram[$content_id]['styles']['xl']);
					// get all images used in module
					if(in_array($ram[$content_id]['module'], $image_modules)) {
						$images .= semplice_get_used_images($ram[$content_id]);
					}
					// create new id
					$new_content_id = 'content_' . substr(md5(rand()), 0, 9);
					// add to array
					$output['order'][$new_section_id]['columns'][$new_column_id][] = $new_content_id;
					// add section content to column
					$output[$new_content_id] = $ram[$content_id];
					// delete old id rom new ram
					unset($output[$content_id]);
				}
			}
		}
	}

	// add images to output if block
	if(true === $is_block) {
		// check if images array is empty?
		if(!empty($images)) {
			// remove last , from string
			if(substr($images, -1) == ',') {
				$images = substr($images, 0, -1);
			}
			$images = explode(",", $images);
			// fetch all image urls in case they have chnaged (ex domain)
			foreach ($images as $image_id) {
				// get image
				$images_arr[$image_id] = semplice_get_image($image_id, 'full');
			}
		} else {
			$images_arr = 'noimages';
		}
		// add images array to ouptut
		$output['images'] = $images_arr;
	}

	// return
	return $output;
}

// -----------------------------------------
// get post settings
// -----------------------------------------

function semplice_generate_post_settings($settings, $post) {

	// check if row has page settings
	if($settings) {
		// always get the latest saved title and permalink to match wordpress
		$settings['meta']['post_title'] = $post->post_title;
		$settings['meta']['permalink'] = $post->post_name;
	} else {
		// define some post settings defaults
		$settings = array(
			'thumbnail' => array(
				'image' => '',
				'width'	=> '',
				'hover_visibility' => 'disabled',
			),
			'meta' => array(
				'post_title' 	=> $post->post_title,
				'permalink'  	=> $post->post_name,
			),
		);
	}

	// yoast seo settings
	$yoast = array('title', 'metadesc', 'opengraph-image', 'opengraph-title', 'opengraph-description', 'twitter-image', 'twitter-title', 'twitter-description', 'meta-robots-nofollow', 'meta-robots-noindex', 'canonical');
	$prefix = '_yoast_wpseo_';

	// get seo from db
	foreach ($yoast as $setting) {
		// get setting
		$setting = $prefix . $setting;
		// check if post meta is there
		$post_meta = get_post_meta($post->ID, $setting, true);
		if(!empty($post_meta)) {
			$settings['seo'][$setting] = get_post_meta($post->ID, $setting, true);
		} else {
			// is set still in semplice? delete it
			if(isset($settings['seo'][$setting])) {
				unset($settings['seo'][$setting]);
			}
		}
	}

	// still empty?
	if(!isset($settings['seo']) || empty($settings['seo'])) {
		$settings['seo'] = new stdClass();
	}
	
	return $settings;
}

// -----------------------------------------
// save spinner
// -----------------------------------------

function semplice_save_spinner() {
	return '
		<div class="save-spinner">
			<div class="semplice-mini-loader">
				<svg class="semplice-spinner" width="20px" height="20px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
					<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
				</svg>
				<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14">
					<path id="Form_1" data-name="Form 1" d="M6.679,13.758L0.494,7.224,1.878,5.762l4.8,5.072L16.153,0.825l1.384,1.462Z"/>
				</svg>
				<span class="saving">Saving...</span>
				<span class="saved">Saved</span>
			</div>
		</div>
	';
}

// -----------------------------------------
// ajax save button
// -----------------------------------------

function semplice_ajax_save_button($link) {
	return $link . '
			<svg class="semplice-spinner" width="20px" height="20px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
				<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
			</svg>
			<svg class="ajax-save-checkmark" xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14">
				<path id="Form_1" data-name="Form 1" d="M6.679,13.758L0.494,7.224,1.878,5.762l4.8,5.072L16.153,0.825l1.384,1.462Z"/>
			</svg>
			<span class="save-button-text">Save</span>
		</a>
	';
}

// -----------------------------------------
// get the id we need
// -----------------------------------------

function semplice_get_id() {
	// get post id
	$post_id = get_the_ID();
	// format id
	$post_id = semplice_format_id($post_id, false);
	// return id
	return $post_id;
}

// -----------------------------------------
// format post id
// -----------------------------------------

function semplice_format_id($post_id, $is_crawler) {
	// get blog homepage id
	$blog_home = get_option('page_for_posts');
	// check if blog homepage is not set
	if($blog_home == 0) {
		$blog_home = 'posts';
	}
	// is blog home or not found?
	if(is_home() && !$is_crawler || $post_id == 'posts' || $post_id == $blog_home) {
		$post_id = 'posts';
	} else if(empty($post_id)) {
		$post_id = 'notfound';
	}
	// return id
	return $post_id;
}

// -----------------------------------------
// set the init visibility of our content div
// -----------------------------------------

function semplice_hide_on_init($post_id) {

	// set hide on init
	$hide_on_init = ' hide-on-init';

	// echo content depending on the app mode
	if(semplice_get_sr_status() == 'disabled' || $post_id == 'notfound') {
		$hide_on_init = '';
	}

	// output
	return $hide_on_init;
}

// -----------------------------------------
// semplice get post ids
// -----------------------------------------

function semplice_get_post_Ids() {

	// wpdb
	global $wpdb;

	// define post ids array
	$post_ids = array();

	// get posts
	$posts = $wpdb->get_results("SELECT ID, post_name FROM $wpdb->posts WHERE post_status = 'publish'");

	// iterate posts
	foreach ($posts as $post) {
		$post_ids[$post->post_name] = $post->ID;
	}

	// return
	return $post_ids;
}

// -----------------------------------------
// get scroll reveal status on first post
// -----------------------------------------

function semplice_get_sr_status() {

	// vars
	global $post;
	$sr_status = 'enabled';

	// get content
	if(is_object($post)) {
		
		// format post id
		$post_id = semplice_format_id($post->ID, false);

		// instance of get smeplice content
		$semplice_get_content = new semplice_get_content;

		// get content
		$ram = $semplice_get_content->get_ram($post->ID, is_preview());

		// is semplice
		$is_semplice = get_post_meta($post->ID, '_is_semplice', true);

		// check sr status
		if($post_id == 'posts' || $post->post_type == 'post') {
			// get options
			$blog_options = json_decode(get_option('semplice_customize_blog'), true);
			// is array?
			if(is_array($blog_options)) {
				if(isset($blog_options['blog_scroll_reveal']) && $blog_options['blog_scroll_reveal'] == 'disabled') {
					$sr_status = 'disabled';
				}
			}
		} else if(isset($ram['branding']['scroll_reveal']) && $ram['branding']['scroll_reveal'] == 'disabled' || $post_id == 'notfound' || !$is_semplice) {
			$sr_status = 'disabled';
		}
	}

	// return
	return $sr_status;
}

// -----------------------------------------
// get mode
// -----------------------------------------

function semplice_get_mode($mode) {

	// frontend settings
	$settings = semplice_settings('general');

	// defaults
	$defaults = array(
		'frontend_mode' 	=> 'static',
	);

	// check if mode option in the admin is already set
	if(semplice_rest_url() == 'no-rest-api') {
		return 'static';
	} if(isset($settings) && isset($settings[$mode])) {
		return $settings[$mode];
	} else {
		return $defaults[$mode];
	}
}

// -----------------------------------------
// get modules
// -----------------------------------------

function semplice_get_modules() {

	// modules
	$modules = array(
		'oembed' 		=> 'oEmbed',
		'portfoliogrid' => 'Portfolio Grid',
		'code'			=> 'Code',
		'share'			=> 'Share',
		'dribbble'		=> 'Dribbble',
		'instagram'		=> 'Instagram',
		'gallerygrid'   => 'Gallery Grid',
		'mailchimp'		=> 'Mailchimp',
	);

	// list
	$list = '';

	foreach ($modules as $module => $content) {
		// add to list
		$list .= '<li><a class="add-content add-module" data-module="' . $module . '"><span>' . get_svg('backend', 'icons/module_' . $module) . '</span>' . $content . '</a></li>';
	}

	// output list
	return '
		<h4>Add Content with</br>our custom modules.</h4>
		<div class="modules">
			<ul class="modules-list">
				' . $list . '
			</ul>
		</div>
	';
}

// -----------------------------------------
// check wp version requirement
// -----------------------------------------

function semplice_wp_version_is($method, $version) {
	// get wp version
	global $wp_version;
	// version compare
	if(version_compare($wp_version, $version, $method)) {
		return true;
	} else {
		return false;
	}
}

// -----------------------------------------
// get rest api url
// -----------------------------------------

function semplice_rest_url() {
	// get rest url
	if(function_exists('rest_url')) {
		return rest_url();
	} else {
		return 'no-rest-api';
	}
}

// -----------------------------------------
// check if value is boolean
// -----------------------------------------

function semplice_boolval($val) {
	return filter_var($val, FILTER_VALIDATE_BOOLEAN);
}

// -----------------------------------------
// semplice head
// -----------------------------------------

function semplice_head($settings) {

	// define output
	$output = '';

	// settings?
	if(is_array($settings)) {
		// google analytics
		if(isset($settings['google_analytics']) && !empty($settings['google_analytics'])) {
			// is script?
			if (strpos($settings['google_analytics'], '<script') !== false) {
				$output .= $settings['google_analytics'];
			}
		}
		// favicon
		if(isset($settings['favicon']) && !empty($settings['favicon'])) {
			// get image url
			$favicon = wp_get_attachment_image_src($settings['favicon'], 'full', false);
			if($favicon) {
				$output .= '<link rel="shortcut icon" type="image/png" href="' . $favicon[0] . '" sizes="32x32">';
			}
		}
	}

	// output
	return $output;
}

// -----------------------------------------
// get category base
// ----------------------------------------

function semplice_get_category_base() {
	// category base
	global $wp_rewrite;
	$category_base = str_replace('%category%', '', $wp_rewrite->get_category_permastruct());
	// return
	return $category_base;
}

// ----------------------------------------
// get tag base
// ----------------------------------------

function semplice_get_tag_base() {
	// category base
	global $wp_rewrite;
	$tag_base = str_replace('%post_tag%', '', $wp_rewrite->get_tag_permastruct());
	// return
	return $tag_base;
}

// ----------------------------------------
// get general settings
// ----------------------------------------

function semplice_get_general_settings() {
	// get general settings and add homepage settings
	$settings = json_decode(get_option('semplice_settings_general'), true);
	// add homepage settings from WP
	$settings['show_on_front'] = get_option('show_on_front');
	$settings['page_on_front']  = get_option('page_on_front');
	$settings['page_for_posts'] = get_option('page_for_posts ');
	// site meta
	$settings['site_title'] = get_option('blogname');
	$settings['site_tagline'] = get_option('blogdescription');
	// return
	return $settings;
}

// ----------------------------------------
// semplice about
// ----------------------------------------

function semplice_about() {

	// get currect license
	$license = semplice_get_license();

	// define licenses
	$licenses = array(
		's4-single'				=> 'Single',
		's4-studio'				=> 'Studio',
		's4-single-to-studio'	=> 'Studio',
		's4-business'			=> 'Business',
		's4-single-to-business'	=> 'Business',
		's4-studio-to-business'	=> 'Business'
	);

	// license
	$about = array();

	if(!$license['is_valid']) {
		$about['registered-to'] = 'Unregistered';
		$about['license-type'] = 'Inactive';
	} else {
		$about['registered-to'] = $license['name'];
		$about['license-type'] = $licenses[$license['product']] . ' License';
	}

	return '
		<p class="first">
			<span>Theme</span><br />
			Semplice ' . ucfirst(semplice_theme('edition')) . ' ' . semplice_theme('version') . '<br />
			<a class="changelog" href="https://www.semplice.com/changelog-v4-studio" target="_blank">Changelog</a>
		</p>
		<p>
			<span>License</span><br />
			' . $about['license-type'] . '
		</p>
		<p>
			<span>Owner</span><br />
			' . $about['registered-to'] . '
		</p>
		<p>
			<span>PHP Version</span><br/>
			php: ' . semplice_theme('php_version') . '
		</p>
		<p class="last">
			<span>Support</span><br />
			<a href="http://help.semplicelabs.com" target="_blank">Helpdesk</a><br />
		</p>
	';
}

// ----------------------------------------
// semplice password form
// ----------------------------------------

function semplice_post_password($spa, $id) {

	// dynamic
	if(true === $spa) {
		$form = '
			
			<style>
				#content-holder p {
					font-family: "ff-tisa-web-pro", sans-serif;
				}
			</style>
			<div class="post-password-form">
				<p style="font-size: 60px; font-weight: 600; padding-top: 80px;">Boooooo!</p>
				<p style="padding-top: 10px; padding-bottom: 20px; font-size: 25px; font-weight: 300;">Unfortunately, due to a NDA this work is password protected.</p>
				<p>
					<label>
						Password: <input name="post_password" id="pwbox-71" type="password" size="20">
					</label> 
					<a style="display: inline-block; font-size: 25px; color: #61616d; margin-top: 10px; height: 58px" class="post-password-submit semplice-event" data-event-type="helper" data-event="postPassword" data-id="' . $id . '">Enter</a> 
					<a href="/work" style="font-size: 25px; margin-left: 25px; font-weight: 300" class="underline_link">See all work &gt;</a>

				</p>
			</div>
		';
	} else {
		$form = get_the_password_form();
	}

	return '
		<div class="sections">
			<section class="content-block">
				<div class="container">
					<div class="row">
						<div class="column" data-xl-width="12">
							<div class="column-content" style="width: 100%">
								' . $form . '
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	';
}

?>
