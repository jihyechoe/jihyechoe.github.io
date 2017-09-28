<?php

// -----------------------------------------
// semplice
// includes/custom_css.php
// -----------------------------------------

class custom_css {

	// globals
	public $admin_api;

	public function __construct() {
		// rest api
		global $admin_api;
		$this->semplice_api = $admin_api;
	}

	// -----------------------------------------
	// grid 
	// -----------------------------------------

	public function grid($mode) {
		// get grid
		if($mode == 'editor') {
			return semplice_grid('editor');
		} else {
			return semplice_grid('frontend');
		}
	}

	// -----------------------------------------
	// webfonts
	// -----------------------------------------

	public function webfonts() {
		// get fonts
		return $this->semplice_api->customize['webfonts']->get();
	}

	// -----------------------------------------
	// typography
	// -----------------------------------------

	public function typography($is_admin) {
		// get fonts
		return $this->semplice_api->customize['typography']->get('css', $is_admin);
	}
	
	// -----------------------------------------
	// navigation
	// -----------------------------------------

	public function navigation() {
		// get fonts
		return $this->semplice_api->customize['navigations']->get('css', false, false, false);
	}

	// -----------------------------------------
	// blog
	// -----------------------------------------

	public function blog($is_admin) {
		// get blog css
		return $this->semplice_api->customize['blog']->get_css($is_admin);
	}

	// -----------------------------------------
	// advanced custom css
	// -----------------------------------------

	public function advanced($is_frontend) {
		// get css
		return $this->semplice_api->customize['advanced']->generate_css($is_frontend);
	}
}

$semplice_custom_css = new custom_css;

?>