<?php

// -----------------------------------------
// semplice
// admin/editor/modules/portfoliogrid/module.php
// -----------------------------------------

if(!class_exists('sm_portfoliogrid')) {

	class sm_portfoliogrid {

		public $output;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
		}

		// output frontend
		public function output_editor($values, $id) {

			// extract options
			extract( shortcode_atts(
				array(
					'hor_gutter'				=> 30,
					'ver_gutter'				=> 30,
					'categories'				=> '',
					'title_visibility'			=> 'both',
					'title_color'				=> '#000000',
					'title_fontsize'			=> '16px',
					'title_font'				=> 'regular',
					'title_text_transform'		=> 'none',
					'category_color'			=> '#999999',
					'category_fontsize'			=> '14px',
					'category_font'				=> 'regular',
					'category_text_transform'	=> 'none',
				), $values['options'] )
			);

			// get portfolio order
			$portfolio_order = json_decode(get_option('semplice_portfolio_order'));

			// get projects
			$projects = semplice_get_projects($portfolio_order, $categories);

			// get thumb hover options
			$global_hover_options = json_decode(get_option('semplice_customize_thumbhover'), true);

			// are there any published projects
			if(!empty($projects)) {

				// gutter numeric?
				if(!is_numeric($hor_gutter)) { $hor_gutter = 30; }
				if(!is_numeric($ver_gutter)) { $ver_gutter = 39; }

				// generate items
				$masonry_items = '';

				// add to css
				$add_to_css = semplice_thumb_hover_css(false, $global_hover_options, true, '#content-holder');

				foreach ($projects as $key => $project) {		

					if(empty($project['image']['width'])) {
						$project['image']['width'] = 6;
					}

					// thumb hover css if custom thumb hover is set
					if(isset($project['thumb_hover'])) {
						$add_to_css .= semplice_thumb_hover_css('project-' . $project['post_id'], $project['thumb_hover'], false, '#content-holder');
					}

					// show post settings link on admin
					if(isset($values['is_frontend']) && true === $values['is_frontend']) {
						$thumb_inner = '<a href="' . $project['permalink'] . '">' . $this->get_thumb_inner($id, $global_hover_options, $project, true) . '</a>';
					} else {
						$thumb_inner = $this->get_thumb_inner($id, $global_hover_options, $project, false);
					}

					// masonry items open
					$masonry_items .= '<div id="project-' . $project['post_id'] . '" class="masonry-item thumb masonry-' . $id . '-item" data-xl-width="' . $project['image']['grid_width'] . '" data-sm-width="6" data-xs-width="12">';

					// add thumb inner
					$masonry_items .= $thumb_inner;

					// title and category
					if($title_visibility == 'both') {
						$masonry_items .= '
							<p class="post-title"><a class="' . $title_font . '" href="' . $project['permalink'] . '" title="' . $project['post_title'] . '">' . $project['post_title'] . '<span class="' . $category_font . '">' . $project['project_type'] . '</span></a></p>
						'; 
					} else if($title_visibility == 'title') {
						$masonry_items .= '
							<p class="post-title"><a class="' . $title_font . '" href="' . $project['permalink'] . '" title="' . $project['post_title'] . '">' . $project['post_title'] . '</a></p>
						'; 
					} else if($title_visibility == 'category') {
						$masonry_items .= '
							<p class="post-title"><a class="' . $title_font . '" href="' . $project['permalink'] . '" title="' . $project['post_title'] . '"><span class="' . $category_font . '">' . $project['project_type'] . '</span></a></p>
						'; 
					}

					// masonry items close
					$masonry_items .= '</div>';
				}

				// add to css
				$add_to_css .= '#' . $id . ' .thumb .post-title a { color: ' . $title_color . '; font-size: ' . $title_fontsize . '; text-transform: ' . $title_text_transform . '; } #' . $id . ' .thumb .post-title a span { color: ' . $category_color . '; font-size: ' . $category_fontsize . '; text-transform: ' . $category_text_transform . '; }';

				// get masonry
				$this->output['html'] = semplice_masonry($id, $masonry_items, $hor_gutter, $ver_gutter, $add_to_css);
			} else {
				$this->output['html'] = '<div class="empty-portfolio"><img src="' . get_template_directory_uri() . '/assets/images/admin/noposts.svg" alt="no-posts"><h3>Looks like you have an empty Portfolio. Please note that only<br />published projects are visible in the portfolio grid.</h3></div>';
			}

			// output
			return $this->output;
		}

		public function get_thumb_inner($id, $global_hover_options, $project, $is_frontend) {

			$post_settings = '';

			if(false === $is_frontend) {
				$post_settings = '<a class="admin-click-handler grid-post-settings" data-content-id="' . $id . '" data-handler="execute" data-action-type="postSettings" data-action="getPostSettings" data-post-id="' . $project['post_id'] . '" data-ps-mode="grid" data-post-type="project" data-thumbnail-src="' . $project['image']['src'] . '">' . get_svg('backend', '/icons/post_settings') . '</a>';
			}

			return '
				<div class="thumb-inner">
					' . semplice_thumb_hover_html($global_hover_options, $project, $is_frontend) . '
					' . $post_settings . '
					<img src="' . $project['image']['src'] . '" width="' . $project['image']['width'] . '" height="' . $project['image']['height'] . '">
				</div>
			';
		}

		// output frontend
		public function output_frontend($values, $id) {

			// same as editor
			$values['is_frontend'] = true;
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['portfoliogrid'] = new sm_portfoliogrid;
}