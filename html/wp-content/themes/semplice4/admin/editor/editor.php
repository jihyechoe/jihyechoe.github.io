<?php

// -----------------------------------------
// semplice
// admin/editor/editor.php
// -----------------------------------------

class editor {

	// public vars
	public $db;
	public $rev_table_name;
	public $rev_db_version;
	public $module_api;

	public function __construct() {

		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// db version
		$this->rev_db_version = get_option("semplice_revisions_rev_db_version");

		// add action
		add_action('after_switch_theme', array(&$this, 'revisions_status'));

		// include module api
		require get_template_directory() . '/admin/editor/module.php';
	}

	// -----------------------------------------
	// duplicate
	// -----------------------------------------
	
	public function generate_duplicate($request) {

		// output module
		$output = array();

		// vars
		$content = $this->check_slashes($request['content']);
		$ram = json_decode($content, true);

		// set mode to editor
		$ram['visibility'] = 'editor';

		// mode
		switch($request['mode']) {
			case 'section':

				// get section content
				$section_output = $this->module_api->generate_output($ram, $request['section_id'], $ram['order'][$request['section_id']], 'enabled');

				// add to html output
				$output['html'] = $section_output['html'];

				// add to css output
				$output['css'] = $section_output['css'];

			break;
			case 'column':
				// get column content
				$column_output = $this->module_api->column_iterate($ram, $request['id'], $ram['order']);
				// add to html output
				$output['html'] = $column_output['html'];
				// css output
				$output['css'] = $column_output['css'];

			break;
			case 'content':

				// set values
				$values = array(
					'module_name' => $ram['module'],
					'content_id'  => $request['id'],
					'content'	  => $ram
				);

				// get content
				$content = $this->module_api->content($values, $ram['visibility'], true);

				// output html
				$output['html'] = $content['html'];

				// add css output
				$output['css'] = $content['css'];

			break;
		}

		// output
		return $output;
	}

	// -----------------------------------------
	// get content
	// -----------------------------------------

	public function get_content($ram, $visibility, $is_block, $is_coverslider) {

		// output
		$output = array(
			'html'   		=> '',
			'css'	 		=> '',
			'motion_css'	=> '',
			'js'	 		=> '',
			'motion' => array(
				'on_load'   => '',
				'on_scroll' => '',
				'on_hover'  => '',
				'on_click'  => '',
			),
		);

		// is coverslider?
		if(true === $is_coverslider) {
			// get coverslider
			$coverslider = semplice_get_coverslider($ram['coverslider'], $visibility);
			// add to output
			$output['html'] = $coverslider['html'];
			$output['css'] = $coverslider['css'];
		} else {
			// sr status
			$sr_status = 'enabled';

			if(isset($ram['branding']['scroll_reveal']) && $ram['branding']['scroll_reveal'] == 'disabled') {
				// set sr status
				$sr_status = 'disabled';
				// js output start
				$output['js']  .= '(function ($) { "use strict";';
			}

			// get cover visibility
			$cover_visibility = isset($ram['cover_visibility']) ? $ram['cover_visibility'] : 'hidden';

			// is cover?
			if(isset($ram['cover'])) {
				$is_cover = true;
			} else {
				$is_cover = false;
			}

			// show default cover if not there
			if($visibility == 'editor' && false === $is_cover && false === $is_block) {
				$output['html'] .= semplice_default_cover($cover_visibility);
			}

			// iterate order
			foreach($ram['order'] as $section_id => $section) {

				// set mode to ram
				if($visibility == 'editor') {
					$ram['visibility'] = 'editor';	
				} else {
					$ram['visibility'] = 'frontend';
				}
				
				// show cover on editor or on ftontend if visible
				if($section_id != 'cover' || $visibility == 'editor' || $this->has_cover($section_id, $ram['visibility'], $is_cover, $cover_visibility)) {
			
					// get section content
					$section_output = $this->module_api->generate_output($ram, $section_id, $section);

					// add to html output
					$output['html'] .= $section_output['html'];

					// add to css output
					$output['css'] .= $section_output['css'];

					// is scroll reveal deactivated
					if($sr_status == 'disabled' && $visibility != 'editor') {
						// add motion css
						$output['motion_css'] .= $section_output['motion']['css'];

						// add to js output
						$events = array('on_load', 'on_scroll', 'on_hover', 'on_click');
						foreach ($events as $key => $event) {
							if(isset($section_output['motion']['js'][$event])) {
								$output['motion'][$event] .= $section_output['motion']['js'][$event];
							}
						}
					}
				}
			}

			// scroll reveal
			if($sr_status == 'disabled' && $visibility != 'editor') {
				// add scroll magic controller if onscroll is not empty
				if(!empty($output['motion']['on_scroll'])) {
					$output['js'] .= 'var animationsController = new ScrollMagic.Controller(); ' . $output['motion']['on_scroll'];
				}

				// motion on scroll events
				$output['js'] .= '$(window).on("scroll", function() { ' . $output['motion']['on_load'] . '}); $(window).scroll();';

				// motion on click events
				$output['js'] .= $output['motion']['on_click'];

				// motion on hover events
				$output['js'] .= $output['motion']['on_hover'];

				// js output end
				$output['js'] .= '})(jQuery);';
			}
			
			// remove motion since its not need anymore
			unset($output['motion']);

			// branding
			if(!empty($ram['branding'])) {
				// branding css
				if($visibility == 'editor') {
					$output['css'] .= $this->module_api->container_styles('branding', $ram['branding'], '#content-holder');
				} else {
					$output['css'] .= $this->module_api->container_styles('branding', $ram['branding'], 'body');
					// additional branding
					$output['css'] .= $this->branding($ram['branding'], $is_cover);
				}
			}
		}

		// output
		return $output;
	}

