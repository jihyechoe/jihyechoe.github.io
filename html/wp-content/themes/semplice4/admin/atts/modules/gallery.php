<?php

// -----------------------------------------
// semplice
// admin/atts/modules/gallery.php
// -----------------------------------------

$gallery = array(
	'uploads' => array(
		'title' => 'Upload Images',
		'break' => '1',
		'data-hide-mobile' => true,
		'images' => array(
			'title'				=> 'Images',
			'hide-title'		=> true,
			'data-style-option' => true,
			'size'				=> 'span4',
			'data-input-type'	=> 'gallery-upload',
			'default'			=> '',
			'data-is-content' 	=> true,
			'class'				=> 'listen-save',
		),
	),
	'Options' => array(
		'title' => 'Images',
		'break' => '2,2,2',
		'data-hide-mobile' => true,
		'width' => array(
			'data-input-type' => 'select-box',
			'title'		 	  => 'Width',
			'size'		 	  => 'span2',
			'class'     	  => 'listen-save',
			'default' 	 	  => 'grid-width',
			'help'		 	  => '\'Original\' means that the images will not get scaled unless they are to big for the grid. If you choose \'Grid Width\' your images will always get scaled to match the grid width.',
			'select-box-values' => array(
				'grid-width'	 => 'Grid Width',
				'original'		 => 'Original',
			),
		),
		'autoplay' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'AUtoplay',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => 'false',
			'switch-values' => array(
				'true'	 => 'On',
				'false'	 => 'Off',
			),
		),
		'animation' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Animation',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => 'sgs-crossfade',
			'switch-values' => array(
				'sgs-crossfade'	=> 'Fade',
				'sgs-slide'	 	=> 'Slide',
			),
		),
		'adaptive_height' => array(
			'data-input-type' => 'switch',
			'help'			  => 'If \'enabled\' the height of the gallery slider always adapts to the height of the active slide.',
			'switch-type'=> 'twoway',
			'title'		 => 'Adaptive Height',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => 'true',
			'switch-values' => array(
				'true'	 => 'On',
				'false'	 => 'Off',
			),
		),
		'timeout' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'Timeout',
			'size'		 	=> 'span2',
			'placeholder'	=> '4000',
			'default'		=> '4000',
			'class'			=> 'listen-save',
			'help'			=> 'This is the timeout betweent images in milliseconds. (minimum is 600ms)',
		),
		'infinite' => array(
			'data-input-type' => 'switch',
			'help'			  => 'If \'enabled\' and you reach the end of your slider your slides are getting re-attached so that it starts automatically with the first slide again. (same for the beginning. If you hit the previous button the last slide will be displayed)',
			'switch-type'=> 'twoway',
			'title'		 => 'Infinite Slider',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => 'false',
			'switch-values' => array(
				'false'	 => 'No',
				'true'	 => 'Yes',
			),
		),
	),
	'arrows' => array(
		'title' => 'Arrows',
		'break' => '2',
		'data-hide-mobile' => true,
		'arrows_color' => array(
			'title'				=> 'Color',
			'data-style-option' => true,
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> '#ffffff',
			'class'				=> 'color-picker liste-save',
		),
		'arrows_visibility' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Visibility',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => 'true',
			'switch-values' => array(
				'true'	 => 'Show',
				'false'  => 'Hide',
			),
		),
	),
	'pagination' => array(
		'title' => 'Pagination',
		'break' => '2,1',
		'data-hide-mobile' => true,
		'pagination_color' => array(
			'title'				=> 'Color',
			'data-style-option' => true,
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> '#000000',
			'class'				=> 'color-picker listen-save',
		),
		'pagination_visibility' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Visibility',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => 'false',
			'switch-values' => array(
				'true'	 => 'Show',
				'false'  => 'Hide',
			),
		),
		'pagination_position' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Position',
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => 'below',
			'switch-values' => array(
				'below'	 => 'Below Image',
				'above'  => 'Above Image',
			),
		),
	),
);

?>