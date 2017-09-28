<?php

// -----------------------------------------
// semplice
// /admin/navigations.php
// -----------------------------------------

if(!class_exists('navigations')) {
	class navigations {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// output
			$output = 'content';

			return $output;
		}

		// get navigation
		public function get($mode, $nav_id, $is_editor, $is_crawler) {

			// vars
			global $post;
			$output = array(
				'html' => '',
				'css'  => ''
			);
			$hide_menu = false;

			// presets
			$presets = array(
				'logo_left_menu_right' => 'preset_one',
				'logo_left_menu_left' => 'preset_two',
				'logo_right_menu_left' => 'preset_three',
				'logo_right_menu_right' => 'preset_four',
				'logo_middle_menu_sides' => 'preset_five',
				'logo_middle_menu_stacked' => 'preset_six',
				'logo_hidden_menu_middle' => 'preset_seven',
				'logo_left_menu_vertical_right' => 'preset_eight',
				'logo_middle_menu_corners' => 'preset_nine',
				'logo_middle_menu_vertical_left_right' => 'preset_ten'
			);

			// get navigation json
			$navigations = json_decode(get_option('semplice_customize_navigations'), true);

			// get post settings
			if(!$is_editor) {
				// just getting all the navs for the frontend
				if(!$is_crawler) {
					if(is_object($post)) {
						$post_settings = json_decode(get_post_meta($post->ID, '_semplice_post_settings', true), true);
					} else {
						$post_settings = '';
					}
					// default navigation
					if (is_array($post_settings) && isset($post_settings['meta']['navbar']) && isset($navigations[$post_settings['meta']['navbar']])) {
						// check if nav is still available
						$navigation = $navigations[$post_settings['meta']['navbar']];	
					} else if(is_array($navigations) && isset($navigations['default'])) {
						$navigation = $navigations[$navigations['default']];
					} else {
						$navigation = 'default';
					}
				} else {
					$navigation = $navigations[$nav_id];
				}
			} else {
				$navigation = $nav_id;
			}

			// hide menu?
			if(isset($post_settings) && is_array($post_settings)) {
				if(isset($post_settings['meta']['navbar_visibility']) && $post_settings['meta']['navbar_visibility'] == 'false') {
					$hide_menu = true;
				}
			}

			// check if navigation is array, otherwise do nothing because its just the semplice standard nav
			if(true !== $hide_menu) {
				if(is_array($navigation)) {

					// -----------------------------------------	
					// CSS / NAVBAR
					// -----------------------------------------

					// navbar setings
					$navbar_width = 'grid';

					// bg color
					$output['css'] .= '.' . $navigation['id'] . ' { ' . $this->get_bg_color($navigation, 'navbar') . '; }';

					// height
					if(isset($navigation['navbar_height'])) {
						$output['css'] .= '.' . $navigation['id'] . ' { height: ' . $navigation['navbar_height'] . '; }';
						// first section margin
						$output['css'] .= '.is-frontend #content-holder .sections { margin-top: ' . $navigation['navbar_height'] . '; }';
					}

					// padding ver
					if(isset($navigation['navbar_padding_vertical'])) {
						$output['css'] .= '.' . $navigation['id'] . ' { padding-top: ' . $navigation['navbar_padding_vertical'] . '; padding-bottom: ' . $navigation['navbar_padding_vertical'] . '; }';
					}

					if(isset($navigation['navbar_type']) && $navigation['navbar_type'] == 'container-fluid') {
						// padding left
						if(isset($navigation['navbar_padding'])) {
							$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .navbar-left { left: ' . $navigation['navbar_padding'] . ';}';
							$output['css'] .= '.' . $navigation['id'] . ' > div > .navbar-inner .navbar-right { right: ' . $navigation['navbar_padding'] . '; }';
						}
					}

					// -----------------------------------------	
					// CSS / LOGO
					// -----------------------------------------

					// textlogo
					if(!isset($navigation['logo_type']) || isset($navigation['logo_type']) && $navigation['logo_type'] == 'text') {
						// text color
						if(isset($navigation['logo_text_color'])) {
							$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .logo a { color: ' . $navigation['logo_text_color'] . '; }';
						}
						// font size
						if(isset($navigation['logo_text_fontsize'])) {
							$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .logo a { font-size: ' . $navigation['logo_text_fontsize'] . '; }';
						}
						// text transform
						if(isset($navigation['logo_text_text_transform'])) {
							$output['css'] .= '.logo a { text-transform: ' . $navigation['logo_text_text_transform'] . '; }';
						}
						// letter spacing
						if(isset($navigation['logo_text_letter_spacing'])) {
							$output['css'] .= '.logo a { letter-spacing: ' . $navigation['logo_text_letter_spacing'] . '; }';
						}
					}

					// img logo
					if(isset($navigation['logo_type']) && $navigation['logo_type'] == 'img') {
						if(isset($navigation['logo_img_width'])) {
							$output['css'] .= '.' . $navigation['id'] . ' .logo img, .' . $navigation['id'] . ' .logo svg { width: ' . $navigation['logo_img_width'] . '; }';
						}
					}

					// vert alignment
					if(isset($navigation['logo_alignment'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .logo { align-items: ' . $navigation['logo_alignment'] . '; }';
					}


					// -----------------------------------------	
					// CSS / HAMBURGER
					// -----------------------------------------

					$hamburger_width = 24;
					$hamburger_thickness = 2;
					$hamburger_padding = 6;
					$color = '#000000';
				
					// alignment
					if(isset($navigation['hamburger_alignment'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger { align-items: ' . $navigation['hamburger_alignment'] . '; }';
					}

					// color
					if(isset($navigation['hamburger_color'])) {
						$color = $navigation['hamburger_color'];
					}

					// width
					if(isset($navigation['hamburger_width'])) {
						$hamburger_width = $navigation['hamburger_width'];
					}

					// thickness
					if(isset($navigation['hamburger_thickness'])) {
						$hamburger_thickness = $navigation['hamburger_thickness'];
					}

					// padding
					if(isset($navigation['hamburger_padding'])) {
						$hamburger_padding = $navigation['hamburger_padding'];
					}
					
					// calc height
					$hamburger_height = $hamburger_thickness + ($hamburger_padding * 2);

					// hamburger color
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.menu-icon span { background-color: ' . $color . '; }';
					// hamburger width
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.menu-icon { width: ' . $hamburger_width . '; }';
					// one line thickness
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.menu-icon span { height: ' . $hamburger_thickness . 'px; }';
					// hamburger padding
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.open-menu span::before { transform: translateY(-' . $hamburger_padding . 'px); }';
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.open-menu span::after { transform: translateY(' . $hamburger_padding . 'px); }';
					// hover
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.open-menu:hover span::before { transform: translateY(-' . ($hamburger_padding + 2) . 'px); }';
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.open-menu:hover span::after { transform: translateY(' . ($hamburger_padding + 2) . 'px); }';
					// height
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.menu-icon { height: ' . $hamburger_height . 'px; }';
					// margin top
					$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger a.menu-icon span { margin-top: ' . ($hamburger_height / 2) . 'px; }';

					// is hamburger nav?
					if(isset($navigation['menu_type']) && $navigation['menu_type'] == 'hamburger') {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .hamburger { display: flex; }';
					}

					// -----------------------------------------	
					// CSS / MENU
					// -----------------------------------------

					// fontsize
					if(isset($navigation['menu_fontsize'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a span { font-size: ' . $navigation['menu_fontsize'] . '; }';
					}

					// font color
					if(isset($navigation['menu_color'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a span { color: ' . $navigation['menu_color'] . '; }';
					}

					// padding
					if(isset($navigation['menu_padding'])) {
						// get int val
						$hor_menu_padding = floatval(str_replace('rem', '', $navigation['menu_padding']));
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a { padding: 0rem ' . ($hor_menu_padding / 2) . 'rem; }';
					}

					// text transform
					if(isset($navigation['menu_text_transform'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a span { text-transform: ' . $navigation['menu_text_transform'] . '; }';
					}

					// text transform
					if(isset($navigation['menu_letter_spacing'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a span { letter-spacing: ' . $navigation['menu_letter_spacing'] . '; }';
					}

					// border width
					if(isset($navigation['menu_border'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a span { border-bottom-width: ' . $navigation['menu_border'] . '; }';
					}

					// border color
					if(isset($navigation['menu_border_color'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a span { border-bottom-color: ' . $navigation['menu_border_color'] . '; }';
					}

					// border padding
					if(isset($navigation['menu_border_padding'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a span { padding-bottom: ' . $navigation['menu_border_padding'] . '; }';
					}

					// menu alignment
					if(isset($navigation['menu_alignment'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav.standard ul { align-items: ' . $navigation['menu_alignment'] . '; }';
					}

					// menu mouseover color
					if(isset($navigation['menu_mouseover_color'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a:hover span, .navbar-inner nav ul li.current-menu-item a span, .navbar-inner nav ul li.current_page_item a span { color: ' . $navigation['menu_mouseover_color'] . '; }';
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li.current-menu-item a span { color: ' . $navigation['menu_mouseover_color'] . '; }';
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li.current_page_item a span { color: ' . $navigation['menu_mouseover_color'] . '; }';
						$output['css'] .= '.single-project .navbar-inner nav ul li.portfolio-grid a span { color: ' . $navigation['menu_mouseover_color'] . '; }';
					}

					// menu mouseover border
					if(isset($navigation['menu_border_mouseover_color'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li a:hover span { border-bottom-color: ' . $navigation['menu_border_mouseover_color'] . '; }';
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li.current-menu-item a span { border-bottom-color: ' . $navigation['menu_border_mouseover_color'] . '; }';
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner nav ul li.current_page_item a span { border-bottom-color: ' . $navigation['menu_border_mouseover_color'] . '; }';
						$output['css'] .= '.single-project .navbar-inner nav ul li.portfolio-grid a span { border-bottom-color: ' . $navigation['menu_border_mouseover_color'] . '; }';
					}
					
					// -----------------------------------------	
					// CSS / OVERLAY
					// -----------------------------------------

					// overlay bg color
					$output['css'] .= '#overlay-menu { ' . $this->get_bg_color($navigation, 'overlay') . ' }';

					// overlay padding top
					if(isset($navigation['overlay_padding_top']) && isset($navigation['overlay_alignment_ver'])) {
						if($navigation['overlay_alignment_ver'] == 'align-top') {
							$output['css'] .= '#overlay-menu .overlay-menu-inner nav { padding-top: ' . $navigation['overlay_padding_top'] . '; }';
						}
					}

					// overlay padding
					if(isset($navigation['overlay_type']) && $navigation['overlay_type'] == 'container-fluid') {
						
						// overlay padding left
						if(isset($navigation['overlay_padding_left'])) {
							$overlay_padding_left = '#overlay-menu .overlay-menu-inner [data-justify="left"] ul li a span { left: ' . $navigation['overlay_padding_left'] . '; }';
						}

						// overlay padding right
						if(isset($navigation['overlay_padding_right'])) {
							$overlay_padding_right = '#overlay-menu .overlay-menu-inner [data-justify="right"] ul li a span { right: ' . $navigation['overlay_padding_right'] . '; }';
						}
					}

					// hor alignment
					if(isset($navigation['overlay_alignment_hor'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav { text-align: ' . $navigation['overlay_alignment_hor'] . '; }';

						// padding left
						if(isset($overlay_padding_left) && $navigation['overlay_alignment_hor'] == 'left') {
							$output['css'] .= $overlay_padding_left;
						}

						// padding right
						if(isset($overlay_padding_right) && $navigation['overlay_alignment_hor'] == 'right') {
							$output['css'] .= $overlay_padding_right;
						}
					}

					// fontsize
					if(isset($navigation['overlay_fontsize'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a span { font-size: ' . $navigation['overlay_fontsize'] . '; }';
					}

					// link color
					if(isset($navigation['overlay_color'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a span { color: ' . $navigation['overlay_color'] . '; }';
					}

					// items padding
					if(isset($navigation['overlay_padding'])) {
						$overlay_padding = str_replace('rem', '', $navigation['overlay_padding']);
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a { padding: ' . $overlay_padding / 2 . 'rem 0rem; }';
					}

					// text transform
					if(isset($navigation['overlay_text_transform'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a span { text-transform: ' . $navigation['overlay_text_transform'] . '; }';
					}

					// letter spacing
					if(isset($navigation['overlay_letter_spacing'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a span { letter-spacing: ' . $navigation['overlay_letter_spacing'] . '; }';
					}

					// border oclor
					if(isset($navigation['overlay_border_color'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a span { border-bottom-color: ' . $navigation['overlay_border_color'] . '; }';
					}

					// border width
					if(isset($navigation['overlay_border'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a span { border-bottom-width: ' . $navigation['overlay_border'] . '; }';
					}

					// border padding
					if(isset($navigation['overlay_border_padding'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a span { padding-bottom: ' . $navigation['overlay_border_padding'] . '; }';
					}

					// menu mouseover color
					if(isset($navigation['overlay_mouseover_color'])) {
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li a:hover span { color: ' . $navigation['overlay_mouseover_color'] . '; }';
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li.current-menu-item a span { color: ' . $navigation['overlay_mouseover_color'] . '; }';
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li.current_page_item a span { color: ' . $navigation['overlay_mouseover_color'] . '; }';
						$output['css'] .= '.single-project #overlay-menu .overlay-menu-inner nav ul li.portfolio-grid a span { color: ' . $navigation['overlay_mouseover_color'] . '; }';
					}

					// menu mouseover border
					if(isset($navigation['overlay_border_mouseover_color'])) {
						$output['css'] .= '#overlay-menu nav ul li a:hover span { border-bottom-color: ' . $navigation['overlay_border_mouseover_color'] . '; }';
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li.current-menu-item a span { border-bottom-color: ' . $navigation['overlay_border_mouseover_color'] . '; }';
						$output['css'] .= '#overlay-menu .overlay-menu-inner nav ul li.current_page_item a span { border-bottom-color: ' . $navigation['overlay_border_mouseover_color'] . '; }';
						$output['css'] .= '.single-project #overlay-menu .overlay-menu-inner nav ul li.portfolio-grid a span { border-bottom-color: ' . $navigation['overlay_border_mouseover_color'] . '; }';
					}

					// -----------------------------------------	
					// CSS / PRESET TWO
					// -----------------------------------------

					if(isset($navigation['logo_padding_right'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .navbar-left .logo { padding-right: ' . $navigation['logo_padding_right'] . '; }';
					}

					// -----------------------------------------	
					// CSS / PRESET FOUR
					// -----------------------------------------

					if(isset($navigation['logo_padding_left'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .navbar-right .logo { padding-left: ' . $navigation['logo_padding_left'] . '; }';
					}

					// -----------------------------------------	
					// CSS / PRESET SIX
					// -----------------------------------------

					if(isset($navigation['logo_margin_bottom'])) {
						$output['css'] .= '.' . $navigation['id'] . ' .navbar-inner .navbar-center .logo { margin-bottom: ' . $navigation['logo_margin_bottom'] . '; }';
					}

					// -----------------------------------------	
					// HTML
					// -----------------------------------------

					// html default settings
					$nav_settings = $this->default_nav_settings();

					// sticky?
					if(isset($navigation['navbar_mode']) && $navigation['navbar_mode'] == 'normal') {
						$nav_settings['navbar_mode'] = 'non-sticky-nav'; 
					}

					// navbar opacity
					if(isset($navigation['navbar_bg_opacity']) && $navigation['navbar_bg_opacity'] < 1) {
						$nav_settings['navbar_bg_opacity'] = $navigation['navbar_bg_opacity'];
					}

					// add id to navsettings
					if(isset($navigation['id'])) {
						$nav_settings['id'] = $navigation['id'];
					} else {
						$nav_settings['id'] = $navigation['preset'];
					}
					
					// set editor
					if($is_editor) {
						$nav_settings['is_editor'] = true;
					}

					// navbar type
					if(isset($navigation['navbar_type'])) {
						$nav_settings['navbar_type'] = $navigation['navbar_type'];
					}

					// navbar transparent while in cover
					if(isset($navigation['navbar_cover_transparent'])) {
						$nav_settings['navbar_cover_transparent'] = $navigation['navbar_cover_transparent'];
					}

					// navbar bg visility in overlay
					if(isset($navigation['navbar_bg_visibility_overlay'])) {
						$nav_settings['navbar_bg_visibility_overlay'] = $navigation['navbar_bg_visibility_overlay'];
					}

					// menu type
					if(isset($navigation['menu_type'])) {
						$nav_settings['menu_type'] = $navigation['menu_type'];
					}

					// mobile fallback
					if(isset($navigation['menu_mobile_fallback'])) {
						$nav_settings['menu_mobile_fallback'] = $navigation['menu_mobile_fallback'];
					}

					// navbar type
					if(isset($navigation['overlay_type'])) {
						$nav_settings['overlay_type'] = $navigation['overlay_type'];
					}

					// logo
					if(isset($navigation['logo_type']) && $navigation['logo_type'] == 'img') {
						if(isset($navigation['logo_img'])) {
							// show logo and not found if not in the library anymore
							$logo_img = wp_get_attachment_image_src($navigation['logo_img'], 'full', false);

							if($logo_img) {
								$nav_settings['logo'] = '<img src="' . $logo_img[0] . '" alt="logo">';
							} else {
								$nav_settings['logo'] = 'No image found';
							}
							
						} else if(isset($navigation['logo_svg'])) {
							$nav_settings['logo'] = $navigation['logo_svg'];
						} else {
							$nav_settings['logo'] = 'bild gewählt aber weder url noch svg vorhaden';
						}
					} else {
						if(isset($navigation['logo_text'])) {
							$nav_settings['logo'] = $navigation['logo_text'];
						}
						if(isset($navigation['logo_text_font_family'])) {
							$nav_settings['logo_font_family'] .= ' data-font="' . $navigation['logo_text_font_family'] . '"';
						}
					}

					// navbar font family
					if(isset($navigation['menu_font_family'])) {
						$nav_settings['menu_font_family'] .= ' data-font="' . $navigation['menu_font_family'] . '"';
					}

					// overlay font family
					if(isset($navigation['overlay_font_family'])) {
						$nav_settings['overlay_font_family'] .= ' data-font="' . $navigation['overlay_font_family'] . '"';
					}

					// overlay vert alignment
					if(isset($navigation['overlay_alignment_ver'])) {
						$nav_settings['overlay_alignment_ver'] = $navigation['overlay_alignment_ver'];
					}

					// overlay hor alignment
					if(isset($navigation['overlay_alignment_hor'])) {
						$nav_settings['overlay_alignment_hor'] = $navigation['overlay_alignment_hor'];
					}

					// get nav html template
					$output['html'] .= $this->get_preset($presets[$navigation['preset']], $nav_settings);

				} else {
					// html default settings
					$nav_settings = $this->default_nav_settings();
					// get nav html template
					$output['html'] .= $this->get_preset('preset_one', $nav_settings);
				}
			}

			if($mode != 'both') {
				return $output[$mode];
			} else {
				return $output;
			}
		}

		// get background color		
		public function get_bg_color($navigation, $type) {
			$bg_color = array(
				'r' => 245,
				'g' => 245,
				'b' => 245
			);
			$bg_opacity = 1;

			// bg color
			if(isset($navigation[$type . '_bg_color'])) {
				if($navigation[$type . '_bg_color'] != 'transparent') {
					$bg_color = semplice_hex_to_rgb($navigation[$type . '_bg_color']);
				} else if($navigation[$type . '_bg_color'] == 'transparent') {
					$bg_color = 'transparent';
				}	
			}

			// bg opacity
			if(isset($navigation[$type . '_bg_opacity'])) {
				$bg_opacity = $navigation[$type . '_bg_opacity'];
			}

			if($bg_color == 'transparent') {
				return 'background-color: transparent;';
			} else {
				return 'background-color: rgba(' . $bg_color['r'] . ', ' . $bg_color['g'] . ', ' . $bg_color['b'] . ', ' . $bg_opacity . ');';
			}
		}

		// default nav settings
		public function default_nav_settings() {
			return array(
				'id'							=> 'create-nav',
				'is_editor'						=> false,
				'navbar_type' 					=> 'container',
				'navbar_cover_transparent'		=> 'disabled',
				'navbar_bg_visibility_overlay'  => 'visible',
				'navbar_mode'					=> 'sticky-nav',
				'navbar_bg_opacity'				=> 1,
				'menu_type'						=> 'text',
				'menu_mobile_fallback'			=> 'enabled',
				'overlay_type'					=> 'container',
				'overlay_alignment_ver' 		=> 'align-middle',
				'overlay_alignment_hor' 		=> 'center',
				'overlay_font_family'			=> '',
				'logo'		  					=> get_bloginfo('name'),
				'logo_font_family'				=> '',
				'menu_font_family'				=> '',
			);
		}

		// get menu html
		public function get_nav_menu($mode, $menu_font, $is_editor, $alignment, $menu_class) {

			// first check if our menu location has a menu assigned
			if(has_nav_menu('semplice-main-menu')) {
				// ´get menu
				$menu = wp_nav_menu(
					array(
						'theme_location' => 'semplice-main-menu',
						'echo' => false,
						'container' => false,
						'fallback_cb' => false,
						'menu_class' => $menu_class,
						'link_before' => '<span>',
						'link_after' => '</span>'
					)
				);
				// are there any items in our nav?
				if(empty($menu)) {
					$menu = wp_page_menu(
						array(
							'echo' => false,
							'menu_class' => $menu_class,
							'link_before' => '<span>',
							'link_after' => '</span>'
						)
					);
				}
			} else {
				$menu = wp_page_menu(
					array(
						'echo' => false,
						'menu_class' => $menu_class,
						'link_before' => '<span>',
						'link_after' => '</span>'
					)
				);
			}

			// nav
			$nav = '<nav class="standard' . $alignment . '"' . $menu_font . '>' . $menu . '</nav>';

			// hamburger
			if($mode != 'hamburger' || $is_editor) {
				if($mode == 'menu-only') {
					return $menu;
				} else {
					return $nav;
				}
			}
		}

		// get hamburger
		public function get_hamburger($alignment, $menu_type) {
			// return tasty hamburger
			return '<div class="hamburger' . $alignment . ' semplice-menu"><a class="open-menu menu-icon"><span></span></a></div>';
		}

		// get nav overlay
		public function get_nav_overlay($nav_settings) {
			return '
				<div id="overlay-menu">
					<div class="overlay-menu-inner" data-xl-width="12">
						<nav class="overlay-nav" data-justify="' . $nav_settings['overlay_alignment_hor'] . '" data-align="' . $nav_settings['overlay_alignment_ver'] . '"' . $nav_settings['overlay_font_family'] . '>
							' . $this->get_nav_menu('menu-only', false, false, false, $nav_settings['overlay_type']) . '
						</nav>
					</div>
				</div>
			';
		}

		// get logo
		public function get_logo($alignment, $nav_settings) {
			// return logo
			return '<div class="logo' . $alignment . '"' . $nav_settings['logo_font_family'] . '><a href="' . home_url() . '" title="' . get_bloginfo('blog-title') . '">' .  $nav_settings['logo'] . '</a></div>';
		}

		// header start
		public function get_header_start($nav_settings) {
			// vars
			$classes = ' menu-type-' . $nav_settings['menu_type'];
			$mobile_fallback = '';
			// transparent class
			if($nav_settings['navbar_cover_transparent'] == 'enabled') {
				$classes .= ' cover-transparent';
			}
			// scroll to
			if($nav_settings['navbar_bg_opacity'] < 1) {
				$classes .= ' scroll-to-top';
			}
			// only show mobile fallback option if text nav is enabled
			if($nav_settings['menu_type'] == 'text') {
				$mobile_fallback = 'data-mobile-fallback="' . $nav_settings['menu_mobile_fallback'] . '"';
			}
			// return header start
			return '<header class="' . $nav_settings['id'] . ' semplice-navbar active-navbar ' . $nav_settings['navbar_mode'] . $classes . '" data-cover-transparent="' . $nav_settings['navbar_cover_transparent'] . '" data-bg-overlay-visibility="' . $nav_settings['navbar_bg_visibility_overlay'] . '"' . $mobile_fallback . '>';
		}

		public function get_navbar_inner($nav_settings) {
			// navbar inner
			return '<div class="navbar-inner menu-type-' . $nav_settings['menu_type'] . '" data-xl-width="12" data-navbar-type="' . $nav_settings['navbar_type'] . '">';
		}

		// presets
		public function get_preset($preset, $nav_settings) {

			// output
			$html = '';

			switch($preset) {
				case 'preset_one':
					$html .= '
						' . $this->get_header_start($nav_settings) . '
							<div class="' . $nav_settings['navbar_type'] . '" data-nav="logo-left-menu-right">
								' . $this->get_navbar_inner($nav_settings) . '
									' . $this->get_logo(' navbar-left', $nav_settings) . '
									' . $this->get_nav_menu($nav_settings['menu_type'], $nav_settings['menu_font_family'], $nav_settings['is_editor'], ' navbar-right', 'menu') . '
									' . $this->get_hamburger(' navbar-right', $nav_settings['menu_type']) . '
								</div>
							</div>
						</header>
						' . $this->get_nav_overlay($nav_settings) . '
					';
				break;
				case 'preset_two':
					$html .= '
						' . $this->get_header_start($nav_settings) . '
							<div class="' . $nav_settings['navbar_type'] . '" data-nav="logo-left-menu-left">
								' . $this->get_navbar_inner($nav_settings) . '
									<div class="navbar-left">
										' . $this->get_logo('', $nav_settings) . '
										' . $this->get_nav_menu($nav_settings['menu_type'], $nav_settings['menu_font_family'], $nav_settings['is_editor'], '', 'menu') . '
									</div>
									' . $this->get_hamburger(' navbar-right', $nav_settings['menu_type']) . '
								</div>
							</div>
						</header>
						' . $this->get_nav_overlay($nav_settings) . '
					';
				break;
				case 'preset_three':
					$html .= '
						' . $this->get_header_start($nav_settings) . '
							<div class="' . $nav_settings['navbar_type'] . '" data-nav="logo-right-menu-left">
								' . $this->get_navbar_inner($nav_settings) . '
									' . $this->get_nav_menu($nav_settings['menu_type'], $nav_settings['menu_font_family'], $nav_settings['is_editor'], ' navbar-left', 'menu') . '
									' . $this->get_hamburger(' navbar-left', $nav_settings['menu_type']) . '
									' . $this->get_logo(' navbar-right', $nav_settings) . '
								</div>
							</div>
						</header>
						' . $this->get_nav_overlay($nav_settings) . '
					';
				break;
				case 'preset_four':
					$html .= '
						' . $this->get_header_start($nav_settings) . '
							<div class="' . $nav_settings['navbar_type'] . '" data-nav="logo-right-menu-right">
								' . $this->get_navbar_inner($nav_settings) . '
									' . $this->get_hamburger(' navbar-left', $nav_settings['menu_type']) . '
									<div class="navbar-right">
										' . $this->get_nav_menu($nav_settings['menu_type'], $nav_settings['menu_font_family'], $nav_settings['is_editor'], '', 'menu') . '
										' . $this->get_logo('', $nav_settings) . '
									</div>
								</div>
							</div>
						</header>
						' . $this->get_nav_overlay($nav_settings) . '
					';
				break;
				case 'preset_six':
					$html .= '
						' . $this->get_header_start($nav_settings) . '
							<div class="' . $nav_settings['navbar_type'] . '" data-nav="logo-middle-menu-stacked">
								' . $this->get_navbar_inner($nav_settings) . '
									' . $this->get_hamburger(' navbar-right', $nav_settings['menu_type']) . '
									<div class="navbar-center">
										' . $this->get_logo('', $nav_settings) . '
										' . $this->get_nav_menu($nav_settings['menu_type'], $nav_settings['menu_font_family'], $nav_settings['is_editor'], '', 'menu') . '
									</div>
								</div>
							</div>
						</header>
						' . $this->get_nav_overlay($nav_settings) . '
					';
				break;
			}

			// return html
			return $html;
		}
	}

	// instance
	$this->customize['navigations'] = new navigations;
}

?>
