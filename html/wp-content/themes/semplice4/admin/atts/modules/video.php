<?php

// -----------------------------------------
// semplice
// admin/atts/modules/video.php
// -----------------------------------------

$video = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,1,2,1,1,1,1,1',
		'video' => array(
			'title'			=> 'Video Upload',
			'size'			=> 'span4',
			'data-input-type' => 'video-upload',
			'default'		=> '',
			'data-is-content' => true,
			'class'			=> 'listen-hidden',
			'data-upload'	=> 'contentVideo',
		),
		'video_url' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'Video Url',
			'help'			=> 'If your video is to big for a upload into the WordPress media library or you just want to include it from an external source (like a cdn), you can paste the link here.',
			'size'		 	=> 'span4',
			'placeholder'	=> 'http://my.cdn.com/video.mp4',
			'default'		=> '',
			'class'			=> 'listen-save',
		),
		'poster' => array(
			'title'			=> 'Poster',
			'size'			=> 'span2',
			'data-input-type'	=> 'editor-image-upload',
			'default'		=> '',
			'class'			=> 'listen-hidden',
		),
		'ratio' => array(
			'data-input-type' 	=> 'input-text',
			'title'				=> 'Aspect Ratio',
			'size'				=> 'span2',
			'class'     		=> 'listen-save',
			'default' 	 		=> '',
			'placeholder'		=> 'Example: 16:9',
			'help'				=> 'If you experience black bars (mostly with non 16:9 aspect ratios), please add your aspect ratio here. Examples: 16:9. You can even just use your resolution like: 1280:720. (don\'t forget the colon between width and height)',
		),
		'autoplay' => array(
			'data-input-type' => 'onoff-switch',
			'style-class'=> 'first-switch',
			'title'		 => 'Autoplay',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'loop' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Loop Video',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'muted' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Muted',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'transparent_controls' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Transparent Controls',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'data-target'=> '.is-content',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'hide_controls' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Hide Controls',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'data-target'=> '.is-content',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
	),
);

?>