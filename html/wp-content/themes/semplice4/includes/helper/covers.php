<?php

// -----------------------------------------
// get default cover
// -----------------------------------------

function semplice_default_cover($cover_visibility) {
	return '
		<section id="cover" class="semplice-cover default-cover" data-cover="' . $cover_visibility . '" data-column-mode-xs="single" data-column-mode-sm="single" data-height="fullscreen">
			<div class="container">
				<div id="row_cover" class="row">
					<div class="empty-cover">
						<h2>Add Cover</h2>
						<p>Once your cover is uploaded you can either start adding regular content (like paragraphs, images, buttons) or you can change your cover settings (like cover zoom, parallax) in the section options.</p>
						<a class="upload-button semplice-button admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-upload="cover" data-media-type="cover" data-input-type="admin-image-upload" name="cover">Upload Cover Image or Video</a>
						<a class="no-upload editor-action" data-handler="execute" data-action="createCover" data-action-type="helper" data-has-media="no">Create cover without upload</a>
					</div>
				</div>
			</div>
			<a class="show-more show-more-hidden semplice-event" data-event-type="helper" data-event="scrollToContent">' . get_svg('frontend', '/icons/arrow_down') . '</a>
		</section>
	';
}

// ----------------------------------------
// get posts with covers
// ----------------------------------------

function semplice_posts_with_covers() {

	// fetch all pages and projects
	$args = array(
		'posts_per_page' => -1,
		'post_type' 	 => array('page', 'project'),
		'post_status'	 => 'publish',
	);

	// get posts
	$posts = get_posts($args);

	// covers
	$covers = array();

	// iterate throught posts
	if(is_array($posts) && !empty($posts)) {
		foreach ($posts as $id => $post) {
			// check if semplice
			$is_semplice = get_post_meta($post->ID, '_is_semplice', true);
			if($is_semplice) {
				// get ram
				$ram = json_decode(get_post_meta($post->ID, '_semplice_content', true), true);
				// check if cover
				if(isset($ram['cover']) && !empty($ram['cover']) && $ram['cover_visibility'] != 'hidden') {
					$covers[$post->ID] = $post->post_title;
				}
			}
		}
	}

	// return covers
	return $covers;
}

// ----------------------------------------
// get coverslider
// ----------------------------------------

function semplice_get_coverslider($coverslider, $visibility) {
	// output
	$output = array(
		'html' 		=> '',
		'css'  		=> '',
	);
	// get covers
	$posts_with_covers = semplice_posts_with_covers();

	// added covers
	$covers = $coverslider['covers'];
	// are there any covers?
	if(!empty($posts_with_covers)) {
		// cover count
		$count = 0;
		// check if added covers are in the valid coverlist or maybe deleted or change to draft
		foreach ($covers as $post_id) {
			if(isset($posts_with_covers[$post_id])) {
				$count++;
			}
		}
		// launch coverslider if count > 0
		if($count > 0) {
			// get output
			$output = semplice_coverslider_output($coverslider, $visibility);
		} else {
			$output['html'] = semplice_empty_coverslider();
		}
	} else {
		$output['html'] = semplice_empty_coverslider();
	}
	
	// return output
	return $output;
}

// ----------------------------------------
// get coverslider
// ----------------------------------------

