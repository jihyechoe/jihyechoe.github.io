<?php

// -----------------------------------------
// semplice
// admin/atts/modules/image.php
// -----------------------------------------

$image = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,2,1,1,1,1,1,2',
		'image' => array(
			'title'			=> 'Image Upload',
			'size'			=> 'span2',
			'data-input-type'	=> 'admin-image-upload',
			'default'		=> '',
			'data-is-content' => true,
			'class'			=> 'listen-hidden',
			'data-upload'	=> 'contentImage',
		),
		'width' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Width',
			'size'		 => 'span2',
			'class'      => 'listen',
			'data-target'=> '.is-content',
			'default' 	 => 'original',
			'help'		 => '\'Original\' means that the image will not get scaled unless its to big for the grid. If you choose \'Grid Width\' your image will always get scaled to match the grid width.',
			'select-box-values' => array(
				'grid-width' => 'Grid Width',
				'original'		 => 'Original',
			),
		),
		'align' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Align',
			'size'		 => 'span2',
			'class'      => 'listen',
			'data-target'=> '.ce-image',
			'default' 	 => 'left',
			'help'		 => 'Only works if your image is not bigger than the grid.',
			'select-box-values' => array(
				'left' 		=> 'Left',
				'center'	=> 'Center',
				'right'		=> 'Right'
			),
		),
		'image_link_type' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link Type',
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => 'url',
			'data-visibility-switch' 	=> true,
			'data-visibility-values' 	=> 'url,page,project,post',
			'data-visibility-prefix'	=> 'ov-img-link',
			'select-box-values' => array(
				'url' => 'Url',
				'page'		 => 'Page',
				'project'	 => 'Project',
				'post'		 => 'Blog post',
			),
		),
		'image_link' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'Link',
			'size'		 	=> 'span4',
			'placeholder'	=> 'http://www.google.com',
			'default'		=> '',
			'class'			=> 'listen-save',
			'style-class'	=> 'ov-img-link-url',
		),
		'image_link_page' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link to page',
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => '',
			'select-box-values' => semplice_get_post_dropdown('page'),
			'style-class'	=> 'ov-img-link-page',
		),
		'image_link_project' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link to project',
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => '',
			'select-box-values' => semplice_get_post_dropdown('project'),
			'style-class'	=> 'ov-img-link-project',
		),
		'image_link_post' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link to blog post',
			'size'		 => 'span4',
			'class'      => 'listen-save',
			'default' 	 => '',
			'select-box-values' => semplice_get_post_dropdown('post'),
			'style-class'	=> 'ov-img-link-post',
		),
		'image_link_target' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link Target',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => '_blank',
			'select-box-values' => array(
				'_blank'	 => 'New Tab',
				'_self' 	 => 'Same Tab',
			),
		),
		'lightbox' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Lightbox',
			'size'		 => 'span2',
			'class'      => 'listen-save',
			'default' 	 => 'no',
			'switch-values' => array(
				'no'	 => 'No',
				'yes' 	 => 'Yes',
			),
		),
		/*
		'scaling' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Mobile Scaling',
			'help'		 => 'If activated the image will not get scaled to match the content width on mobile devices. It will only get scaled if its bigger than the content width, but will never get enlarged.',
			'size'		 => 'span2',
			'class'      => 'listen',
			'default' 	 => 'no',
			'data-target'=> '.is-content',
			'switch-values' => array(
				'no'	 => 'No',
				'yes' 	 => 'yes',
			),
		),
		*/
	),
);

?>