<?php

// -----------------------------------------
// semplice
// admin/atts/modules/spacer.php
// -----------------------------------------

$spacer = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '4',
		'background-color' => array(
			'title'				=> 'Color',
			'data-style-option' => true,
			'size'				=> 'span1',
			'data-input-type'	=> 'color',
			'data-target'		=> '.spacer',
			'default'			=> 'transparent',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
		),
		'height' => array(
			'title'				=> 'Height',
			'data-style-option' => true,
			'size'				=> 'span1',
			'offset'			=> false,
			'data-input-type' 	=> 'range-slider',
			'data-target'		=> '.spacer',
			'default'			=> 10,
			'min'				=> 0,
			'max'				=> 999,
			'class'				=> 'listen',
			'data-has-unit' 	=> true,
		),
	),
);

?>