function semplice_coverslider_output($coverslider, $visibility) {
	// globals
	global $detect;
	global $editor_api;
	global $semplice_get_content;

	// extract options
	extract( shortcode_atts(
		array(
			'orientation' 			=> 'vertical',
			'navigation'			=> 'dots',
			'color'					=> '#333333',
			'content_after_slider' 	=> false,
			'easing'				=> 'ease',
			'custom_easing'			=> '',
			'duration'				=> 900,
			'parallax'				=> 'disabled',
			'parallax_type' 		=> 'cover',
			'parallax_offset'		=> '60',
		), $coverslider)
	);

	// slider vars
	$covers = $coverslider['covers'];
	$slide_or_section = 'section';
	$has_navigation = 'true';
	$custom_options = '';
	$active_slider = '';
	$has_dots = '';

	// action / event vars
	$action_class = 'editor-action';
	$action_event = 'action';
	$action_type = 'coverslider';
	

	// is frontend?
	if($visibility != 'editor') {
		$action_class = 'semplice-event';
		$action_event = 'event';
		$action_type = 'helper';
		$active_slider = '
			activeCoverSlider = true;
		';
	}

	// define
	$output = array(
		'html' 		=> '',
		'css'  		=> '',
	);

	// custom easing
	if(!empty($custom_easing) && strpos($custom_easing, 'cubic-bezier') !== false) {
		$easing = $custom_easing;
	}

	// add dots / arrows color
	$output['css'] .= '#fp-nav ul li a span, .fp-slidesNav ul li a span { background: ' . $color . '; } .fp-hor-nav a svg, .fp-vert-nav a svg { fill: ' . $color . '; } ';

	// content after slider
	if($orientation == 'horizontal' && !empty($content_after_slider) && $visibility != 'editor') {
		$custom_options .= 'autoScrolling: false, fitToSection: false,';
	}

	// parallax?
	if($parallax == 'enabled' && false === $detect->isMobile()) {

		$custom_options .= 'parallax: true, parallaxKey: "QU5ZXzE2ZmNHRnlZV3hzWVhnPTVVZg==",';
		// parallax options
		$custom_options .= 'parallaxOptions: {type: "' . $parallax_type . '", percentage: ' . $parallax_offset . ' },';
	}

	// coverslider navigation
	if($orientation == 'horizontal') {
		
		// set slide mode for the cover slider
		$slide_or_section = 'slide';
		
		if($navigation == 'arrows') {
			// add arrows
			$output['html'] .= '
				<div class="fp-hor-nav">
					<a class="prev ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="horizontal" data-direction="prev">' . get_svg('frontend', 'icons/arrow_left') . '</a>
					<a class="next ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="horizontal" data-direction="next">' . get_svg('frontend', 'icons/arrow_right') . '</a>
				</div>
			';
			// set vertical dots to true
			$has_navigation = 'false';
		} else {
			// show slides navigation
			$custom_options .= 'slidesNavigation: true,';
			// has dots
			$has_dots = 'has-dots';
			// set vertical dots to true
			$has_navigation = 'false';
		}
		
	} else {
		// vertical navigation with arrows
		if($navigation == 'arrows') {
			// add arrows
			$output['html'] .= '
				<div class="fp-vert-nav">
					<a class="prev ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="vertical" data-direction="prev">' . get_svg('frontend', 'icons/arrow_up') . '</a>
					<a class="next ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="vertical" data-direction="next">' . get_svg('frontend', 'icons/arrow_down') . '</a>
				</div>
			';
			// set dots to false
			$has_navigation = 'false';
		}
	}

	// add global view project button css
	$output['css'] .= semplice_get_vp_button('css', 'global', false, $coverslider, $has_dots);

	// slider start
	$output['html'] .= '<div id="coverslider">';

	// if horizontal wrap in section
	if($orientation == 'horizontal') {
		$output['html'] .= '<div class="section">';
	}

	foreach ($covers as $key => $post_id) {
		// get status
		$status = get_post_status($post_id);
		// only get covers from published posts
		if($status == 'publish') {
			// get ram
			$ram = json_decode(get_post_meta($post_id, '_semplice_content', true), true);
			// styles
			$styles = $ram['cover']['styles']['xl'];
			// check if ram and cover are set
			if(null !== $ram && isset($ram['cover'])) {
				// overwrite order with cover order so that only the covers gets executed by get content
				$ram['order'] = array(
					'cover' => $ram['order']['cover'],
				);
				// to avoid id problems from duplicates we will change the content ids on the fly here
				$cover = array(
					'order' => array(
						'cover' => array(
							'columns' => array(),
							'row_id'  => 'row_cover'
						),
					),
					'cover_visibility' => 'visible',
					'cover' => $ram['cover'],
				);
				// get cover content if there
				if(isset($ram['order']['cover']['columns']) && !empty($ram['order']['cover']['columns'])) {
					foreach ($ram['order']['cover']['columns'] as $column_id => $column) {
						// create new id
						$new_column_id = 'column_' . substr(md5(rand()), 0, 9);
						// add column to new cover
						$cover[$new_column_id] = $ram[$column_id];
						// add new section to new order
						$cover['order']['cover']['columns'][$new_column_id] = array();
						// iterate column content
						foreach ($column as $content_id) {
							// create new id
							$new_content_id = 'content_' . substr(md5(rand()), 0, 9);
							// add content to new cover
							$cover[$new_content_id] = $ram[$content_id];
							// add to new order
							$cover['order']['cover']['columns'][$new_column_id][] = $new_content_id;
						}
					}
				}
				// add post id and scroll reveal to ram
				$cover['post_id'] = $post_id;
				// get cover and contents
				$content = $editor_api->get_content($cover, 'frontend', false, false);
				// get vp options
				if(isset($styles['vp_button_type']) && $styles['vp_button_type'] == 'custom') {
					// add view project css
					$output['css'] .= semplice_get_vp_button('css', $post_id, get_the_permalink($post_id), $styles, $has_dots);
					// add view project button
					$content['html'] .= semplice_get_vp_button('html', $post_id, get_the_permalink($post_id), $styles, $has_dots);
				} else {
					// add view project button
					$content['html'] .= semplice_get_vp_button('html', 'global', get_the_permalink($post_id), $coverslider, $has_dots);
				}
				// add html and css content
				$output['html'] .= '<div class="' . $slide_or_section . '">' . $content['html'] . '</div>';
				// add cover css
				$output['css'] .= $content['css'];
			}
		}
	}

	// close section wrap
	if($orientation == 'horizontal') {
		$output['html'] .= '</div>';
	}

	// close slider
	$output['html'] .= '</div>';

	// add javascript
	$output['html'] .= '
		<script type="text/javascript">
			(function($) {
				$(document).ready(function () {
					' . $active_slider . '
					$("#coverslider").fullpage({
						navigation: ' . $has_navigation . ',
						' . $custom_options . '
						navigationPosition: "right",
						animateAnchor: false,
						scrollingSpeed: ' . $duration . ',
						controlArrows: false,
						css3: true,
						easingcss3: "' . $easing . '",
						loopBottom: true,
						loopTop: true,
						loopHorizontal: true,
						normalScrollElements: "#overlay-menu, #admin-edit-popup",
						afterRender: function() {
							$("#fp-nav, .fp-slidesNav").find("a").each(function() {
								$(this).removeAttr("href");
							});
						}
					});
				});
			})(jQuery);
		</script> 
	';

	// content after slider
	if(false !== $content_after_slider && is_numeric($content_after_slider) && $visibility != 'editor') {
		// get ram
		$ram = json_decode(get_post_meta($content_after_slider, '_semplice_content', true), true);
		// make sure ram has content
		if(null !== $ram && isset($ram['order'])) {
			// delete cover if there
			if(isset($ram['order']['cover'])) {
				unset($ram['order']['cover']);
			}
			// get content
			$content = $editor_api->get_content($ram, 'frontend', false, false);
			// add content to output
			foreach ($output as $content_type => $output_content) {
				if(isset($content[$content_type])) {
					$output[$content_type] .= $content[$content_type];
				}
			}
		}
	}

	// return coverslider
	return $output;
}