	// -----------------------------------------
	// navigator
	// -----------------------------------------

	public function navigator() {
		
		$output = '
		<div class="inner">
			<div class="exit-ce">
				<a class="editor-action semplice-button exit-button semplice-navigator-hover" data-action="exit" data-action-type="popup"><span>' . get_svg('backend', 'icons/exit_arrow') . '</span> Back to Dashboard</a>
			</div>
			<h3 class="pages-projects-heading">Pages &amp; Projects</h3>
			<div class="posts">
				<div class="pages">
					<h4><a data-new-url="#content/pages/1" data-exit-mode="close" class="editor-action" data-action-type="popup" data-action="exit">Pages</a></h4>
					<ul>';
							// list projects
							global $post;
							
							// args
							$pages_args = array(
								'sort_order' 		=> 'ASC',
								'post_type' 		=> 'page',
								'post_status' 		=> 'publish,private,draft',
								'posts_per_page'   	=> -1,
							);

							$pages = get_posts($pages_args);
							
							if($pages) {
								foreach($pages as $page) {
									// truncate title	
									$title_truncated = (strlen($page->post_title) > 24) ? substr($page->post_title, 0, 24) . '...' : $page->post_title;
									// output list element					
									$output .= '<li><a data-new-url="#edit/' . $page->ID . '" data-reopen="#edit/' . $page->ID . '" data-exit-mode="re-open" class="editor-action" data-action-type="popup" data-action="exit">' . $title_truncated . '</a></li>';
								}
							}
			$output .= '
					</ul>
				</div>
				<div class="projects">
					<h4><a data-new-url="#content/projects/1" data-exit-mode="close" class="editor-action" data-action-type="popup" data-action="exit">Projects</a></h4>
					<ul>';
							// list projects
							global $post;
							
							// args
							$project_args = array(
								'sort_order' 		=> 'ASC',
								'post_type' 		=> 'project',
								'post_status' 		=> 'publish,private,draft',
								'posts_per_page'   	=> -1,
							);

							$projects = get_posts($project_args);
							
							if($projects) {
								foreach($projects as $project) {
									// truncate title	
									$title_truncated = (strlen($project->post_title) > 24) ? substr($project->post_title, 0, 24) . '...' : $project->post_title;
									// output list element									
									$output .= '<li><a data-new-url="#edit/' . $project->ID . '" data-reopen="#edit/' . $project->ID . '" data-exit-mode="re-open" class="editor-action" data-action-type="popup" data-action="exit">' . $title_truncated . '</a>';
								}
							}
			$output .= '
					</ul>
				</div>
			</div>
			<h3>Customize</h3>
			<div class="navigator-customize">
				' . semplice_get_customize_nav('customize', 'navigator') . '
			</div>
			<h3 class="settings-heading">Settings</h3>
			<div class="navigator-customize">
				' . semplice_get_customize_nav('settings', 'navigator') . '
			</div>
		</div>
		';
		return $output;
	}

