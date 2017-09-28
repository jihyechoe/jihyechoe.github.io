<?php

// -----------------------------------------
// semplice
// admin/editor/modules/instagram/module.php
// -----------------------------------------

if(!class_exists('sm_instagram')) {

	class sm_instagram {

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
					'count'				=> 20,
					'col'				=> 4,
					'target'			=> 'lightbox',
					'random'			=> 'disabled',
					'hor_gutter'		=> 30,
					'ver_gutter'		=> 30,
				), $values['options'] )
			);

			// get instagram token
			$instagram = json_decode(get_option('semplice_instagram_token'), true);

			// generate items
			$masonry_items = '';

			// get instagram json
			if(!function_exists('_isCurl')) {
				function _isCurl(){
				    return function_exists('curl_version');
				}
			}

			// if curl is installed get media
			if(_isCurl()) {
				$media = json_decode($this->exec_curl($instagram, $count), true);
				$meta = $media['meta'];
			} else {
				$media = 'curl';
			}

			// random
			if($random !== 'disabled') {
				$col_array = explode('.', $random);
				$small_col = $col_array[0];
				$big_col   = $col_array[1];
			}

			// index
			$index = 0;

			// get shots
			if(empty($instagram) && $media != 'curl' && !isset($values['is_frontend'])) {
				$this->output['html'] = '
					<div class="instagram-error">
						' . get_svg('backend', '/icons/module_instagram') . '
						<div class="content">
							<p>You are not connected yet.</p>
							<a href="https://instagram.com/oauth/authorize/?client_id=944a6351b93041c5a62a6e88d7acaed6&redirect_uri=http://redirect.semplicelabs.com/?uri=' . admin_url('admin.php?page=semplice-admin-instagram-auth') . '&response_type=token"  class="connect-instagram semplice-button green-button" target="_blank">Connect Instagram</a>
						</div>
					</div>
				';
			} else if(isset($meta['code']) && $meta['code'] == 200) {

				foreach ($media['data'] as $posts => $post) {

					if($post['type'] == 'image') {
						if($target == 'lightbox') {
							$href = $post['images']['standard_resolution']['url'];
							$href = explode('?', $href);
							$href = $href[0];
							$lightbox = true;
						} else {
							$href = $post['link'];
							$lightbox = false;
						}
						
						if($random !== 'disabled' && $index % 4 == 0 && $index > 0) {
							$col = $big_col;
						} elseif($random !== 'disabled') {
							$col = $small_col;
						}
						
						// add thumb to holder
						$masonry_items .= '
							<div class="masonry-item thumb masonry-' . $id . '-item" data-xl-width="' . $col . '" data-sm-width="6" data-xs-width="12">
								' . $this->wrap_hyperlink($post['images']['standard_resolution'], $href, $lightbox) . '
							</div>
						';
					}
					
					// increment index
					$index ++;

				}

				// get masonry
				$this->output['html'] = semplice_masonry($id, $masonry_items, $hor_gutter, $ver_gutter, '');
				
			} else if($media === 'curl') {
				$this->output['html'] = '
					<div class="instagram-error">
						<img src="' . get_svg('backend', '/icons/module_instagram') . '">
						<div class="content">
							<p>cURL Extension not installed. Please advise your host to install / activate the cURL Extension for you.</p>
						</div>
					</div>
				';
			} else {
				// only show connect button in the backend
				$connect_button = '';
				if(!isset($values['is_frontend'])) {
					$connect_button = '<a href="https://api.instagram.com/oauth/authorize/?client_id=944a6351b93041c5a62a6e88d7acaed6&redirect_uri=http://redirect.semplicelabs.com/?uri=' . admin_url('admin.php?page=semplice-admin-instagram-auth') . '&response_type=token" target="_blank" class="connect-instagram semplice-button green-button">Connect Instagram</a>';
				}
				$this->output['html'] = '
					<div class="instagram-error">
						' . get_svg('backend', '/icons/module_instagram') . '
						<div class="content">
							<p>Wrong or no access token.</p>
							' . $connect_button . '
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
			$values['is_frontend'] = true;
			return $this->output_editor($values, $id);
		}

		// wrap hyperlink
		public function wrap_hyperlink($image, $link, $lightbox) {
			if(true === $lightbox) {
				return '<a class="instagram-image semplice-lightbox"><img class="lightbox-item" src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" alt="instagram-image"></a>';
			} else {
				return '<a class="instagram-image" href="' . $link . '" target="_blank"><img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" alt="instagram-image"></a>';
			}
		}

		// curl
		public function exec_curl($options, $count) {
			
			// curl init
			$ch = curl_init();

			// url
			curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/users/' . $options['user_id'] . '/media/recent/?access_token=' . $options['access_token'] . '&count=' . $count);
			
			// disable ssl
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			// accept json
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Accept: application/json",
				"Content-Type: application/json"
			));
			
			// return content
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$response = curl_exec($ch);
			
			curl_close($ch);
			
			return $response;
		}
	}

	// instance
	$this->module['instagram'] = new sm_instagram;
}