// ----------------------------------------
// get view project button
// ----------------------------------------

function semplice_get_vp_button($mode, $post_id, $permalink, $options, $has_dots) {
	// extract options
	extract( shortcode_atts(
		array(
			'vp_button_label'					=> 'View Project',
			'vp_button_font_family'				=> '',
			'vp_button_font_size'				=> '0.7222222222222222rem',
			'vp_button_letter_spacing'			=> 0,
			'vp_button_padding_ver'				=> '0.4444444444444444rem',
			'vp_button_padding_hor'				=> '1.666666666666667rem',
			'vp_button_border_width'			=> '0.0555555555555556rem',
			'vp_button_border_radius'			=> '0.1111111111111111rem',
			'vp_button_font_color'				=> '#ffffff',
			'vp_button_bg_color'				=> 'transparent',
			'vp_button_border_color'			=> '#ffffff',
			'vp_button_font_mouseover_color'	=> '#000000',
			'vp_button_bg_mouseover_color'		=> '#ffffff',
			'vp_button_border_mouseover_color'	=> '#ffffff',
		), $options )
	);
	// mode
	if($mode == 'html') {
		// empty label?
		if(empty($vp_button_label)) {
			$vp_button_label = 'View Project';
		}
		// return
		return '<div class="view-project vp-' . $post_id . ' ' . $has_dots . ' ' . $vp_button_font_family . '"><a href="' . $permalink . '">' . $vp_button_label . '</a></div>';
	} else {
		// styles
		$css = '
			.vp-' . $post_id . ' a {
				font-size: ' . $vp_button_font_size . ';
				letter-spacing: ' . $vp_button_letter_spacing . ';
				color: ' . $vp_button_font_color . ';
				background-color: ' . $vp_button_bg_color . ';
				border-color: ' . $vp_button_border_color . ';
				padding: ' . $vp_button_padding_ver . ' ' . $vp_button_padding_hor . ';
				border-radius: ' . $vp_button_border_radius . ';
				border-width: ' . $vp_button_border_width . ';
			}
		';
		// styles mouseocver
		$css .= '
			.vp-' . $post_id . ':hover a {
				color: ' . $vp_button_font_mouseover_color . ';
				background-color: ' . $vp_button_bg_mouseover_color . ';
				border-color: ' . $vp_button_border_mouseover_color . ';
			}
		';
		// return
		return $css;
	}
}

