<?php

// -----------------------------------------
// semplice
// admin/atts/modules/dribbble.php
// -----------------------------------------

$dribbble = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,1,2,2,1',
		'masonry' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Preview',
			'button-title'		=> 'Refresh Shots',
			'help'				=> 'If you are happy with your settings, just press the \'Refresh Feed\' button to generate a new preview with your updated settings.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button regenerate-masonry',
		),
		'dribbble_id' => array(
			'title'			=> 'Dribbble Username',
			'size'			=> 'span4',
			'offset'		=> false,
			'data-input-type' 	=> 'input-text',
			'help'			=> 'Enter your dribbble username',
			'placeholder'	=> 'Username',
			'default'		=> '',
			'class'			=> 'listen-save',
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
		'count' => array(
			'title'			=> 'Images',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'help'			=> 'Number of Images',
			'default'		=> 15,
			'min'			=> 1,
			'max'			=> 9999,
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
				'instagram'  => 'No',
			),
		),
		'disconnect' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Disconnect',
			'button-title'		=> 'Disconnect Dribbble',
			'help'				=> 'In case you don\'t need dribbble anymore or want to change / renew your account you can disconnect your account here.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button white-button remove-token',
		),
	),
);

?>