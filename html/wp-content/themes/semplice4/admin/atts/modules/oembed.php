<?php

// -----------------------------------------
// semplice
// admin/atts/modules/oembed.php
// -----------------------------------------

$oembed = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,2',
		'url' => array(
			'title'				=> 'oEmbed Link',
			'size'				=> 'span4',
			'data-input-type'	=> 'input-text',
			'data-is-content'	=> true,
			'default'			=> '',
			'placeholder'		=> 'Example: https://vimeo.com/101874310',
			'class'				=> 'listen-save',
		),
		'type' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Media Type',
			'size'		 		=> 'span2',
			'class'      		=> 'listen-save',
			'default' 	 		=> 'video',
			'select-box-values' => array(
				'video' 		=> 'Video',
				'other'			=> 'Other',
			),
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
	),
);

?>