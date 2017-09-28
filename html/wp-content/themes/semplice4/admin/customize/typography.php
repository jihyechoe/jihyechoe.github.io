<?php

// -----------------------------------------
// semplice
// /admin/typography.php
// -----------------------------------------

if(!class_exists('typography')) {
	class typography {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// output air
			$output = $this->get('html', true);

			return $output;
		}

		// get css
		public function get($mode, $is_admin) {

			// vars
			global $post;
			$output = array(
				'html' => '',
				'css'  => '',
			);
			$fonts = array();

			// get navigation json
			$typography = json_decode(get_option('semplice_customize_typography'), true);

			// has changes?
			if(is_array($typography)) {
				$options = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');

				foreach ($options as $attribute) {

					// set default to fonts array
					$fonts[$attribute] = '';

					// is paragraph?
					if($attribute == 'p') {
						$attribute_css = 'p, #content-holder li';
					} else {
						$attribute_css = $attribute;
					}

					// prefix
					if($is_admin) {
						$prefix = '#content-holder ' . $attribute_css . ', .typography ' . $attribute . ' { ';
					} else {
						$prefix = '#content-holder ' . $attribute_css . ' { ';
					}

					// is customization on?
					if(isset($typography[$attribute . '_customize']) && $typography[$attribute . '_customize'] == 'on' || $attribute == 'p') {
						// attribute css
						$attr_css = '';
						// font family
						if(isset($typography[$attribute . '_font_family'])) {
							// add font to array
							$fonts[$attribute] = ' data-font="' . $typography[$attribute . '_font_family'] . '"';
						}
						// font size
						if(isset($typography[$attribute . '_font_size'])) {
							$attr_css .= 'font-size: ' . $typography[$attribute . '_font_size'] . ';';
						}
						// line height
						if(isset($typography[$attribute . '_line_height'])) {
							$attr_css .= 'line-height: ' . $typography[$attribute . '_line_height'] . ';';
						}
						// letter spacing
						if(isset($typography[$attribute . '_letter_spacing'])) {
							$attr_css .= 'letter-spacing: ' . $typography[$attribute . '_letter_spacing'] . ';';
						}
						// is empty?
						if(!empty($attr_css)) {
							// css open
							$output['css'] .= $prefix;
							// add attr css
							$output['css'] .= $attr_css;
							// css close
							$output['css'] .= '}';
						}
					}
				}

				// change margin bottom of the paragraph
				if(isset($typography['p_line_height'])) {
					$output['css'] .= '#content-holder .is-content p { margin-bottom: ' . $typography['p_line_height'] . 'em; }';
				}
			} else {
				$fonts = array(
					'h1' => '',
					'h2' => '',
					'h3' => '',
					'h4' => '',
					'h5' => '',
					'h6' => '',
					'p'  => '',
				);
			}

			// html
			$output['html'] = $this->get_html($fonts);

			// add mobile scaling to css
			$output['css'] .= $this->mobile_scaling($typography, $is_admin);

			return $output[$mode];
		}

		// html
		public function get_html($fonts) {
			return '
				<div class="heading-previews">
					<div class="heading-preview">
						<p class="preview-label">Heading H1</p>
						<h1 class="preview-h1"' . $fonts['h1'] . '>The quick brown fox<br />jumps over the lazy dog.</h1>
					</div>
					<div class="heading-preview">
						<p class="preview-label">Heading H2</p>
						<h2 class="preview-h2"' . $fonts['h2'] . '>The quick brown fox<br />jumps over the lazy dog.</h2>
					</div>
					<div class="heading-preview">
						<p class="preview-label">Heading H3</p>
						<h3 class="preview-h3"' . $fonts['h3'] . '>The quick brown fox<br />jumps over the lazy dog.</h3>
					</div>
					<div class="heading-preview">
						<p class="preview-label">Heading H4</p>
						<h4 class="preview-h4"' . $fonts['h4'] . '>The quick brown fox<br />jumps over the lazy dog.</h4>
					</div>
					<div class="heading-preview">
						<p class="preview-label">Heading H5</p>
						<h5 class="preview-h5"' . $fonts['h5'] . '>The quick brown fox<br />jumps over the lazy dog.</h5>
					</div>
					<div class="heading-preview">
						<p class="preview-label">Heading H6</p>
						<h6 class="preview-h6"' . $fonts['h6'] . '>The quick brown fox<br />jumps over the lazy dog.</h6>
					</div>
				</div>
				<div class="other-previews is-content">
					<p class="preview-label">H1 / Paragraph Combination</p>
					<h1 class="preview-h1"' . $fonts['h1'] . '>The quick brown fox<br />jumps over the lazy dog.</h1>
					<p class="preview-paragraph"' . $fonts['p'] . '>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.</p>
					<p class="preview-paragraph"' . $fonts['p'] . '>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
					<p class="preview-paragraph"' . $fonts['p'] . '>Capitalise on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</p>
				</div>
			';
		}

		// mobile scaling
		public function mobile_scaling($typography, $is_admin) {
			// output start
			$output = '';

			// get typography settings
			$typography = json_decode(get_option('semplice_customize_typography'), true);

			// breakpoints
			$breakpoints = array(
				'lg' => '@media screen and (min-width: 992px) and (max-width: 1169px) { ',
				'md' => '@media screen and (min-width: 768px) and (max-width: 991px) { ',
				'sm' => '@media screen and (min-width: 544px) and (max-width: 767px) { ',
				'xs' => '@media screen and (max-width: 543px) { ',
			);

			// values
			$defaults = array(
				'h1' => array(
					'size'  => 42,
					'lh'	=> 54,
					'lg' 	=> .92,
					'md' 	=> .86,
					'sm' 	=> .82,
					'xs' 	=> .78,
				),
				'h2' => array(
					'size'	=> 36,
					'lh'	=> 48,
					'lg' 	=> .92,
					'md' 	=> .88,
					'sm' 	=> .84,
					'xs'	=> .80,
				),
				'h3' => array(
					'size'	=> 28,
					'lh'	=> 36,
					'lg' 	=> .96,
					'md' 	=> .92,
					'sm' 	=> .90,
					'xs' 	=> .88,
				),
				'h4' => array(
					'size'	=> 24,
					'lh'	=> 36,
					'lg' 	=> .96,
					'md' 	=> .92,
					'sm' 	=> .90,
					'xs' 	=> .88,
				),
				'h5' => array(
					'size'	=> 20,
					'lh'	=> 32,
					'lg' 	=> 1,
					'md' 	=> 1,
					'sm' 	=> 1,
					'xs' 	=> 1,
				),
				'h6' => array(
					'size'	=> 18,
					'lh'	=> 30,
					'lg' 	=> 1,
					'md' 	=> 1,
					'sm' 	=> 1,
					'xs' 	=> 1,
				),
			);

			// loop through
			foreach ($breakpoints as $breakpoint => $prefix) {

				// empty atts
				$atts = '';

				// is editor
				if($is_admin) {
					$attr_prefix = '[data-breakpoint="' . $breakpoint . '"] #content-holder ';
				} else {
					// prefix
					$attr_prefix = '#content-holder ';
				}

				// loop throught defaults
				foreach ($defaults as $attribute => $values) {

					// default size
					$size = $values['size'];
					$lh   = $values['lh'];
					
					// default multiplier
					$multiplier = $values[$breakpoint];

					// check if user has a size set in typography
					if(isset($typography[$attribute . '_font_size'])) {
						$size = str_replace('rem', '', $typography[$attribute . '_font_size']) * 18;
					}

					// check if user has a line height set in typography
					if(isset($typography[$attribute . '_line_height'])) {
						$lh = str_replace('rem', '', $typography[$attribute . '_line_height']) * 18;;
					}

					// calculate
					$size = $size * $multiplier;
					$lh   = $lh * $multiplier;

					// add to output
					$atts .= $attr_prefix . $attribute . ' { font-size: ' . round($size / 18, 2) . 'rem; line-height: ' . round($lh / 18, 2) . 'rem; }';
				}

				// output start
				if($is_admin) {
					$output .= $atts;
				} else {
					$output .= $prefix . $atts . '}';
				}
			}

			// return
			return $output;
		}
	}

	// instance
	$this->customize['typography'] = new typography;
}

?>