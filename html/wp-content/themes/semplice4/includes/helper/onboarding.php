<?php

// -----------------------------------------
// is onboarding
// -----------------------------------------

function semplice_is_onboarding() {
	// get onboarding status
	$completed_onboarding = get_option('semplice_completed_onboarding');
	// return status
	if($completed_onboarding) {
		return false;
	} else {
		return true;
	}
}

// -----------------------------------------
// get onboarding
// -----------------------------------------

function semplice_get_onboarding($step) {

	// get html
	switch($step) {
		case 'start':
			$output = '
				<div class="welcome-title">
					<img src="' . get_template_directory_uri() . '/assets/images/admin/onboarding/welcome.svg" alt="onboarding-welcome">
				</div>
				<div class="content">
					<a class="onboarding-button lets-go" href="#onboarding/one">Let\'s go!</a>
				</div>
			';
		break;
		case 'one':
			$output = '
				<div class="heading">
					<div class="step-title">Website ID</div>
					<div class="hero-title"><img src="' . get_template_directory_uri() . '/assets/images/admin/onboarding/one_title.svg" alt="onboarding-title"></div>
				</div>
				<div class="content">
					<div class="left">
						<input type="text" name="name" class="admin-listen-handler" data-handler="onboarding" placeholder="Name your website, eg. Joe Doe">
						<input type="text" name="description" class="admin-listen-handler" data-handler="onboarding" placeholder="Website description, eg. Portfolio">
					</div>
					<div class="right browser-notice">
						<p>It will show up in the browser tab like this:</p>
						<img src="' . get_template_directory_uri() . '/assets/images/admin/onboarding/browser.png" alt="onboarding-browser">
					</div>
				</div>
				<div class="footer">
					<div class="step">
						<p>01<span>/02</span></p>
					</div>
					<div class="next">
						<a class="back-button" href="#onboarding/start">' . get_svg('backend', 'onboarding/back_arrow') . ' <span>Back</span></a>
						<a class="onboarding-button" href="#onboarding/two">Next</a> 
					</div>
				</div>
			';
		break;
		case 'two':
			$output = '
				<div class="heading">
					<div class="step-title">First Project</div>
					<div class="hero-title"><img src="' . get_template_directory_uri() . '/assets/images/admin/onboarding/three_title.svg" alt="onboarding-title"></div>
				</div>
				<div class="content">
					<div class="left">
						<input type="text" name="first_project" class="admin-listen-handler" data-handler="onboarding" placeholder="Name your project">
					</div>
					<div class="right">
						<div class="media-upload-box onboarding-upload-box">
							<a class="onboarding-upload-button upload-button admin-click-handler" data-handler="execute" data-action="upload" data-upload="onboarding" data-action-type="media" data-media-type="image" data-input-type="admin-image-upload" name="onboarding"><span>+</span> Add project thumbnail</a>
							<div class="image-preview-wrapper">
								<div class="edit-image">
									<ul>
										<li><a class="admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-upload="onboarding" name="onboarding" data-input-type="admin-image-upload">' . get_svg('backend', '/icons/icon_edit') . '</a></li>
										<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" name="onboarding">' . get_svg('backend', '/icons/icon_delete') . '</a></li>
									</ul>
								</div>
								<img class="image-preview" src="">
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<div class="step">
						<p>02<span>/02</span></p>
					</div>
					<div class="next">
						<a class="back-button" href="#onboarding/one">' . get_svg('backend', 'onboarding/back_arrow') . ' <span>Back</span></a>
						<a class="onboarding-button admin-click-handler" data-handler="execute" data-action-type="onboarding" data-action="finish">Finish</a> 
					</div>
				</div>
			';
		break;
	}

	// output
	return $output;
}

// -----------------------------------------
// first page
// -----------------------------------------

function semplice_first_page($post_id, $content) {
	
	// create array
	$page = array(
		'post_id' 		=> $post_id,
		'content'		=> '{"order":{"section_kb3god8ou":{"columns":{"column_z2clynthm":["content_g6nt8g63h"]},"row_id":"row_spc6vkgc0"}},"images":{},"branding":{},"content_g6nt8g63h":{"content":{"xl":""},"module":"portfoliogrid","options":{},"styles":{"xl":{}},"motions":{"active":[],"start":{},"end":{}}},"section_kb3god8ou":{"options":{},"layout":{"data-column-mode-sm":"single","data-column-mode-xs":"single"},"customHeight":{"xl":{"height":"15rem"}},"styles":{"xl":{}},"motions":{"active":[],"start":{},"end":{}}},"column_z2clynthm":{"width":{"xl":12},"options":{},"layout":{},"styles":{"xl":{}},"motions":{"active":[],"start":{},"end":{}}},"first_save":"yes","unpublished_changes":false}',
		'first_save'	=> 'yes',
		'post_settings' => array(
			'meta' => array(
				'post_title' => 'Work',
				'permalink' => sanitize_title('work'),
			),
		),
		'post_type'		=> 'page',
		'save_mode'		=> 'publish',
		'change_status'	=> 'yes',
		'post_password' => '',
		'used_fonts'	=> '',
	);

	// decode post settings
	$page['post_settings'] = json_encode($page['post_settings']);

	return $page;
}

// -----------------------------------------
// first project
// -----------------------------------------

function semplice_first_project($post_id, $content) {
	
	// create array
	$project = array(
		'post_id' 		=> $post_id,
		'content'		=> '{"order":{},"images":{"' . $content['thumbnail_id'] . '":"' . $content['thumbnail_url'] . '"},"branding":{},"first_save":"yes","unpublished_changes":false}',
		'first_save'	=> 'yes',
		'post_settings' => array(
			'thumbnail' => array(
				'image' => $content['thumbnail_id'],
				'width'	=> '4',
				'hover_visibility' => 'disabled',
			),
			'meta' => array(
				'post_title' => $content['first_project'],
				'permalink' => sanitize_title($content['first_project']),
			),
		),
		'post_type'		=> 'project',
		'save_mode'		=> 'publish',
		'change_status'	=> 'yes',
		'post_password' => '',
		'used_fonts'	=> '',
	);

	// decode post settings
	$project['post_settings'] = json_encode($project['post_settings']);

	return $project;
}

?>