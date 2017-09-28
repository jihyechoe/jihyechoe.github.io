<?php

// -----------------------------------------
// semplice
// /includes/content.php
// -----------------------------------------

// include editor
require get_template_directory() . '/includes/blog.php';

class semplice_get_content extends semplice_blog {

	// public vars
	public $db, $editor, $rev_table_name;

	// constructor
	public function __construct() {

		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// editor api
		global $editor_api;
		$this->editor = $editor_api;
	}

	// get content main function
	public function get($post_id, $is_preview, $paged, $taxonomy) {

		// get is_semplice status
		$is_semplice = get_post_meta($post_id, '_is_semplice', true);

		// if taxonomy is set, set post id to posts
		if(false !== $taxonomy) {
			$post_id = 'posts';
		}

		// post exists?
		if($post_id != 'notfound') {
			// is blog overview?
			if($post_id == 'posts') {
				// show latest blog posts
				$output = $this->posts($taxonomy, $paged);
			} else {
				// is semplice activated?
				if($is_semplice) {
					// load content from the semplice editor
					$output = $this->semplice($post_id, $is_preview);
				} else {
					// load wordpress wysiwyg content
					$output = $this->post($post_id, $is_preview);
				}
			}
		} else {
			// show 404
			$output = $this->default_content('not-found');
		}

		// set semplice status
		if(is_array($output)) {
			if($is_semplice) {
				$output['is_semplice'] = true;
			} else {
				$output['is_semplice'] = false;
			}
		}
		
		// return output
		return $output;
	}

	// default content
	public function default_content($type) {

		// set atts
		switch($type) {
			case 'empty-preview':
				$output = array(
					'css'  => 'body { background: #eeeeee; }',
					'html' => '<div class="no-content">Empty content<br /><span>Before getting a preview of your page or project please add<br /> some content in our editor, save it and hit preview again.</span></div>',
				);
			break;
			case 'empty-posts':
				$output = array(
					'css'  => 'body { background: #eeeeee; }',
					'html' => '<div class="no-content">No posts<br /><span>You have no posts in your blog. Start adding some posts in your dashboard.</span></div>',
				);
			break;
			case 'not-found':
				$output = array(
					'css'  => 'body { background: #eeeeee; }',
					'html' => '<div class="no-content">404 - Not found<br /><span>This page could not be found.<br />Continue to the <a href="' . home_url() . '">Homepage</a></span></div>',
				);
			break;
			case 'empty-semplice':
				$output = array(
					'css'  => 'body { background: #eeeeee; }',
					'html' => '<div class="no-content">Empty content<br /><span>It appears that you have a totally empty page. Please visit our editor and add some content to your page.</span></div>',
				);
			break;
		}

		// add sections wrap
		$output['html'] = '<section class="content-block">' . $output['html'] . '</section>';

		// return output
		return $output;	
	}

	// get semplice content
	public function semplice($post_id, $is_preview) {
		// get ram
		$ram = $this->get_ram($post_id, $is_preview);

		// is coverslider
		$is_coverslider = semplice_boolval(get_post_meta($post_id, '_is_coverslider', true));

		// check if ram is not empty
		if(null !== $ram) {
			// get content from ram
			if(isset($ram['order']) && !empty($ram['order']) || true === $is_coverslider) {
				// check if there is only a non visible cover
				if($this->has_content($ram['order'], $ram) || true === $is_coverslider) {
					// add post id to ram
					$ram['post_id'] = $post_id;
					// get content
					$output = $this->editor->get_content($ram, 'frontend', false, $is_coverslider);
					// add motion css
					if(!empty($output['motion_css'])) {
						$output['css'] .= $output['motion_css'];
					}
				} else {
					$output = $this->default_content('empty-semplice');
				}
				
			} else {
				$output = $this->default_content('empty-semplice');
			}
			// add branding
			if(isset($ram['branding'])) {
				$output['branding'] = $ram['branding'];
			}
			// format output
			remove_filter('the_content', 'wpautop');
			$output['html'] = apply_filters('the_content', $output['html']);
		} else if($is_preview) {
			// show empty preview
			$output = $this->default_content('empty-preview');
		} else {
			$output = $this->default_content('empty-semplice');
		}

		// add foter
		$output = $this->content_footer($output, $post_id);

		// output
		return $output;
	}

