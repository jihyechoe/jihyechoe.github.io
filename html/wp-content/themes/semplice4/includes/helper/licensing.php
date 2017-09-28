<?php

// -----------------------------------------
// save license
// -----------------------------------------

function semplice_save_license($key, $product) {

	// get current license
	$current_license = json_decode(get_option('semplice_license'), true);

	// defaults
	$defaults = array('key', 'product', 'is_valid');

	// get current license
	foreach ($defaults as $attribute) {
		if(!isset($current_license[$attribute])) {
			$current_license[$attribute] = '';
		}
	}

	// only check license if no current or the input changed
	if(!$current_license['is_valid'] || empty($key) || $key != $current_license['key'] && $key != '****-****-****-****' || $product != $current_license['product']) {
		// check license
		$check_license = wp_remote_get('http://update.semplicelabs.com/update.php?key=' . $key . '&product=' . $product . '&action=check_key');

		if(!is_wp_error($check_license) && empty($check_license->errors)) {
			// get array
			$license = json_decode($check_license['body'], true);
			// check if license is valid
			if($license['license'] == 'valid') {
				// define output
				$output = array(
					'is_valid'  => true,
					'key'		=> $key,
					'name'		=> $license['name'],
					'product'	=> $product,
					'email'		=> $license['email'],
					'error'		=> false,
				);
				// add 
			} else {
				// set license to invalid
				$output = array('is_valid' => false);
			}
		} else {
			$output = array('error' => $check_license->get_error_message());
		}
		
	} else {
		$output = $current_license;
	}

	// save to admin
	update_option('semplice_license', json_encode($output));

	// return
	return $output;
}

// -----------------------------------------
// get license
// -----------------------------------------

function semplice_get_license() {

	// get current license
	$current_license = json_decode(get_option('semplice_license'), true);

	// check license
	if(is_array($current_license) && false !== $current_license['is_valid']) {
		$output = $current_license;
	} else {
		$output = false;
	}

	// return
	return $output;
}

// -----------------------------------------
// csemplice update check
// -----------------------------------------

function semplice_update_check() {
	
	// get license
	$license = semplice_get_license();

	// check license and theme folder
	$meta_data_url = 'http://update.semplicelabs.com/update_s4_' . semplice_theme('edition') . '.json';

	// is edition upgrade available?
	if(semplice_theme('edition') == 'single' && $license['product'] != 's4-single') {
		$meta_data_url = 'http://update.semplicelabs.com/update_s4_studio.json';
	}

	// get theme folder (without trailing slash)
	$theme_folder = get_template();

	// check if theme folder is correct and license is valid
	if($theme_folder == 'semplice4' && is_array($license) && true === $license['is_valid']) {
		// if everything is ok turn on auto update
		require get_template_directory() . '/includes/update.php';
			
		// new instance of themeupdatechecker
		$check_update = new ThemeUpdateChecker(
			'semplice4',
			$meta_data_url
		);

		// check for updates
		$check_update->checkForUpdates();
	}
}

// -----------------------------------------
// check if there is an update
// -----------------------------------------

function semplice_has_update() {

	// output array
	$output = array(
		'has_update' => false,
	);

	// get license
	$license = semplice_get_license();

	// get theme folder (without trailing slash)
	$theme_folder = get_template();

	// include update.php
	require_once ABSPATH . '/wp-admin/includes/update.php';

	// get theme updates
	$theme_updates = get_theme_updates();

	// loop through updates
	if(is_array($theme_updates)) {
		foreach ($theme_updates as $theme => $meta) {
			// make sure its semplice 4
			if($meta->Name == 'Semplice') {
				$output = array(
					'has_update' => true,
					'has_edition_upgrade' => false,
					'recent_version' => semplice_theme('version'),
					'new_version' => $meta->update['new_version']
				);
				// is edition upgrade available?
				if(semplice_theme('edition') == 'single' && $license['product'] != 's4-single') {
					$output['has_edition_upgrade'] = true;
				}
			}
		}
	}

	// check if correct folder
	if($theme_folder !== 'semplice4') {
		$output['wrong_folder'] = true;
	} else {
		$output['wrong_folder'] = false;
	}

	// output
	return $output;
}

?>