// ----------------------------------------
// empty cover slider
// ----------------------------------------

function semplice_empty_coverslider() {
	return '
		<section id="cs" class="semplice-cover default-cover" data-column-mode-xs="single" data-column-mode-sm="single" data-height="fullscreen">
			<div class="container">
				<div id="row_cover" class="row">
					<div class="empty-cover empty-coverslider">
						<h2>Missing Covers</h2>
						<p>In order to select your covers for the cover slider you need to have a fullscreen cover enabled on your project or page. Also make sure your project or page is published and not set to draft.</p>
						<div class="help-videos">
							<a href="https://vimeo.com/214124569/e1337fa720" target="_blank">Create a Coverslider</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	';
}

// ----------------------------------------
// import cover
// ----------------------------------------

function semplice_import_cover($post_id) {

	// content class
	global $editor_api;

	// output
	$output = array(
		'ram'  => array('cover' => array(), 'content' => array()),
		'html' => '',
		'css'  => '',
	);

	// get ram
	$ram = json_decode(get_post_meta($post_id, '_semplice_content', true), true);

	// check ram
	if(null !== $ram && isset($ram['cover'])) {
		// assign only cover to order
		$ram['order'] = array(
			'cover' => $ram['order']['cover'],
		);
		// add new order
		$new_cover = array(
			'order' => array(
				'cover' => array(
					'columns' => array(),
					'row_id'  => 'row_cover'
				),
			),
			'cover_visibility' => 'visible',
			'cover' => $ram['cover'],
		);
		// get cover content if there
		if(isset($ram['order']['cover']['columns']) && !empty($ram['order']['cover']['columns'])) {
			foreach ($ram['order']['cover']['columns'] as $column_id => $column) {
				// create new id
				$new_column_id = 'column_' . substr(md5(rand()), 0, 9);
				// add column to content
				$output['ram']['content'][$new_column_id] = $ram[$column_id];
				// add column to new cover
				$new_cover[$new_column_id] = $ram[$column_id];
				// add new section to new order
				$new_cover['order']['cover']['columns'][$new_column_id] = array();
				// iterate column content
				foreach ($column as $content_id) {
					// create new id
					$new_content_id = 'content_' . substr(md5(rand()), 0, 9);
					// add to ram
					$output['ram']['content'][$new_content_id] = $ram[$content_id];
					// add content to new cover
					$new_cover[$new_content_id] = $ram[$content_id];
					// add to new order
					$new_cover['order']['cover']['columns'][$new_column_id][] = $new_content_id;
				}
			}
		}
		// get cover and contents
		$content = $editor_api->get_content($new_cover, 'editor', false, false);
		
		// add html and css content
		$output['ram']['cover'] = $ram['cover'];
		$output['html'] = $content['html'];
		$output['css'] = $content['css'];
	} else {
		$output['ram'] = 'nocover';
	}

	return $output;
}

?>