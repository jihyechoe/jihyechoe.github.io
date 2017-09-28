<?php

// -----------------------------------------
// semplice
// /rest_api.php
// -----------------------------------------

class frontend_api {

	// public vars
	public $db, $editor, $rev_table_name, $get_content;

	public function __construct() {
		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// editor api
		global $editor_api;
		$this->editor = $editor_api;

		// get content class
		global $semplice_get_content;
		$this->get_content = $semplice_get_content;
	}

	// -----------------------------------------
	// rest routes
	// -----------------------------------------

	public function register_routes() {
		$version = '1';
		$namespace = 'semplice/v' . $version . '/frontend';

		// post
		register_rest_route($namespace, '/post', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array($this, 'post'),
		));

		// get password protected post
		register_rest_route($namespace, '/post-password', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array($this, 'post_password'),
		));
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	// get a post for the frontend
	public function post($request) {
		// check if category
		if($request['taxonomy'] == 'category' || $request['taxonomy'] == 'post_tag') {
			// get category
			$term = get_term_by('slug', $request['term'], $request['taxonomy']);
			// is category?
			if($term) {
				// set id to category
				$id = $request['taxonomy'];
			} else {
				$id = 'notfound';
			}
		} else {
			// get post
			$post = get_post($request['id']);
			// format id
			$id = semplice_format_id($request['id'], false);
		}

		// has password?
		$has_password = false;
		if(post_password_required($id)) {
			$has_password = true;
		}
		
		// make array
		if(isset($post) && is_object($post)) {
			// output
			$output = $this->output($post->ID, $post->post_name, $post->post_title, $this->get_content->get($id, false, 0, false), $has_password, $post->post_type);
			// get post settings only when semplice is activated
			if($output['content']['is_semplice']) {
				$output['post_settings'] = semplice_generate_post_settings(json_decode(get_post_meta($post->ID, '_semplice_post_settings', true), true), $post);
			}
		} else if($id == 'posts') {
			// get blog overview
			$output = $this->output($id, '', get_bloginfo('name') . ' - ' . get_bloginfo('description'), $this->get_content->posts(false, intval($request['page'])), $has_password, 'posts');
		} else if($id == 'category' || $id == 'post_tag') {
			$output = $this->output($request['id'], '', $term->name, $this->get_content->posts($term, intval($request['page'])), $has_password, 'category');
		} else {
			// get 404 not found page
			$output = $this->output('notfound', '', '404 - Not found', $this->get_content->default_content('not-found'), $has_password, 'notfound');
		}

		// wrap sections
		if(isset($output['content']['html'])) {
			$output['content']['html'] = '<div class="sections">' . $output['content']['html'] . '</div>';
		}
		
		return new WP_REST_Response($output, 200);
	}

	// get password protected post
	public function post_password($request) {
		// get post
		$post = get_post($request['id']);
		// password
		$password = $request['password'];
		// format id
		$id = semplice_format_id($request['id'], false);
		// check if post
		if(isset($post) && is_object($post)) {
			// check password
			if($post->post_password == $password) {
				$output = $this->get_content->get($id, false, 0, false);
				// only pass html
				$output = $output['html'];
			} else {
				$output = 'wrong-password';
			}
		} else {
			$output = 'wrong-password';
		}
		return $output;
	}

	// generate output
	public function output($id, $name, $title, $content, $has_password, $post_type) {
		return array(
			'id'   			=> $id,
			'name' 			=> $name,
			'title' 		=> $title,
			'content'		=> $content,
			'has_password'  => $has_password,
			'post_type'		=> $post_type,
		);
	}
}

// -----------------------------------------
// build instance of frontend api
// -----------------------------------------

$frontend_api = new frontend_api();

?>