	// get blog posts
	public function posts($taxonomy, $page_num) {

		// posts per page
		$posts_per_page = get_option('posts_per_page');

		// pagination
		if($page_num == 0) {
			$page_num = 1;
		}

		// check if auth
		$args = array(
			'posts_per_page' => $posts_per_page,
			'offset'		 => ($page_num - 1) * $posts_per_page,
			'post_type' 	 => 'post',
		);

		// taxonomy?
		if($taxonomy) {
			if($taxonomy->taxonomy == 'category') {
				$args['category__in'] = $taxonomy->term_id;
			} else {
				$args['tag'] = $taxonomy->name;
			}
		}

		// blog overview
		$output = $this->loop($args, $page_num, $taxonomy, false);

		// add foter
		$output = $this->content_footer($output, false);

		// return output
		return $output;
	}

	// get single post
	public function post($post_id, $is_preview) {
		// get post type
		$post_type = get_post_type($post_id);
		// check if auth
		$args = array(
			'p'				 => $post_id,
			'posts_per_page' => 1,
			'post_type' 	 => $post_type,
		);
		// get post
		$output = $this->loop($args, 1, false, true);
		// add foter
		$output = $this->content_footer($output, false);
		// return
		return $output;
	}

	// has content?
	public function has_content($sections, $content) {

		// default set to false
		$has_content = false;
		$sections_count = count($sections);

		// more than 1 unit + cover?
		if($sections_count > 1) {
			$has_content = true;
		}

		// is only 1 section but has a visible cover?
		if($sections_count == 1 && isset($content['cover']) && isset($content['cover_visibility']) && $content['cover_visibility'] == 'visible') {
			$has_content = true;
		}

		// only 1 section but not a cover
		if($sections_count == 1 && !isset($sections['cover'])) {
			$has_content = true;
		}

		// return
		return $has_content;
	}

	// footer
	public function content_footer($output, $post_id) {

		// set footer id to false
		$footer_id = false;

		// set footer motions to false per default
		$parent_motions = false;

		if(isset($output['branding']['scroll_reveal']) && $output['branding']['scroll_reveal'] == 'disabled') {
			$parent_motions = true;
		}

		// if semplice look in the post settings
		if(false !== $post_id) {
			$post_settings = json_decode(get_post_meta($post_id, '_semplice_post_settings', true), true);
			if(is_array($post_settings) && isset($post_settings['meta']['footer'])) {
				$footer_id = $post_settings['meta']['footer'];
			}
		}

		// if no footer in post settings try to get global
		if(false === $footer_id) {
			// get global footer
			$advanced = json_decode(get_option('semplice_customize_advanced'), true);

			// is array?
			if(is_array($advanced)) {
				// get global footer
				if(isset($advanced['global_footer'])) {
					$footer_id = $advanced['global_footer'];
				}
			}
		}

		if(false !== $footer_id) {

			// get ram
			$ram = $this->get_ram($footer_id, false);

			// is ram?
			if(null !== $ram) {

				// get content
				$content = $this->editor->get_content($ram, 'frontend', false, false);

				// format footer output
				remove_filter('the_content', 'wpautop');
				$content['html'] = apply_filters('the_content', $content['html']);

				// add motion css if there and motion is enabled in parent
				if(!empty($content['motion_css']) && true === $parent_motions) {
					$output['css'] .= $content['motion_css'];
				}
			
				foreach ($content as $type => $value) {
					if(isset($output[$type])) {
						if($type != 'js' || $type == 'js' && true === $parent_motions) {
							$output[$type] .= $content[$type];
						}
					}
				}
			}
		}
		return $output;
	}

	// get ram
	public function get_ram($post_id, $is_preview) {
		// if preview, load revision
		if($is_preview) {
			// rev table name
			$this->rev_table_name = $this->db->prefix . 'semplice_revisions';
			// get ram
			$ram = $this->db->get_var("SELECT content FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = 'latest_version'");
			// json decode
			$ram = json_decode($ram, true);
		} else {
			// load content from post meta if not a preview
			$ram = json_decode(get_post_meta($post_id, '_semplice_content', true), true);
		}
		// return
		return $ram;
	}
}

// -----------------------------------------
// build instance of content class
// -----------------------------------------

$semplice_get_content = new semplice_get_content();

?>