<?php

// -----------------------------------------
// semplice
// /admin/admin_api.php
// -----------------------------------------

class admin_api {

	// public vars
	public $db, $editor, $rev_table_name, $customize;

	public function __construct() {

		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// editor api
		global $editor_api;
		$this->editor = $editor_api;

		// grid
		require get_template_directory() . '/admin/customize/grid.php';

		// webfonts
		require get_template_directory() . '/admin/customize/webfonts.php';

		// navigations
		require get_template_directory() . '/admin/customize/navigations.php';

		// typography
		require get_template_directory() . '/admin/customize/typography.php';
		
		// thumb hover
		require get_template_directory() . '/admin/customize/thumbhover.php';

		// transitions
		require get_template_directory() . '/admin/customize/transitions.php';

		// footer
		require get_template_directory() . '/admin/customize/footer.php';

		// blog
		require get_template_directory() . '/admin/customize/blog.php';

		// advanced
		require get_template_directory() . '/admin/customize/advanced.php';		
	}

	// -----------------------------------------
	// rest routes
	// -----------------------------------------

	public function register_routes() {
		$version = '1';
		$namespace = 'semplice/v' . $version . '/admin';

		// posts
		register_rest_route($namespace, '/posts/(?P<id>\d+)', array(
			'methods'	=> WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback'	=> array($this, 'posts'),
		));

		// posts
		register_rest_route($namespace, '/posts/show-all', array(
			'methods'	=> WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback'	=> array($this, 'posts'),
		));

		// dashboard
		register_rest_route($namespace, '/dashboard', array(
			'methods'	=> WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback'	=> array($this, 'dashboard'),
		));

		// post
		register_rest_route($namespace, '/post', array(
			'methods'	=> WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback'	=> array($this, 'post'),
		));

		// onboarding
		register_rest_route($namespace, '/onboarding', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'onboarding'),
		));

		// save onboarding
		register_rest_route($namespace, '/onboarding/save', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'onboarding_save'),
		));

		// customize page
		register_rest_route($namespace, '/customize', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'customize'),
		));

		// setting page
		register_rest_route($namespace, '/setting', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'setting'),
		));

		// create
		register_rest_route($namespace, '/create/post', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'create_post'),
		));

		// duplicate post
		register_rest_route($namespace, '/duplicate/post', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'duplicate_post'),
		));

		// duplicate navigation
		register_rest_route($namespace, '/duplicate/navigation', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'duplicate_navigation'),
		));

		// delete post
		register_rest_route($namespace, '/delete/post', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'delete_post'),
		));

		// init editor
		register_rest_route($namespace, '/edit/(?P<id>\d+)', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'init_editor'),
		));

		// save customize settings
		register_rest_route($namespace, '/customize/save', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'customize_settings_save'),
		));

		// save customize settings
		register_rest_route($namespace, '/settings/save', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'customize_settings_save'),
		));

		// page settings
		register_rest_route($namespace, '/category/add', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'add_category'),
		));

		// portfolio order
		register_rest_route($namespace, '/portfolio-order/save', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'save_portfolio_order'),
		));

		// edit navigation
		register_rest_route($namespace, '/navigation/edit', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'edit_navigation'),
		));

		// get post settings
		register_rest_route($namespace, '/post-settings/get', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'get_post_settings'),
		));

		// license check
		register_rest_route($namespace, '/license/save', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'license_save'),
		));

		// publish post settings
		register_rest_route($namespace, '/post-settings/publish', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'publish_post_settings'),
		));

		// activate semplice
		register_rest_route($namespace, '/activate-semplice', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'activate_semplice'),
		));

		// get post settings
		register_rest_route($namespace, '/menu/get', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'get_menu'),
		));

		// activate menu
		register_rest_route($namespace, '/menu/activate', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'activate_menu'),
		));

		// add menu item
		register_rest_route($namespace, '/menu/add', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'add_menu_item'),
		));

		// delete menu item
		register_rest_route($namespace, '/menu/delete', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'delete_menu_item'),
		));

		// save menu
		register_rest_route($namespace, '/menu/save', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'save_menu'),
		));

		// update post status
		register_rest_route($namespace, '/update-post-status', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'update_post_status'),
		));

		// enable transitions
		register_rest_route($namespace, '/enable-transitions', array(
			'methods' => WP_REST_Server::CREATABLE,
			'permission_callback' => array($this, 'auth_user'),
			'callback' => array($this, 'enable_transitions'),
		));
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	// get a list of the latest posts
	public function posts($request) {
		// get posts
		return new WP_REST_Response(semplice_get_posts($request), 200);
	}

	// build dashboard
	public function dashboard($request) {
	
		// open dashboard
		$output = '<div class="semplice-dashboard">';

		// add latest 3 projects
		$args = array(
			'post_type' => 'project',
			'page'		=> 1,
		);

		// get license
		$license = semplice_get_license();

		// check if theme folder is correct and license is valid
		if(!is_array($license) || is_array($license) && true !== $license['is_valid']) {
			$output .= '
				<div class="activate-now">
					<div class="admin-container">
						<div class="admin-row">
							<div class="admin-column" data-xl-width="12">
								<div class="icon">' . get_svg('backend', '/icons/popup_important') . '</div>
								<h4>Don\'t forget to activate Semplice to receive free one-click updates.</h4>
								<a class="activate-button" href="#settings/general">Activate Now</a>
							</div>
						</div>
					</div>
				</div>
			';
		}

		// get posts
		$output .= '
			<div class="projects posts admin-container">
				<h4>Recent Projects</h4>
				<div class="projects-list admin-row">
					' . semplice_dashboard_projects() . '
					<div class="new-project admin-column admin-click-handler" data-xl-width="3" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="project">
						<img src="' . get_template_directory_uri() . '/assets/images/admin/add_project.png" alt="add-project">
					</div>
				</div>
			</div>
		';

		// divider
		$output .= '<div class="dashboard-divider"></div>';

		// get content from semplicelabs
		$contents = wp_remote_get('http://news.semplicelabs.com/wp-json/news/v1/dashboard?edition=' . semplice_theme('edition'));
		$contents = json_decode($contents['body'], true);

		// is content?
		if(null !== $contents) {
			// news open
			$output .= '
				<div class="admin-container">
					<div class="admin-row">
			';

			foreach ($contents as $content) {
				// title
				$title = '';
				if(isset($content['title']) && !empty($content['title'])) {
					$title = '<h4>' . $content['title'] . '</h4>';
				}
				// add content
				$output .= '
					<div class="admin-column news" data-xl-width="' . $content['width'] . '">
						' . $title . '
						' . $content['content'] . '
					</div>
				';
			}

			// news close
			$output .= '
					</div>
				</div>
				<div class="semplice-version">
					<a class="admin-click-handler" data-handler="execute" data-action-type="popup" data-action="aboutSemplice">Semplice ' . ucfirst(semplice_theme('edition')) . ' ' . semplice_theme('version') . '</a>
				</div>
			';

		}

		// close dashboard
		$output .= '</div>';

		if(isset($request['is_post_settings'])) {
			return $output;
		} else {
			return new WP_REST_Response($output, 200);
		}
	}

	// get onboarding html
	public function onboarding($request) {

		// output array
		$output = array(
			'html' => semplice_get_onboarding($request['step']),
		);

		return new WP_REST_Response($output, 200);
	}

	// save onboarding
	public function onboarding_save($request) {

		// defaults
		$defaults = array(
			'name' 			=> 'John Doe',
			'description' 	=> 'Portfolio',
			'first_project' => 'My First Project',
			'thumbnail_id'	=> 'none',
			'thumbnail_url' => get_template_directory_uri() . '/assets/images/admin/no_thumbnail.png',
		);

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// make array
		$content = json_decode($content, true);

		// loop throught data and fill with default if no data there
		foreach ($defaults as $attribute => $default) {
			// is empty?
			if(!isset($content[$attribute]) || empty($content[$attribute])) {
				$content[$attribute] = $default;
			}	
		}

		// first page
		$first_page = array(
			'post_title'   => 'Work',
			'post_status'  => 'publish',
			'post_type'	   => 'page',
			'post_name'	   => wp_unique_post_slug(sanitize_title('work'), '', 'publish', 'page', 0),
		);

		// add first page
		$first_page_id = wp_insert_post($first_page);

		// get first page data
		$first_page_data = semplice_first_page($first_page_id, $content);

		// add content to first project
		$this->editor->save($first_page_data);

		// created with s4 admin so per default set is semplice to true
		update_post_meta($first_page_id, '_is_semplice', true, '');

		// set show on front to page
		update_option('show_on_front', 'page');

		// make homepage
		update_option('page_on_front', $first_page_id);

		// set blog name
		update_option('blogname', $content['name']);

		// set blog description
		update_option('blogdescription', $content['description']);

		// first project
		$first_project = array(
		  'post_title'    => $content['first_project'],
		  'post_status'   => 'draft',
		  'post_type'	  => 'project',
		  'post_name'	  => wp_unique_post_slug(sanitize_title($content['first_project']), '', 'publish', 'project', 0),
		);

		// add first projects
		$first_project_id = wp_insert_post($first_project);

		// get first project data
		$first_project_data = semplice_first_project($first_project_id, $content);

		// portfolio order
		semplice_portfolio_order($first_project_id);

		// add content to first project
		$this->editor->save($first_project_data);

		// add a new menu called semplice menu
		$menu_name = 'Semplice Menu';
		$menu_object = wp_get_nav_menu_object($menu_name);

		// craate new menu if it doesnt already exist
		if(!$menu_object) {
			$menu_id = wp_create_nav_menu($menu_name);

			// get menu localtions
			$locations = get_theme_mod('nav_menu_locations');

			// assign new menu
			$locations['semplice-main-menu'] = $menu_id;

			// set new menu
			set_theme_mod('nav_menu_locations', $locations);
		} else {
			// menu id
			$menu_id = $menu_object->term_id;
		}

		// add our new created homepage as first page
		wp_update_nav_menu_item($menu_id, 0, array(
			'menu-item-object' 		=> 'page',
			'menu-item-title'  	 	=> 'Work',
			'menu-item-object-id' 	=> $first_page_id,
			'menu-item-status' 	 	=> 'publish',
			'menu-item-type'	 	=> 'post_type',
			'menu-item-url'			=> '',
		));

		// set completed onboarding to true
		update_option('semplice_completed_onboarding', true);
	}

	// get customize page
	public function customize($request) {

		// output array
		$output = array(
			'content' 	=> $this->customize[$request['setting']]->output(),
			'css'		=> array(
				'advanced'	 => $this->customize['advanced']->generate_css(false),
				'typography' => $this->customize['typography']->get('css', true),
				'grid'		 => semplice_grid('editor'),
				'webfonts'	 => $this->customize['webfonts']->generate_css(false),
			),
			'footer'	=> semplice_get_post_dropdown('footer'),
		);

		return new WP_REST_Response($output, 200);
	}

	// get setting page
	public function setting($request) {

		// output
		$output = array('settings', 'atts');

		// get settings
		if($request['setting'] == 'general') {
			$output['settings'] = semplice_get_general_settings();
		} else {
			$output['settings'] = json_decode(get_option('semplice_settings_' . $request['setting'])); 
		}

		// get atts
		require get_template_directory() . '/admin/atts/settings.php';
		$output['atts'] = $settings[$request['setting']];

		return new WP_REST_Response($output, 200);
	}

	// create post
	public function create_post($request) {

		// get post meta and check slashes
		$meta = $this->check_slashes($request['meta']);

		// make meta an array
		$meta = json_decode($meta, true);

		// save new post
		$create_post = array(
		  'post_title'    => $meta['post-title'],
		  'post_status'   => 'draft',
		  'post_type'	  => $request['post_type'],
		  'post_name'	  => wp_unique_post_slug(sanitize_title($meta['post-title']), '', 'publish', $request['post_type'], 0),
		);

		// Insert the post into the database
		$post_id = wp_insert_post($create_post);

		// project post settings
		if($request['post_type'] == 'project') {
			// post settings
			$post_settings = array(
				'thumbnail' => array(
					'image' => $meta['project-thumbnail'],
					'width'	=> '',
					'hover_visibility' => 'disabled',
				),
				'meta' => array(
					'post_title' 	=> $meta['post-title'],
					'permalink' 	=> sanitize_title($meta['post-title']),
					'project_type' 	=> $meta['project-type'],
				),
			);
			// save json
			$post_settings = json_encode($post_settings);
			// add to post meta
			update_post_meta($post_id, '_semplice_post_settings', wp_slash($post_settings), '');
		}

		// created with s4 admin so per default set is semplice to true
		update_post_meta($post_id, '_is_semplice', true, '');

		$output = array(
			'post_id' => $post_id
		);

		// portfolio order
		semplice_portfolio_order($post_id);

		// add to menu
		if(isset($meta['add_to_menu']) && $meta['add_to_menu'] == 'yes') {

			// get menu id
			$menu_name = 'Semplice Menu';
			$menu_object = wp_get_nav_menu_object($menu_name);
			
			// is menu there? if not create it
			if(!$menu_object) {
				$menu_id = wp_create_nav_menu($menu_name);
				// get menu localtions
				$locations = get_theme_mod('nav_menu_locations');
				// assign new menu
				$locations['semplice-main-menu'] = $menu_id;
				// set new menu
				set_theme_mod('nav_menu_locations', $locations);
			} else {
				// menu id
				$menu_id = $menu_object->term_id;
			}

			// update nav item
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-object' 		=> 'page',
				'menu-item-object-id' 	=> $post_id,
				'menu-item-title'  	 	=> __($meta['post-title']),
				'menu-item-status' 	 	=> 'publish',
				'menu-item-type'	 	=> 'post_type',
				'menu-item-url'			=> '',
			));
		}

		// check if cover slider
		if(isset($meta['content_type']) && $meta['content_type'] == 'coverslider') {
			// set cover slider to true in page meta
			update_post_meta($post_id, '_is_coverslider', true, '');
		}

		return new WP_REST_Response($output, 200);
	}

	// init editor
	public function init_editor($request) {

		// editor template
		$post_id     = $request['post_id'];
		$post_type   = get_post_type($post_id);
		$row         = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = 'latest_version'");
		
		// check if row has content already
		if(null !== $row) {
			$ram = json_decode($row->content, true);
			$post_settings = json_decode($row->settings, true);
		} else {
			$ram = false;
			// maybe its a new post, try to get post settings from meta
			$post_settings = json_decode(get_post_meta($post_id, '_semplice_post_settings', true), true);
			// set wp changes to true
			$wp_changes = true;
			// check if array
			if(!is_array($post_settings)) {
				$post_settings = false;
				$wp_changes = false;
			}
		}

		// get post
		$post = get_post($post_id);
		
		// dont load post settings on footer
		if($post_type != 'footer') {
			$post_settings = semplice_generate_post_settings($post_settings, $post);
		} else {
			$post_settings = false;
		}

		// get post status
		$post_status = get_post_status($post_id);

		// get post password
		if(!empty($post->post_password)) {
			$post_password = $post->post_password;
		} else {
			$post_password = '';
		}

		// get thumbnail
		$thumbnail = semplice_get_thumbnail_id($post_settings, $post_id);

		// define images
		$images = array();

		if(!empty($thumbnail)) {
			$images[$thumbnail] = semplice_get_image($thumbnail, 'full');
		}

		// get cover slider
		$is_coverslider = semplice_boolval(get_post_meta($post->ID, '_is_coverslider', true));

		// get covers
		$covers = semplice_posts_with_covers();

		// post meta
		$post_meta = array(
			'post_title'		=> $post->post_title,
			'post_type'	 		=> $post_type,
			'post_password'		=> $post_password,
			'post_status' 		=> $post_status,
			'permalink'			=> $post->post_name,
		);

		// customize css
		$css = array(
			'post'				=> '',
			'typography'	=> $this->customize['typography']->get('css', true),
			'grid'			=> semplice_grid('editor'),
			'webfonts'		=> $this->customize['webfonts']->generate_css(false),
			'advanced'		=> $this->customize['advanced']->generate_css(false),
		);

		// footer select
		$footer_select = semplice_get_post_dropdown('footer');

		if(!empty($ram)) {

			// get content
			$content = $this->editor->get_content($ram, 'editor', false, $is_coverslider);

			// bg images
			if(is_array($ram['images'])) {

				// fetch all image urls in case they have chnaged (ex domain)
				foreach ($ram['images'] as $image_id => $image_url) {
					// get image
					$images[$image_id] = semplice_get_image($image_id, 'full');
				}
			}

			// add post css
			$css['post'] = $content['css'];

			$output = array(
				'ram' 		 		=> $row->content,
				'html'  	 		=> $content['html'],
				'css'		 		=> $css,
				'images'  	 		=> !empty($images) ? $images : '',
				'meta'				=> $post_meta,
				'post_settings' 	=> $post_settings,
				'navigator'			=> $this->editor->navigator(),
				'footer'			=> $footer_select,
				'covers'			=> $covers,
				'is_coverslider'	=> $is_coverslider,
			);
		} else {

			// is coverslider?
			if(true === $is_coverslider) {
				// if covers available use them all, if not make an empty slider
				if(!empty($covers)) {
					// create fake ram
					$fake_ram = array(
						'coverslider' => array(
							'covers' => array(),
						),
					);
					// make coverslider compatible list
					foreach ($covers as $post_id => $post_title) {
						array_push($fake_ram['coverslider']['covers'], $post_id);
					}
					// get content
					$content = $this->editor->get_content($fake_ram, 'editor', false, true);
					// add html
					$default_html = $content['html'];
					// css
					$css['post'] = $content['css'];
				} else {
					$default_html = semplice_empty_coverslider();
				}
				
			} else {
				$default_html = semplice_default_cover('hidden');
			}

			// empty css
			$output = array(
				'ram' 		 		=> 'empty',
				'html'  	 		=> $default_html,
				'css'				=> $css,
				'images'			=> !empty($images) ? $images : '',
				'meta'				=> $post_meta,
				'post_settings' 	=> $post_settings,
				'navigator'			=> $this->editor->navigator(),
				'footer'			=> $footer_select,
				'covers'			=> $covers,
				'is_coverslider'	=> $is_coverslider,
			);
		}

		return new WP_REST_Response($output, 200);
	}

	// duplicate post - thanks to Misha Rudrastyh / https://rudrastyh.com/
	public function duplicate_post($request) {

	 	// post id
		$post_id = $request['post_id'];

		// get post data
		$post = get_post($post_id);

		// output
		$output = array();
		$output['html'] = '';
	 
		// if post data, duplicate
		if(isset($post) && $post != null) {

	 		// dont add another duplicate if there
			if (strpos($post->post_title, ' - Duplicate') === false) {
				$post->post_title = $post->post_title . ' - Duplicate';
			}

			// create new post data array
			$args = array(
				'ping_status'    => $post->ping_status,
				'post_author'    => $post->post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => wp_unique_post_slug(sanitize_title($post->post_title), '', 'publish', $post->post_type, 0),
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
	 
			// insert post
			$new_post_id = wp_insert_post($args);

			// set new post id for output
			$output['id'] = $new_post_id;

			//get all current post terms ad set them to the new post draft
			$taxonomies = get_object_taxonomies($post->post_type);

			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}

			// get latest version from the semplice revisions and save this to the new post meta field
			$row = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = 'latest_version'");
	 
			// only add content to latest version if available. since its a draft no need to copy the meta field also
			if(null !== $row && isset($row->content)) {
				// assign content
				$encoded_ram = json_encode(semplice_generate_ram_ids($row->content, true, false), JSON_FORCE_OBJECT);
				// save revision in the database
				$this->db->insert(
					$this->rev_table_name, 
					array(
						"post_id"		 => $new_post_id,
						"revision_id"  	 => 'latest_version',
						"revision_title" => 'Latest Version',
						"content"		 => $encoded_ram,
						"settings"		 => $row->settings,
					)
				);
			} else {
				// set encoded ram to false if there is no ram available
				$encoded_ram = '';
			}

			//duplicate all post meta just in two SQL queries
			$post_meta_infos = $this->db->get_results("SELECT meta_key, meta_value FROM {$this->db->postmeta} WHERE post_id=$post_id");

			// meta counter
			$meta_count = 0;

			// are there post metas?
			if(count($post_meta_infos) != 0) {
				// iterate post metas
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					// if semplice content, update post meta seperately for the json string
					if ($meta_key == '_semplice_content') {
						update_post_meta($new_post_id, '_semplice_content', wp_slash($encoded_ram));
					} else if($meta_key != '_is_semplice') {
						$meta_count++;
						$meta_value = addslashes($meta_info->meta_value);
						$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
					}
				}
				// meta count > 0?
				if($meta_count > 0) {
					$sql_query = "INSERT INTO {$this->db->postmeta} (post_id, meta_key, meta_value)";
					$sql_query.= implode(" UNION ALL ", $sql_query_sel);
					$this->db->query($sql_query);
				}
			}

			// activate semplice
			update_post_meta($new_post_id, '_is_semplice', true, '');
		
			// get thumbnail
			if($request['post_type'] == 'project') {
				// post settings
				$thumbnail = semplice_get_thumbnail($post_id);
			} else {
				$thumbnail = false;
			}

			// format post
			$output['html'] .= semplice_post_row($new_post_id, $request['post_type'], $post->post_title, 'draft', true, $thumbnail, true, $args['post_name']);
		} else {
			$output['html'] = 'Post creation failed, could not find original post: ' . $post_id;
		}

		return new WP_REST_Response($output, 200);
	}

	// delete post
	public function delete_post($request) {

	 	// post id
		$post_id = $request['post_id'];

		// delete post
		if($post_id) {
			wp_trash_post($post_id, false);
		}

		return new WP_REST_Response('Deleted', 200);
	}

	// save customize settings
	public function customize_settings_save($request) {

		// setting
		$category = $request['category'];

		// get settings and add or remove slashes
		$settings = $this->check_slashes($request['settings']);

		// get setting type
		$settings_type = $request['settings_type'];

		$output = $category;
		
		// save settings in the DB
		update_option('semplice_' . $category . '_' . $settings_type, $settings);
		update_option('semplice_admin_images', $request['images']);
		update_option('semplice_custom_colors', $request['custom_colors']);

		// changed menu order?
		if(!empty($request['menu_order'])) {
			semplice_update_menu_order($request['menu_order']);
		}

		// save frontpages
		if($category == 'settings' && $settings_type == 'general') {
			// decode settings
			$settings = json_decode($settings, true);
			// defaults
			$homepage = array(
				'show_on_front'  	=> 'posts',
				'page_for_posts' 	=> 0,
				'page_on_front' 	=> 0,
			);
			if($settings['show_on_front'] != 'posts') {
				// set homepage type
				$homepage['show_on_front'] = 'page';
				// blog homepage
				if(isset($settings['page_for_posts'])) {
					$homepage['page_for_posts'] = $settings['page_for_posts'];
				}
				// pages homepage
				if(isset($settings['page_on_front'])) {
					$homepage['page_on_front'] = $settings['page_on_front'];
				}
			}
			// update homepage
			update_option('show_on_front', $homepage['show_on_front']);
			update_option('page_for_posts', $homepage['page_for_posts']);
			update_option('page_on_front', $homepage['page_on_front']);

			// site title
			if(isset($settings['site_title'])) {
				update_option('blogname ', $settings['site_title']);
			}

			// site tagline
			if(isset($settings['site_tagline'])) {
				update_option('blogdescription', $settings['site_tagline']);
			}
		}

		return new WP_REST_Response('Saved ' . $settings_type, 200);
	}

	// get menu html
	public function get_menu($request) {
		// output
		$output = '';
		$notices = '';
		$menu_html = '';
		$hide_menu = '';

		// get menu
		$menu_name = 'Semplice Menu';
		$menu_items = wp_get_nav_menu_items($menu_name);
		$menu_object = wp_get_nav_menu_object($menu_name);

		// craate new menu if it doesnt already exist
		if(is_array($menu_items)) {
			// get menu id
			$menu_id = $menu_object->term_id;
			// get menu localtions
			$locations = get_theme_mod('nav_menu_locations');
			// get menu id location
			$menu_id_location = $locations['semplice-main-menu'];
			// check if menu is in location semplice main menu
			if($menu_id != $menu_id_location) {
				$notices = '
					<p class="notice-heading">Not active</p>
					<div class="edit-menu-notice">
						<p class="no-menu">The Semplice menu is not active. In order to edit your menu please first activate it.</p>
						<div class="save-new-menu-item">
							<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="activate">Activate Menu</a>
						</div>
					</div>
				';
				$hide_menu = ' hide';
			}
			// build nav
			foreach ($menu_items as $key => $item) {
				$classes = '';
				$url = '';
				// classes
				if(is_array($item->classes) && !empty($item->classes)) {
					foreach ($item->classes as $class) {
						$classes .= $class . ' ';
					}
				}
				// url
				if($item->type == 'custom') {
					$url = '
						<label class="url-label">Link</label>
						<input type="text" name="link" class="item-link admin-listen-handler" data-handler="updateMenu" value="' . $item->url . '" placeholder="http://www.semplicelabs.com">
					';
				}
				$menu_html .= '
					<li class="semplice-menu-item" id="nav-item-' . $item->ID . '" data-type="' . $item->type . '">
						<a class="menu-items-handle"></a>
						<a class="show-options admin-click-handler" data-handler="execute" data-action-type="menu" data-action="showOptions" data-id="' . $item->ID . '">' . $item->title . '</a>
						<a class="remove-nav-item admin-click-handler" data-handler="execute" data-action-type="menu" data-action="remove" data-id="' . $item->ID . '"></a>
						<div class="item-options">
							<label class="first-label">Title</label>
							<input type="text" name="menu_title" class="item-title admin-listen-handler" data-handler="menuItemTitle" value="' . $item->title . '" placeholder="Title" data-id="' . $item->ID . '">
							<div class="classes-target">
								<div class="classes">
									<label>Classes</label>
									<input type="text" name="menu_classes" class="item-classes admin-listen-handler" data-handler="updateMenu" value="' . $classes . '" placeholder="Classes">
								</div>
								<div class="target">
									<label class="target-label">Target</label>
									<div class="select-box">
										<div class="sb-arrow"></div>
										<select name="menu_target">
											<option value="_blank">New Tab</option>
											<option value="_self">Same Tab/option>
										</select>
									</div>
								</div>
							</div>
							' . $url . '
							<div class="save-new-menu-item">
								<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="hideOptions">Save Changes</a>
							</div>
						</div>
					</li>
				';
			}
		} else {
			$notices = '
				<p class="notice-heading">No menu found</p>
				<div class="edit-menu-notice">
					<p class="no-menu">Looks like you don\'t have<br />a semplice menu yet.</p>
					<div class="save-new-menu-item">
						<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="create">Create Menu</a>
					</div>
				</div>
			';
			$hide_menu = ' hide';
		}

		// get pages, posts, projects
		$post_types = array('page', 'project', 'post');
		// select posts array
		$select_posts = array(
			'page' => '',
			'project' => '',
			'post' => '',

		);
		// iterate post types
		foreach ($post_types as $post_type) {
			$args = array(
				'posts_per_page' => -1,
				'post_type' => $post_type,
				'post_status' => 'publish',
			);
			$posts = get_posts($args);
			// pages there?
			if(is_array($posts)) {
				foreach ($posts as $key => $post) {
					$select_posts[$post->post_type] .= '<option data-post-id="' . $post->ID . '" value="' . $post->post_title . '">' . $post->post_title . '</option>';					
				}
			}
		}

		// output nav
		$output = '
			<div class="menu-notices">
				' . $notices . '
			</div>
			<div class="edit-menu-inner' . $hide_menu . '">
				<div class="add-new-item">
					<a class="add-menu-item admin-click-handler" data-handler="execute" data-action-type="menu" data-action="showAddItemDropdown">+ Add Menu Item</a>
					<p class="notice-heading">Edit menu item</p>
				</div>
				<nav class="menu-items">
					<ul class="semplice-edit-menu">
						' . $menu_html . '
					</ul>
				</nav>
				<div class="new-item-options">
					<p class="notice-heading">Add new item</p>
					<label class="first-label">Link Type</label>
					<div class="select-box menu-type-select">
						<div class="sb-arrow"></div>
						<select name="new_menu_item_type" data-input-type="select-box" class="admin-listen-handler new-menu-item-type" data-handler="changeMenuType">
							<option value="page">Page</option>
							<option value="project">Project</option>
							<option value="post">Post</option>
							<option value="custom">Custom</option>
						</select>
					</div>
					<div class="menu-item-type" data-type="custom">
						<label>Title</label>
						<input type="text" name="new_menu_item_title" class="new-menu-item new-menu-item-title" placeholder="Title">
						<label>Link</label>
						<input type="text" name="new_menu_item_link" class="new-menu-item" placeholder="http://www.semplicelabs.com">
					</div>
					<div class="menu-item-type" data-type="page">
						<label>Select page</label>
						<div class="select-box">
							<div class="sb-arrow"></div>
							<select name="new_menu_item_page" class="new-menu-item">
								' . $select_posts['page'] . '
							</select>
						</div>
					</div>
					<div class="menu-item-type" data-type="project">
						<label>Select project</label>
						<div class="select-box">
							<div class="sb-arrow"></div>
							<select name="new_menu_item_project" class="new-menu-item">
								' . $select_posts['project'] . '
							</select>
						</div>
					</div>
					<div class="menu-item-type" data-type="post">
						<label>Select post</label>
						<div class="select-box">
							<div class="sb-arrow"></div>
							<select name="new_menu_item_post" class="new-menu-item">
								' . $select_posts['post'] . '
							</select>
						</div>
					</div>
					<div class="save-new-menu-item">
						<a class="admin-click-handler cancel" data-handler="execute" data-action-type="menu" data-action="hideAddItemDropdown">Cancel</a>
						<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="add">Add Item</a>
						<svg class="semplice-spinner" width="30px" height="30px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
							<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
						</svg>
					</div>
				</div>
			</div>
		';

		// output
		return new WP_REST_Response($output, 200);
	}

	// activate menu
	public function activate_menu($request) {

		// add menu item and get id
		semplice_activate_menu();

		return new WP_REST_Response('Activated', 200);
	}

	// add menu item
	public function add_menu_item($request) {

		// add menu item and get id
		$id = semplice_add_menu_item($request['item']);

		return new WP_REST_Response($id, 200);
	}

	// delete menu item
	public function delete_menu_item($request) {
		// cceck if post is there
		if (false !== get_post_status($request['id'])) {
			wp_delete_post($request['id'], true);
		}

		return new WP_REST_Response('Delete menu item ' . $request['id'], 200);
	}

	// save menu
	public function save_menu($request) {
		// changed menu order?
		$output = semplice_update_menu_order($request['menu_order']);

		return new WP_REST_Response($output, 200);
	}

	// duplicate navigation
	public function duplicate_navigation($request) {

		$output = '
			<li id="' . $request['new_id'] . '" style="opacity: 0; transform: scale(.8);">
				<a class="navigation ' . $request['preset'] . $request['last_in_row'] . '" href="#customize/navigations/edit/' . $request['new_id'] . '">
					<img alt="preset-two bg" class="preset-bg-img" src="' . get_template_directory_uri() . '/assets/images/admin/navigation/' . $request['preset_url'] . '_full.png">
					<p>' . $request['name'] . '</p>
				</a>
				<div class="edit-nav-hover">
					<ul>
						<li>
							<a class="navigation-duplicate" href="#customize/navigations/edit/' . $request['new_id'] . '">' . get_svg('backend', '/icons/icon_edit') . '</a>
							<div class="tooltip tt-edit">Edit</div>
						</li>
						<li>
							<a class="navigation-remove admin-click-handler" data-handler="execute" data-action="duplicate" data-setting-type="navigations" data-action-type="customize" data-nav-id="' . $request['new_id'] . '">' . get_svg('backend', '/icons/post_duplicate') . '</a>
							<div class="tooltip tt-remove">Remove</div>
						</li>
						<li>
							<a class="navigation-duplicate admin-click-handler" data-handler="execute" data-action="removePopup" data-setting-type="navigations" data-action-type="customize" data-nav-id="' . $request['new_id'] . '">' . get_svg('backend', '/icons/icon_delete') . '</a>
							<div class="tooltip tt-duplicate">Duplicate</div>
						</li>
						<li>
							<a class="navbar-default" data-nav-id="' . $request['new_id'] . '">' . get_svg('backend', '/icons/save_checkmark') . '</a>
							<div class="tooltip tt-default">Default</div>
						</li>
					</ul>
				</div>
			</li>
		';
		
		return new WP_REST_Response($output, 200);
	}

	// get post settings
	public function edit_navigation($request) {

		// vars
		$output = $this->customize['navigations']->get('both', $request['content'], true, false);

		// return settings
		return new WP_REST_Response($output, 200);
	}

	// get post settings
	public function get_post_settings($request) {

		// vars
		$output = array(
			'settings' => '',
			'footer'   => semplice_get_post_dropdown('footer'),
		);
		$post_id = $request['post_id'];
		$row = $this->db->get_row("SELECT settings, wp_changes FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = 'latest_version'");
		
		// get post
		$post = get_post($post_id);

		// get post settings from the meta options
		$post_settings = json_decode(get_post_meta($post_id, '_semplice_post_settings', true), true);

		// set wp changes to true
		$wp_changes = true;
		
		// check if array
		if(!is_array($post_settings)) {
			$post_settings = false;
			$wp_changes = false;
		}

		// get post settings
		$output['settings'] = semplice_generate_post_settings($post_settings, $post, $wp_changes);

		// return settings
		return new WP_REST_Response($output, 200);
	}

	// publish post settings
	public function publish_post_settings($request) {

		// save post settings
		$args = $this->editor->save_post_settings($request, 'save-to-wp');

		// update post args
		$args['ID'] = $request['post_id'];

		// update latest version revision
		$this->db->update(
			$this->rev_table_name, 
			array(
				"settings"		=> $this->editor->save_post_settings($request, 'save'),
				"wp_changes"	=> true
			),
			array(
				"post_id" 		=> $request['post_id'],
				"revision_id"	=> 'latest_version'
			)
		);

		// update post
		wp_update_post($args);

		// is dashboard?
		if($request['active_page'] == 'dashboard') {
			// set post settings
			$request['is_post_settings'] = true;
			$output = array(
				'html' => $this->dashboard($request, true)
			); 
		} else {
			$output = semplice_get_posts($request);
		}

		return new WP_REST_Response($output, 200);
	}

	// add category
	public function add_category($request) {

		// define output
		$output = array();

		// return id of new category
		//$output['id'] = wp_create_category($request['name'], );

		$output['id'] = wp_insert_term($request['name'], 'category', $args = array('parent' => $request['parent']));

		// get updated list of category dropdown
		$output['dropdown'] = '<div class="select-box"><div class="sb-arrow"></div>' . wp_dropdown_categories('hide_empty=0&echo=0&depth=5&hierarchical=1') . '</div>';

		return new WP_REST_Response($output, 200);
	}

	// save portfolio order
	public function save_portfolio_order($request) {

		// get settings and add or remove slashes
		$order = $request['portfolio_order'];

		// save settings in the DB
		update_option('semplice_portfolio_order', $order);

		return new WP_REST_Response('saved', 200);
	}

	// license save
	public function license_save($request) {
		// check license
		$output = semplice_save_license($request['key'], $request['product']);
		// return
		return new WP_REST_Response($output, 200);
	}

	// activate semplice
	public function activate_semplice($request) {
		// created with s4 admin so per default set is semplice to true
		update_post_meta($request['post_id'], '_is_semplice', true, '');
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

	// update post status
	public function update_post_status($request) {
		// update
		if(false !== get_post_status($request['id'])) {
			// change post status
			wp_update_post(array(
				'ID' => $request['id'],
				'post_status' => $request['status'],
			));
		}
		// return
		return new WP_REST_Response('Status Update', 200);
	}

	// enable transitions
	public function enable_transitions($request) {
		// get custmomize advanced
		$settings = json_decode(get_option('semplice_settings_general'), true);
		// chnage setting
		$settings['frontend_mode'] = 'dynamic';
		// save again
		update_option('semplice_settings_general', json_encode($settings));
		// return
		return new WP_REST_Response('Motions enabled.', 200);
	}

	// -----------------------------------------
	// check nonce and admin rights
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
// build instance of semplice api
// -----------------------------------------

$admin_api = new admin_api();

?>