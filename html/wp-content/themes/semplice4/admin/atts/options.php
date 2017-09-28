<?php

// -----------------------------------------
// semplice
// admin/atts/options.php
// -----------------------------------------

$options = array(

	// section options
	'section' => array(
		'mobile-options' => '',
		'options' => array(
			'title'  => 'Options',
			'break'  => '2,2,1,1',
			'data-hide-mobile' => true,
			'layout' => array(
				'title'		 => 'Layout',
				'size'		 => 'span2',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'class' 	 => 'listen-layout',
				'default' 	 => 'grid',
				'switch-values' => array(
					'grid'	=> 'Grid',
					'fluid' => 'Fluid',
				),
			),
			'gutter' => array(
				'title'		 => 'Gutter',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'size'		 => 'span2',
				'class' 	 => 'listen-layout',
				'default' 	 => 'yes',
				'switch-values' => array(
					'yes'  => 'Keep',
					'no'   => 'Remove',
				),
			),
			'height' => array(
				'title'				=> 'height',
				'size'		 		=> 'span2',
				'data-input-type' 		=> 'select-box',
				'class' 			=> 'listen-layout',
				'default'		 	=> 'dynamic',
				'help'				=> '<b>Fullscreen</b> means that your section has a minimum height of 100% from your browser viewport. In order to keep the 100% height try not to add content that will exceed the height.',
				'data-visibility-switch' 	=> true,
				'data-visibility-values' 	=> 'dynamic,fullscreen,custom',
				'data-visibility-prefix'	=> 'ov-section-height',
				'select-box-values' => array(
					'dynamic'    => 'Dynamic',
					'fullscreen' => 'Fullscreen',
					'custom'	 => 'Custom'
				),
			),

			// height
			'custom-height' => array(
				'title'				=> 'Custom',
				'size'		 		=> 'span2',
				'data-input-type' 		=> 'range-slider',
				'data-target'		=> '.row',
				'min'				=> 0,
				'max'				=> 9999,
				'default'			=> 0,
				'class'				=> 'listen',
				'responsive'		=> true,
				'data-has-unit'		=> true,
				'style-class'		=> 'ov-section-height-custom',
				'data-range-slider' => 'customHeight',
			),
			'valign' => array(
				'title'		 => 'Vertical Align',
				'size'		 => 'span4',
				'data-input-type' => 'switch',
				'switch-type'=> 'fourway',
				'class' 	 => 'listen-layout',
				'default'	 => 'top',
				'switch-values' => array(
					'top'     => 'Top',
					'bottom'  => 'Bottom',
					'center'  => 'Center',
					'stretch' => 'Stretch',
				),
			),
			'justify' => array(
				'title'		 => 'Justify',
				'help'		 => 'First three options only take effect if you have free space in your section. (that means your column sizes are combined < 12) For the last two options you need at least 2 columns and the size of your columns is < 12',
				'size'		 => 'span4',
				'data-input-type' => 'switch',
				'switch-type'=> 'fiveway',
				'class' 	 => 'listen-layout',
				'default'	 => 'left',
				'switch-values' => array(
					'left'     		 => 'Left',
					'right'  		 => 'Right',
					'center' 		 => 'center',
					'space-between'  => 'Space Between',
					'space-around' 	 => 'Space Around'
				),
			),
		),
	),

	// column options
	'column' => array(
		'options' => array(
			'title'  => 'Options',
			'hide-title' => true,
			'valign' => array(
				'title'		 => 'Vertical Align',
				'help'		 => 'This option only takes effect if you set the section height to either \'Fullscreen\' or enter a \'custom height\' thats taller than your content and set the section vertical align to stretch. (last option)',
				'size'		 => 'span4',
				'data-input-type' => 'switch',
				'switch-type'=> 'fourway',
				'class' 	 => 'listen-layout',
				'default'	 => 'top',
				'switch-values' => array(
					'top'     => 'Top',
					'bottom'  => 'Bottom',
					'stretch' => 'Stretch',
					'center'  => 'Center',
				),
			),
		),
	),

	// content options, empty for the module options
	'content' => array(),

	// section options
	'cover' => array(
		'options' => array(
			'title'  => 'Options',
			'break'  => '2,1,1',
			'data-hide-mobile' => true,
			'layout' => array(
				'title'		 => 'Layout',
				'size'		 => 'span2',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'class' 	 => 'listen-layout',
				'default' 	 => 'grid',
				'switch-values' => array(
					'grid'	=> 'Grid',
					'fluid' => 'Fluid',
				),
			),
			'gutter' => array(
				'title'		 => 'Gutter',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'size'		 => 'span2',
				'class' 	 => 'listen-layout',
				'default' 	 => 'yes',
				'switch-values' => array(
					'yes'  => 'Keep',
					'no'   => 'Remove',
				),
			),
			'valign' => array(
				'title'		 => 'Vertical Align',
				'size'		 => 'span4',
				'data-input-type' => 'switch',
				'switch-type'=> 'fourway',
				'class' 	 => 'listen-layout',
				'default'	 => 'top',
				'switch-values' => array(
					'top'     => 'Top',
					'bottom'  => 'Bottom',
					'center'  => 'Center',
					'stretch' => 'Stretch',
				),
			),
			'justify' => array(
				'title'		 => 'Justify',
				'help'		 => 'First three options only take effect if you have free space in your section. (that means your column sizes are combined < 12) For the last two options you need at least 2 columns and the size of your columns is < 12',
				'size'		 => 'span4',
				'data-input-type' => 'switch',
				'switch-type'=> 'fiveway',
				'class' 	 => 'listen-layout',
				'default'	 => 'left',
				'switch-values' => array(
					'left'     		 => 'Left',
					'right'  		 => 'Right',
					'center' 		 => 'center',
					'space-between'  => 'Space Between',
					'space-around' 	 => 'Space Around'
				),
			),
		),
	),

	// responsive
	'responsive-lg' => get_responsive_options('lg', 'Desktop' ),
	'responsive-md' => get_responsive_options('md', 'Tablet Wide'),
	'responsive-sm' => get_responsive_options('sm', 'Tablet Portrait'),
	'responsive-xs' => get_responsive_options('xs', 'Phone'),
);

?>