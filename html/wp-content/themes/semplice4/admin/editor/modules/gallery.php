<?php

// -----------------------------------------
// semplice
// admin/editor/modules/gallery/module.php
// -----------------------------------------

if(!class_exists('sm_gallery')) {
	class sm_gallery {

		public $output;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
		}

		// output editor
		public function output_editor($values, $id) {

			// default for editor
			$this->output['html'] = '<img class="is-content" src="' . get_template_directory_uri() . '/assets/images/admin/placeholders/gallery.png' . '" alt="gallery-placeholder">';

			// return output
			return $this->output;
		}

		// output frtonend
		public function output_frontend($values, $id) {
			
			// output
			$output = '';

			// attributes
			extract( shortcode_atts(
				array(
					'images'				=> '',
					'width'					=> 'grid-width',
					'autoplay'				=> false,
					'adaptive_height'		=> 'true',
					'animation'				=> 'sgs-crossfade',
					'timeout' 				=> 4000,
					'arrows_visibility'		=> 'true',
					'pagination_visibility'	=> 'false',
					'arrows_color'			=> '#ffffff',
					'pagination_color'		=> '#000000',
					'pagination_position'	=> 'below',
					'infinite'				=> 'false',
				), $values['options'] )
			);

			// autoplay?
			if($autoplay == 'true' && is_numeric($timeout)) {
				$autoplay = $timeout;
			} else {
				$autoplay = 'false';
			}

			$images = $values['content']['xl'];
			
			if(is_array($images)) {

				$output .= '<div id="gallery-' . $id . '" class="semplice-gallery-slider ' . $animation . ' pagination-' . $pagination_position . ' sgs-pagination-' . $pagination_visibility . '">';

				foreach($images as $image) {
				
					$img = wp_get_attachment_image_src($image, 'full');
					
					$output .= '<div class="sgs-slide ' . $width . '">';
					$output .= '<img src="' . $img[0] . '" alt="gallery-image"/>';
					$output .= '</div>';
				}
				
				$output .= '</div>';

				// custom css for nav and pagination
				$this->output['css'] = '#gallery-' . $id . ' .flickity-prev-next-button .arrow { fill: ' . $arrows_color . ' !important; }#gallery-' . $id . ' .flickity-page-dots .dot { background: ' . $pagination_color . ' !important; }';
				
				$output .='
					<script>
						(function($) {
							$(document).ready(function () {
								$("#gallery-' . $id . '").flickity({
									autoPlay: ' . $autoplay . ',
									adaptiveHeight: ' . $adaptive_height . ',
									prevNextButtons: ' . $arrows_visibility . ',
									pageDots: ' . $pagination_visibility . ',
									wrapAround: ' . $infinite . ',
									percentPosition: true,
									imagesLoaded: true,
									arrowShape: { 
										x0: 10,
										x1: 60, y1: 50,
										x2: 65, y2: 45,
										x3: 20
									},
									pauseAutoPlayOnHover: false,
								});
							});
						})(jQuery);
					</script>
				';
			} else {
				$output .= '<div class="empty-gallery">Your gallery has no images yet.</div>';
			}

			// save output
			$this->output['html'] = $output;

			return $this->output;
		}
	}
	// instance
	$this->module['gallery'] = new sm_gallery;
}