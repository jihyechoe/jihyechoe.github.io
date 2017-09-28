<?php

// -----------------------------------------
// semplice
// admin/atts/modules/instagram.php
// -----------------------------------------

$instagram = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,2,2,2',
		'masonry' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Preview',
			'button-title'		=> 'Refresh Feed',
			'help'				=> 'If you are happy with your settings, just press the \'Refresh Feed\' button to generate a new preview with your updated settings.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button regenerate-masonry',
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
			'help'			=> 'The number of recent images you can display. The limit is 33 images. This limit is defined by Instagram and not Semplice.',
			'default'		=> 20,
			'min'			=> 1,
			'max'			=> 30,
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
			'size'		 => 'span2',
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
			'button-title'		=> 'Disconnect Instagram',
			'help'				=> 'In case you don\'t need instagram anymore or want to change / renew your account you can disconnect your account here.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button white-button remove-token',
		),
	),
);

?>