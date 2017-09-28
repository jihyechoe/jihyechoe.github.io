<?php

// -----------------------------------------
// semplice
// admin/editor/modules/gallerygrid/module.php
// -----------------------------------------

if(!class_exists('sm_gallerygrid')) {

	class sm_gallerygrid {

		public $output;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
		}

		// output frontend
		public function output_editor($values, $id) {

			// extract options
			extract( shortcode_atts(
				array(
					'col'				=> 4,
					'target'			=> 'lightbox',
					'random'			=> 'disabled',
					'hor_gutter'		=> 30,
					'ver_gutter'		=> 30,
					'mouseover'			=> 'none',
					'mouseover_color'	=> '#000000',
					'mouseover_opacity'	=> '1',
				), $values['options'])
			);

			// get images
			$images = $values['content']['xl'];

			// generate items
			$masonry_items = '';

			// random
			if($random !== 'disabled') {
				$col_array = explode('.', $random);
				$small_col = $col_array[0];
				$big_col   = $col_array[1];
			}

			if(!function_exists('HexToRGB')) {
				// hex to rgb
				function HexToRGB($hex) {
					$hex = str_replace("#", "", $hex);
					$color = array();
					 
					if(strlen($hex) == 3) {
						$color['r'] = hexdec(substr($hex, 0, 1) . $r);
						$color['g'] = hexdec(substr($hex, 1, 1) . $g);
						$color['b'] = hexdec(substr($hex, 2, 1) . $b);
					}
					else if(strlen($hex) == 6) {
						$color['r'] = hexdec(substr($hex, 0, 2));
						$color['g'] = hexdec(substr($hex, 2, 2));
						$color['b'] = hexdec(substr($hex, 4, 2));
					}
					 
					return $color;
				}
			}


			// index
			$index = 0;

			// get shots
			if(is_array($images) && !empty($images)) {

				foreach ($images as $image) {

					// get image
					$img = wp_get_attachment_image_src($image, 'full');

					// mouseover
					if($mouseover == 'color') {
						if(strpos($mouseover_color, '#') !== false) {
							$rgba = HexToRGB($mouseover_color);
							$mouseover_html = '<div class="gg-hover" style="background: rgba(' . $rgba['r'] . ', ' . $rgba['g'] . ', ' . $rgba['b'] . ', ' . ($mouseover_opacity / 100) . ');"></div>';
						} else {
							$mouseover_html = '';
						}
					} elseif($mouseover == 'shadow') {
						$mouseover_html = '<div class="gg-hover" style="box-shadow: 0px 0px 50px rgba(0,0,0,' . ($mouseover_opacity / 100) . ');"></div>';
					} else {
						$mouseover_html = '';
					}

					// image html
					if($target == 'lightbox') {
						$image = '<a class="semplice-lightbox gallerygrid-image mouseover-' . $mouseover . '"><img class="lightbox-item" src="' . $img[0] . '" width="' . $img[1] . '" height="' . $img[2] . '">' . $mouseover_html . '</a>';
					} else {
						$image = '<a class="mouseover-' . $mouseover . '"><img src="' . $img[0] . '" width="' . $img[1] . '" height="' . $img[2] . '">' . $mouseover_html . '</a>';
					}
					
					if($random !== 'disabled' && $index % 4 == 0 && $index > 0) {
						$col = $big_col;
					} elseif($random !== 'disabled') {
						$col = $small_col;
					}
					
					// add thumb to holder
					$masonry_items .= '
						<div class="masonry-item thumb masonry-' . $id . '-item" data-xl-width="' . $col . '" data-sm-width="6" data-xs-width="12">
						' . $image . '
						</div>
					';
					
					// increment index
					$index ++;
				}

				// get masonry
				$this->output['html'] = semplice_masonry($id, $masonry_items, $hor_gutter, $ver_gutter, '');
			} else {
				// no images
				$this->output['html'] = '
					<div class="gallerygrid-error">
						' . get_svg('backend', '/icons/module_gallerygrid') . '
						<div class="content">
							<p>No images added yet.</p>
							<a class="semplice-button green-button">Add images</a>
						</div>
					</div>
				';
			}

			// output
			return $this->output;			
		}

		// output frontend
		public function output_frontend($values, $id) {
			// same as editor
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['gallerygrid'] = new sm_gallerygrid;
}