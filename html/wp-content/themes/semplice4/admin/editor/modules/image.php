<?php

// -----------------------------------------
// semplice
// admin/editor/modules/image/module.php
// -----------------------------------------

if(!class_exists('sm_image')) {
	class sm_image {

		public $output;
		public $is_frontend;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			// is frontend
			$this->is_frontend = false;
		}

		// output editor
		public function output_editor($values, $id) {
			// get image id
			$image_id = $values['content']['xl'];

			// extract options
			extract( shortcode_atts(
				array(
					'width'				=> 'original',
					'align'				=> 'left',
					'lightbox'			=> 'no',
					'scaling'			=> 'no',
					'image_link' 		=> '',
					'image_link_type'	=> 'url',
					'image_link_page'	=> '',
					'image_link_project'=> '',
					'image_link_post'	=> '',
					'image_link_target' => '_blank',
				), $values['options'] )
			);

			// get image
			if(!empty($image_id)) {
				// is an id or a url from an semplice block?
				if(is_numeric($image_id)) {
					// get img
					$attachment = wp_get_attachment_image_src($image_id, 'full', false);
					// is image?
					if($attachment) {
						// get ext
						$ext = substr($attachment[0], -3);  
						// check if svg
						if($ext != 'svg') {
							// set img src
							$image = array(
								'src' 		=> $attachment[0],
								'width' 	=> $attachment[1],
								'height' 	=> $attachment[2],
							);
						} else {
							$image = array(
								'src'		=> $attachment[0],
							);
						}
						// get img meta
						$image['alt'] = get_post_meta($image_id, '_wp_attachment_image_alt', true);
						// check if alt text is available
						if(empty($image['alt'])) {
							$image['alt'] = get_the_title($image_id);
						}
					} else {
						$image = array(
							'src' 		=> get_template_directory_uri() . '/assets/images/admin/preview_notfound.svg',
							'width' 	=> 500,
							'height'	=> 500,
							'alt'		=> 'Image not found',
						);
					}
					
				} else {
					// get semplice image
					$semplice_image = get_semplice_image($image_id);
					// is svg?
					if($semplice_image['type'] == 'vector') {
						$image = array(
							'src' 		=> $semplice_image['url'],
							'alt'		=> 'Blocks image',
						);
					} else {
						$image = array(
							'src' 		=> $semplice_image['url'],
							'width' 	=> $semplice_image['width'],
							'height'	=> $semplice_image['height'],
							'alt'		=> 'Blocks image',
						);
					}
				}
			} else {
				$image = array(
					'src' 		=> get_template_directory_uri() . '/assets/images/admin/placeholders/image.png',
					'width' 	=> 2340,
					'height'	=> 1316,
					'alt'		=> 'Default image',
				);
			}			

			// check if lightbox item
			$lightbox_item = '';
			if($lightbox == 'yes') {
				$lightbox_item = ' lightbox-item';
			}

			// image html
			$image_html = '<img class="is-content' . $lightbox_item . '" ' . $this->get_image_atts($image) . ' data-width="' . $width . '" data-scaling="' . $scaling . '">';

			// image link
			$image_link = array(
				'type'		=> $image_link_type,
				'url'		=> $image_link,
				'page'		=> $image_link_page,
				'project'  	=> $image_link_project,
				'post'		=> $image_link_post,
			);

			// temporaray output without link and lightbox
			$this->output['html'] = '<div class="ce-image" data-align="' . $align . '">' . $this->wrap_hyperlink($image_html, $lightbox, $image_link, $image_link_target) . '</div>';
			
			// output
			return $this->output;
		}

		// output frtonend
		public function output_frontend($values, $id) {
			// set is frontend
			$this->is_frontend = true;
			// same as editor
			return $this->output_editor($values, $id);
		}

		// get image
		public function get_image_atts($attributes) {
			// output
			$output = '';
			// iterate img
			foreach ($attributes as $attribute => $value) {
				$output .= ' ' . $attribute . '="' . $value . '"';
			}
			// return
			return $output;
		}

		// wrap hyperlink
		public function wrap_hyperlink($image, $lightbox, $link, $target) {
			if($this->is_frontend) {
				if($lightbox == 'yes') {
					return '<a class="semplice-lightbox">' . $image . '</a>';
				} else if($link['type'] == 'url' && !empty($link['url'])) {
					return '<a href="' . $link['url'] . '" target="' . $target . '">' . $image . '</a>';
				} else if($link['type'] != 'url') {
					if(!empty($link[$link['type']])) {
						return '<a href="' . get_permalink($link[$link['type']]) . '" target="' . $target . '">' . $image . '</a>';
					} else {
						return $image;
					}
				} else {
					return $image;
				}
			} else {
				return $image;
			}
		}
	}
	// instance
	$this->module['image'] = new sm_image;
}