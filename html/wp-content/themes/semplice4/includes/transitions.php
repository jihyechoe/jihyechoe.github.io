<?php

// -----------------------------------------
// semplice
// includes/transitions.php
// -----------------------------------------
	
$transition_atts = array(
	'options' => array(
		'status'	=> 'disabled',
		'preset'	=> 'fade',
		// enabled scrollToTop per default
		'scrollToTop'  => 'enabled',
	),
	'presets' => array(
		'fade' => array(
			'in' => array(
				'effect'   		=> 'fadeIn',
				'position' 		=> 'normal',
				'visibility'	=> 'transition-hidden',
				'ease' 	   		=> 'Linear',
				'duration' 		=> .35,
			),
			'out' => array(
				'effect'   		=> 'fadeOut',
				'position' 		=> 'normal',
				'visibility'	=> 'transition-hidden',
				'ease' 	   		=> 'Linear',
				'duration' 		=> .35,
			),
		),
		'rightToLeft' => array(
			'in' => array(
				'effect'   		=> 'moveRightToLeft',
				'position' 		=> 'right',
				'to'			=> '-100%',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.2,
			),
			'out' => array(
				'effect'   		=> 'moveRightToLeft',
				'position' 		=> 'normal',
				'to'			=> '-100%',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.3,
			),
		),
		'leftToRight' => array(
			'in' => array(
				'effect'   		=> 'moveLeftToRight',
				'position' 		=> 'left',
				'to'			=> '100%',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.2,
			),
			'out' => array(
				'effect'   		=> 'moveLeftToRight',
				'position' 		=> 'normal',
				'to'			=> '100%',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.3,
			),
		),
		'topToBottom' => array(
			'in' => array(
				'effect'   		=> 'moveTopToBottom',
				'position' 		=> 'top',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.2,
			),
			'out' => array(
				'effect'   		=> 'moveTopToBottom',
				'position' 		=> 'normal',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.3,
			),
		),
		'bottomToTop' => array(
			'in' => array(
				'effect'   		=> 'moveBottomToTop',
				'position' 		=> 'bottom',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.2,
			),
			'out' => array(
				'effect'   		=> 'moveBottomToTop',
				'position' 		=> 'normal',
				'visibility'	=> '',
				'ease' 	   		=> 'Expo.easeInOut',
				'duration' 		=> 1.3,
			),
		),
	),
);