<?php

// -----------------------------------------
// semplice
// /admin/transitions.php
// -----------------------------------------

if(!class_exists('transitions')) {
	class transitions {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// output air
			$output['content'] = 'output';

			return $output;
		}
	}

	// instance
	$this->customize['transitions'] = new transitions;
}

?>