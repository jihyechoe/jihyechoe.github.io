<?php

// -----------------------------------------
// semplice images for blocks
// -----------------------------------------

function get_semplice_image($id) {

	// get media json
	$media = file_get_contents(get_template_directory() . '/admin/editor/blocks/media.json');
	$media = json_decode($media, true);

	// get uri to assets
	$url = 'http://blocks.semplicelabs.com/v4/images/';
	
	// return image
	if(strpos($id, 'svg') !== false) {
		return array(
			'url' => $url . $id,
			'type' => 'vector',
		);
	} else {
		return array(
			'url' => $url . $id,
			'type' => 'pixel',
			'width' => $media['images'][$id]['width'],
			'height' => $media['images'][$id]['height']
		);
	}
}

// -----------------------------------------
// get image
// -----------------------------------------

function semplice_get_image($id, $size) {
	// get image url
	$image = wp_get_attachment_image_src($id, $size, false);
	// is still there?
	if($image) {
		return $image[0];
	} else {
		return 'notfound';
	}
}

// -----------------------------------------
// get background image
// -----------------------------------------

function semplice_get_background_image($styles) {
	// background type
	if(isset($styles['background_type']) && $styles['background_type'] == 'vid') {
		// check if bg image
		if(isset($styles['bg_video_fallback']) && is_numeric($styles['bg_video_fallback'])) {
			return $styles['bg_video_fallback'] . ',';
		}
	} else {
		// check if fall back image
		if(isset($styles['background-image']) && is_numeric($styles['background-image'])) {
			return $styles['background-image'] . ',';
		}
	}
}

// -----------------------------------------
// get images thats being used in a module
// -----------------------------------------

function semplice_get_used_images($content) {
	// image
	$image = false;
	// get image
	if($content['module'] == 'video') {
		if(isset($content['options']['poster'])) {
			$image = $content['options']['poster'];
		}		
	} else if(!empty($content['content']['xl'])) {
		$image = $content['content']['xl'];
	}

	// check if gallery or normal image
	if(is_numeric($image)) {
		return $image . ',';
	} else if(is_array($image)) {
		return implode(',', $content['content']['xl']) . ',';
	}
}

// ----------------------------------------
// get admin images
// ----------------------------------------

function semplice_get_admin_images($ids) {

	$images = array();
	// iterate through images
	if(is_array($ids) && !empty($ids)) {
		// fetch all image urls in case they have chnaged (ex domain)
		foreach ($ids as $id => $url) {
			// get image
			$images[$id] = semplice_get_image($id, 'full');
		}
	}
	return $images;
}

?>