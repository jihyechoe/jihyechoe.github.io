<?php

// -----------------------------------------
// semplice
// admin/editor/modules/video/module.php
// -----------------------------------------

if(!class_exists('sm_video')) {
	class sm_video {

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

			// values
			extract( shortcode_atts(
				array(
					'hide_controls'			=> '',
					'transparent_controls'  => '',
					'cover'					=> '',
				), $values['options'] )
			);

			$this->output['html'] = '
				<div class="ce-video" data-hide-controls="' . $hide_controls . '" data-transparent-controls="' . $transparent_controls . '">
					<img src="' . get_template_directory_uri() . '/assets/images/admin/placeholders/video.png' . '" class="is-content" alt="video-placeholder" data-object-fit="' . $cover . '">
				</div>
			';

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// values
			extract( shortcode_atts(
				array(
					'video_url'				=> '',
					'poster' 	    		=> '',
					'loop' 					=> '',
					'muted'					=> '',
					'autoplay'				=> '',
					'hide_controls'			=> '',
					'transparent_controls'  => '',
					'ratio'					=> '',
					'cover'					=> '',
				), $values['options'] )
			);

			// get content
			$content = $values['content']['xl'];

			// get src
			if(!empty($content)) {
				// is numeric and id? if not use old format
				if(is_numeric($content)) {
					$src = wp_get_attachment_url($content);
				} else {
					$src = $content;
				}
			} else {
				$src = $video_url;
			}

			// get video type
			$type = substr($src, -3);

			if($type == 'ogv') {
				$type = 'ogg';
			} elseif ($type == 'ebm') {
				$type = 'webm';
			}

			// set video dim to false per default
			$video_dim = false;

			// poster image
			if(!empty($poster)) {
				// get image src
				$poster = wp_get_attachment_image_src($poster, 'full');
				$poster = 'poster="' . $poster[0] . '"';
			}
			
			// aspect ratio
			if(!empty($ratio)) {
				$video_dim = explode(':', $ratio);
				$video_dim = 'width="' . $video_dim[0] . '" height="' . $video_dim[1] . '"';
			}

			// attributes
			$attributes = array(
				'loop' => $loop,
				'autoplay' => $autoplay,
				'muted' => $muted,
			);

			// define video atts
			$video_atts = '';

			foreach ($attributes as $attribute => $value) {
				if($value == 'on') {
					$video_atts .= $attribute . ' ';
				}
			}

			$this->output['html'] = '
				<div class="ce-video" data-hide-controls="' . $hide_controls . '" data-transparent-controls="' . $transparent_controls . '" style="width: 100%; max-width: 100%">
					<video class="video is-content" ' . $video_dim . ' preload="none" ' . $poster . ' ' . $video_atts . '">
						<source src="' . $src . '" type="video/' . $type . '">
						<p>If you are reading this, it is because your browser does not support the HTML5 video element.</p>
					</video>
				</div>
			';

			// output
			return $this->output;
		}
	}

	// instance
	$this->module['video'] = new sm_video;
}