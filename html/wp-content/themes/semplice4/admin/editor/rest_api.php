<?php

// -----------------------------------------
// semplice
// admin/editor/rest_api.php
// -----------------------------------------

// include editor
require get_template_directory() . '/admin/editor/editor.php';

// include blocks
require get_template_directory() . '/admin/editor/blocks.php';

class editor_api extends editor {

	// public vars
	public $blocks;

	public function __construct() {

		// load constructor of editor
		parent::__construct();

		// instance of blocks
		$this->blocks = new blocks;
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	public function register_routes() {
		$version = '1';
		$namespace = 'semplice/v' . $version . '/editor';

		register_rest_route($namespace, '/version', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'version'),
		));

		// -----------------------------------------
		// add block
		// -----------------------------------------

		register_rest_route($namespace, '/blocks/add', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'add_block'),
		));

		// -----------------------------------------
		// save block
		// -----------------------------------------

		register_rest_route($namespace, '/blocks/save', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'save_block'),
		));

		// -----------------------------------------
		// delete block
		// -----------------------------------------

		register_rest_route($namespace, '/blocks/delete', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'delete_block'),
		));

		// -----------------------------------------
		// modules
		// -----------------------------------------

		register_rest_route($namespace, '/module', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'module'),
		));

		// -----------------------------------------
		// duplicate
		// -----------------------------------------

		register_rest_route($namespace, '/duplicate', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'duplicate'),
		));

		// -----------------------------------------
		// publish
		// -----------------------------------------

		register_rest_route($namespace, '/publish', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'publish'),
		));

		// -----------------------------------------
		// quick save
		// -----------------------------------------

		register_rest_route($namespace, '/save', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'save'),
		));

		// -----------------------------------------
		// footer settings
		// -----------------------------------------

		register_rest_route($namespace, '/save/footer-settings', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'save_footer_settings'),
		));

		// -----------------------------------------
		// save revision
		// -----------------------------------------

		register_rest_route($namespace, '/save-revision', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'save_revision'),
		));

		// -----------------------------------------
		// masonry
		// -----------------------------------------

		register_rest_route($namespace, '/masonry/edit', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'edit_masonry'),
		));

		// -----------------------------------------
		// coverslider
		// -----------------------------------------

		register_rest_route($namespace, '/coverslider', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'coverslider'),
		));

		// -----------------------------------------
		// remove token
		// -----------------------------------------

		register_rest_route($namespace, '/remove-token', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'remove_token'),
		));

		// -----------------------------------------
		// import cover
		// -----------------------------------------

		register_rest_route($namespace, '/import-cover', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'import_cover'),
		));
	}

	// show semplice version information
	public function version($request) {

		$version = array(
			'editor_version'	=> '1.0',
			'php_version'		=> PHP_VERSION
		);

		return new WP_REST_Response($version, 200);
	}

	// add block
	public function add_block($request) {

		// get ram
		$ram = $this->blocks->get($request['id'], $request['type']);

		// enable motions globally if motion block
		if($request['enable_motions'] == 'yes') {
			// get custmomize advanced
			$advanced = json_decode(get_option('semplice_customize_advanced'), true);
			// chnage setting
			$advanced['motion_tab'] = 'enabled';
			// save again
			update_option('semplice_customize_advanced', json_encode($advanced));
		}

		// is array?
		if(is_array($ram)) {
			// get html, css etc.
			$output = $this->get_content($ram, 'editor', true, false);

			// delete order from ram
			unset($ram['order']);

			// add images to output and then unset from ram
			$output['images'] = $ram['images'];
			unset($ram['images']);

			// add ram ro output
			$output['ram'] = json_encode($ram, JSON_FORCE_OBJECT);
		} else {
			$output['ram'] = $ram;
		}
		

		return new WP_REST_Response($output, 200);
	}

	// save block
	public function save_block($request) {

		// get ram
		$content = $this->check_slashes($request['content']);

		// save
		$output = $this->blocks->save($content, $request['name']);

		return new WP_REST_Response($output, 200);
	}

	// delete block
	public function delete_block($request) {

		// save
		$this->blocks->delete($request['id']);

		return new WP_REST_Response('Block deleted.', 200);
	}

	// get masonry
	public function edit_masonry($request) {

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// save dribbble token if set
		if(isset($request['token']) && !empty($request['token'])) {
			update_option('semplice_dribbble_token', $request['token']);
		}

		// decode
		$content = json_decode($content, true);

		// include module
		require_once get_template_directory() . '/admin/editor/modules/' . $request['module'] . '.php';
		
		// output
		$output = $this->module[$request['module']]->output_editor($content, $request['id']);

		return new WP_REST_Response($output, 200);
	}

	// duplicate
	public function duplicate($request) {
		$module = $this->generate_duplicate($request, 'editor');

		return new WP_REST_Response($module, 200);
	}
	
	// save and publish
	public function save($request) {

		// save mode
		$save_mode = $request['save_mode'];

		// change setatus
		$change_status = $request['change_status'];

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// as long as the user saves via the editor, set semplice as activated
		update_post_meta($request['post_id'], '_is_semplice', true, '');

		// save post settings
		if($request['post_type'] != 'footer') {
			$args = $this->save_post_settings($request, 'save-to-wp');	
		} else {
			$args = array();
		}
		

		// only save to post if save mode is publish or post status is draft, otherwise just save to revision. add post meta. since wordpress strips slashes on post meta, add them before as a workaround
		if($save_mode == 'publish' || $save_mode == 'private' || get_post_status($request['post_id']) == 'draft') {

			if($save_mode == 'publish') {
				// if draft, change to publish
				$args['post_status'] = 'publish';
			} else if($save_mode == 'private') {
				$args['post_status'] = 'private';
			}

			// update post meta
			update_post_meta($request['post_id'], '_semplice_content', wp_slash($content), '');
		} else {
			// change status
			if($change_status == 'yes') {
				$args['post_status'] = 'draft';
			}
		}

		// post password
		$post_password = $request['post_password'];

		if($post_password && !empty($post_password)) {
			$args['post_password'] = $post_password;
		} else {
			$args['post_password'] = '';
		}

		// update post args
		$args['ID'] = $request['post_id'];

		// before publish, make sure this is saved to the latest version in the revisions
		$this->save_latest_version($request, $content);

		// save colors
		if(isset($request['custom_colors'])) {
			update_option('semplice_custom_colors', $request['custom_colors']);
		}

		// update post
		wp_update_post($args);

		return new WP_REST_Response($content, 200);
	}

	// save latest version
	public function save_latest_version($request, $content) {

		// get used fonts and check slashes
		$used_fonts = $this->check_slashes($request['used_fonts']);

		// save used fonts
		if($used_fonts) {
			// update global used fonts
			update_option('semplice_used_fonts', $used_fonts);
		}

		// check if this is the first save
		if($request['first_save'] && $request['first_save'] == 'yes') {
			// save revision in the database
			$this->db->insert(
				$this->rev_table_name,
				array(
					"post_id"		 => $request['post_id'],
					"revision_id"  	 => 'latest_version',
					"revision_title" => 'Latest Version',
					"content"		 => $content,
					"settings"		 => $this->save_post_settings($request, 'save-to-revision'),
				)
			);
		} else {
			// update unsaved changes
			$this->db->update(
				$this->rev_table_name, 
				array(
					"content"	  	=> $content,
					"settings"		=> $this->save_post_settings($request, 'save-to-revision'),
					"wp_changes"	=> false
				),
				array(
					"post_id" 		=> $request['post_id'],
					"revision_id"	=> 'latest_version'
				)
			);
		}
	}

	// post settings
	public function save_post_settings($request, $mode) {

		// get post settings and check slashes
		$post_settings_json = $this->check_slashes($request['post_settings']);

		// decode post settings
		$post_settings = json_decode($post_settings_json, true);

		// save admin images
		if(isset($request['images']) && !empty($request['images'])) {
			update_option('semplice_admin_images', $request['images']);
		}

		// save seo
		if(isset($post_settings['seo'])) {
			foreach ($post_settings['seo'] as $key => $value) {
				// update post meta
				update_post_meta($request['post_id'], $key, wp_slash($value), '');
			}	
		}
		
		//publish settings
		if($mode == 'save-to-wp') {

			$args = array();

			// save post settings in post meta
			update_post_meta($request['post_id'], '_semplice_post_settings', wp_slash($post_settings_json), '');

			// get post
			$post = get_post($request['post_id']);

			// apply post settings
			if(!empty($post_settings['meta'])) {
				$args['post_title'] = $post_settings['meta']['post_title'];
				// page slug
				if($post->post_name != $post_settings['meta']['permalink']) {
					$args['post_name'] = wp_unique_post_slug(sanitize_title($post_settings['meta']['permalink']), $request['post_id'], 'publish', $request['post_type'], 0);
				}
				// has categories and is not post type page
				if($request['post_type'] != 'page') {
					// set categories
					if(!empty($post_settings['meta']['categories'])) {
						wp_set_post_categories($request['post_id'], $post_settings['meta']['categories'], false);
					}
				}
			}

			// return args
			return $args;
		} else {
			return $post_settings_json;
		}
	}

	// footer settings
	public function save_footer_settings($request) {

		// get post settings and check slashes
		$footer_settings_json = $this->check_slashes($request['settings']);

		// decode post settings
		$footer_settings = json_decode($footer_settings_json, true);

		// save title to post
		if(isset($footer_settings['title'])) {

			// update post
			wp_update_post(array(
				'ID' => $request['id'],
				'post_title' => $footer_settings['title'],
			));
		}

		return new WP_REST_Response('Footer settings saved successfully', 200);
	}

	// coverslider
	public function coverslider($request) {
		// return slider html
		return new WP_REST_Response(semplice_get_coverslider($request['covers'], 'editor'), 200);
	}

	// remove token
	public function remove_token($request) {
		
		// is vendor set?
		if(isset($request['vendor'])) {
			update_option('semplice_' . $request['vendor'] . '_token', false);
		}

		return new WP_REST_Response('Token removed', 200);
	}

	// import cover
	public function import_cover($request) {
		// output
		return new WP_REST_Response(semplice_import_cover($request['post_id']), 200);
	}

	// check slashes
	public function check_slashes($content) {

		// get first 3 chars of content json string
		$quote_status = mb_substr($content, 0, 2);

		if($quote_status !== '{"') {
			$content = stripcslashes($content);
		}

		// return content
		return $content;
	}

	// -----------------------------------------
	// check nonce to verify user
	// -----------------------------------------

	public function auth_user() {

		// get nonce
		$nonce = isset($_SERVER['HTTP_X_WP_NONCE']) ? $_SERVER['HTTP_X_WP_NONCE'] : '';

		// verfiy nonce
		$nonce = wp_verify_nonce($nonce, 'wp_rest');

		// check nonce and if current user has admin rights
		if($nonce && current_user_can('manage_options')) {
			return true;
		} else {
			return false;
		}
	}
}

// -----------------------------------------
// build instance of editor api and editor class
// -----------------------------------------

$editor_api = new editor_api();

?>