	// -----------------------------------------
	// branding
	// -----------------------------------------

	public function branding($options) {

		// define css
		$css = '';

		// display content
		if(isset($options['display_content']) && $options['display_content'] == 'top') {
			$css .= '#content-holder .sections { margin-top: 0px !important; }';
		}
		// top arrow colo
		if(isset($options['top_arrow_color'])) {
			$css .= '.back-to-top a svg { fill: ' . $options['top_arrow_color'] . '; }';
		}
		// custom css
		if(isset($options['custom_post_css'])) {
			$css .= $options['custom_post_css'];
		}
		// return
		return $css;
	}

	// -----------------------------------------
	// revisions
	// -----------------------------------------

	public function revisions_status() {

		// atts
		$atts = array(
			'rev_db_version' => '1.0',
			'is_update'  	 => false,
			'sql'		 	 => ''
		);

		// check if table is already created
		if($this->db->get_var("SHOW TABLES LIKE '$this->rev_table_name'") !== $this->rev_table_name || $this->rev_db_version !== $atts['rev_db_version']) {
			
			// setup revisions (install or update)
			$this->setup_revisions($atts);
		}
	}

	// -----------------------------------------
	// setup revisions
	// -----------------------------------------

	public function setup_revisions($atts) {

		// charset
		$charset_collate = $this->db->get_charset_collate();

		// database tables
		$atts['sql'] = "CREATE TABLE $this->rev_table_name (
				ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				post_id bigint(20) NOT NULL,
				revision_id tinytext NOT NULL,
				revision_title tinytext NOT NULL,
				content longtext NOT NULL,
				settings longtext NOT NULL,
				wp_changes boolean NOT NULL,
				PRIMARY KEY (ID)
			) $charset_collate;";

		// install or update table
		if (!function_exists('revisions_db_install')) {
			function revisions_db_install($atts) {
		
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				
				dbDelta($atts['sql']);

				if($atts['is_update'] !== true) {
					// add db version to wp_options
					add_option('semplice_revisions_rev_db_version', $atts['rev_db_version']);
				} else {
					// update db version in wp_optionss
					update_option('semplice_revisions_rev_db_version', $atts['rev_db_version']);
					echo "ist ein update!!";
				}
			}
		}
		
		// check if table exists, if not install table
		if($this->db->get_var("SHOW TABLES LIKE '$this->rev_table_name'") !== $this->rev_table_name) {

			revisions_db_install($atts);
			
		}

		if ($this->rev_db_version !== $atts['rev_db_version']) {

			// is update
			$atts['is_update'] = true;
			
			// update db
			revisions_db_install($atts);
			
		}
	}

	// -----------------------------------------
	// has cover?
	// -----------------------------------------

	public function has_cover($id, $mode, $is_cover, $visibility) {
		// is id cover and cover is created?
		if($id == 'cover' && true === $is_cover) {
			// is editor, always show it
			if($mode == 'editor') {
				$has_cover = true;
			} else if($mode == 'frontend' && $visibility == 'visible') {
				$has_cover = true;
			} else {
				$has_cover = false;
			}
		} else {
			$has_cover = false;
		}
		return $has_cover;
	}
}

?>