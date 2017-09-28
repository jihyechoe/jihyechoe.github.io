<?php

// -----------------------------------------
// semplice
// /admin/customize/advanced.php
// -----------------------------------------

if(!class_exists('advanced')) {
	class advanced {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// return output
			return '';
		}

		// generate css
		public function generate_css($is_frontend) {

			// output
			$advanced_css = '';

			// get advanced content
			$advanced = json_decode(get_option('semplice_customize_advanced'), true);

			// is array?
			if(is_array($advanced)) {

				// text color
				if(isset($advanced['text_color'])) {
					$advanced_css .= '.is-content { color: ' . $advanced['text_color'] . '; }';
				}

				// text color
				if(isset($advanced['link_color'])) {
					$advanced_css .= 'a { color: ' . $advanced['link_color'] . '; }';
				}

				// text color
				if(isset($advanced['mouseover_color'])) {
					$advanced_css .= 'a:hover { color: ' . $advanced['mouseover_color'] . '; }';
				}

				// global custom css
				if($is_frontend) {
					if(isset($advanced['custom_css_global']) && !empty($advanced['custom_css_global'])) {
						$advanced_css .= $advanced['custom_css_global'];
					}
					// get breakpoints
					$breakpoints = array(
						'xl' => '@media screen and (min-width: 1170px)', 
						'lg' => '@media screen and (min-width: 992px) and (max-width: 1169px)', 
						'md' => '@media screen and (min-width: 768px) and (max-width: 991px)', 
						'sm' => '@media screen and (min-width: 544px) and (max-width: 767px)', 
						'xs' => '@media screen and (max-width: 543px)',
					);
					// loop through breakpoints
					foreach ($breakpoints as $breakpoint => $query) {
						if(isset($advanced['custom_css_' . $breakpoint]) && !empty($advanced['custom_css_' . $breakpoint])) {
							$advanced_css .= $query . '{' . $advanced['custom_css_' . $breakpoint] . '}';
						}
					}

					// progress bar
					if(!empty($advanced['progress_bar'])) {
						$advanced_css .= '#nprogress .bar { background: ' . $advanced['progress_bar'] . '; }';
					}	

					// top arrow color
					if(!empty($advanced['top_arrow_color'])) {
						$advanced_css .= '.back-to-top a svg { fill: ' . $advanced['top_arrow_color'] . '; }';
					}

					// password font color
					if(!empty($advanced['password_color'])) {
						$advanced_css .= '.post-password-form p, .post-password-form p a.post-password-submit, .post-password-form input[type=submit] { color: ' . $advanced['password_color'] . '; }';
					}

					// password border color
					if(!empty($advanced['password_border'])) {
						$advanced_css .= '.post-password-form p a.post-password-submit, .post-password-form p input[type=submit], .post-password-form p label input { border-color: ' . $advanced['password_border'] . '; }';
					}
				}
			}
			
			// output
			return $advanced_css;
		}
	}

	// instance
	$this->customize['advanced'] = new advanced;
}

?>