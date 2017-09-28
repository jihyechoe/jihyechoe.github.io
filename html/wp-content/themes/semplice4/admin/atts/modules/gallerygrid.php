<?php

// -----------------------------------------
// semplice
// admin/atts/modules/gallerygrid.php
// -----------------------------------------

$gallerygrid = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,1,2,2,1',
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
		'masonry' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Preview',
			'button-title'		=> 'Refresh Grid',
			'help'				=> 'If you are happy with your settings, just press the \'Refresh Grid\' button to generate a new preview with your updated settings.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button white-button regenerate-masonry',
		),
		'hor_gutter' => array(
			'title'			=> 'Horizontal Gutter',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'			=> 'listen-save',
		),
		'ver_gutter' => array(
			'title'			=> 'Vertical Gutter',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'			=> 'listen-save',
		),
		'col' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Images per Row',
			'size'		 		=> 'span2',
			'class'      		=> 'listen-save',
			'default' 	 		=> '3',
			'select-box-values' => array(
				'12' 			=> '1 Image',
				'6' 			=> '2 Images',
				'4' 			=> '3 Images',
				'3' 			=> '4 Images',
				'2' 			=> '6 Images',
				'1' 			=> '12 Images',
			),
		),
		'random' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Random Grid',
			'size'		 		=> 'span2',
			'class'      		=> 'listen-save',
			'default' 	 		=> 'disabled',
			'help'				=> 'This feature will overwrite the \'Images per row\' setting.',
			'select-box-values' => array(
				'disabled'		=> 'Disabled',
				'2.4' 			=> 'Small: 2 Col, Big: 4 Col',
				'3.6' 			=> 'Small: 3 Col, Big: 6 Col',
				'4.8' 			=> 'Small: 4 Col, Big: 8 Col',
			),
		),
		'target' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Lightbox',
			'help'		 => 'If you want your images to be opened in Instagram, please choose \'No\'.',
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => 'lightbox',
			'switch-values' => array(
				'lightbox'	 => 'Yes',
				'no-lightbox'  => 'No',
			),
		),
	),
	'mouseover_options' => array(
		'title'  	 => 'Mouseover',
		'break'		 => '1,2',
		'data-hide-mobile' => true,
		'mouseover' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Mouseover',
			'size'		 		=> 'span4',
			'class'      		=> 'listen-save',
			'default' 	 		=> '3',
			'select-box-values' => array(
				'color'    => 'Color',
				'shadow'   => 'Shadow',
				'none'	   => 'None',
			),
		),
		'mouseover_color' => array(
			'title'			=> 'Color',
			'help'			=> 'Only applies for the color mouseover. Boxshadow is always black.',
			'size'			=> 'span2',
			'data-input-type'	=> 'color',
			'default'		=> 'transparent',
			'class'			=> 'color-picker admin-listen-handler',
			'data-handler'  => 'colorPicker',
		),
		'mouseover_opacity' => array(
			'title'			=> 'Opacity',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 100,
			'min'			=> 0,
			'max'			=> 100,
			'class'			=> 'listen-save',
		),
	),
);

?>