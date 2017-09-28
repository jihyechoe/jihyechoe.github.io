<?php

// -----------------------------------------
// get posts
// -----------------------------------------

function semplice_get_posts($request) {
	// output
	$output = array('html' => '', 'empty_state' => '');

	// get post count
	$post_count = wp_count_posts($request['post_type']);
	$count = 0;

	// pubslihed posts
	if(isset($post_count->publish))
		$count = $count + $post_count->publish;

	// drafts
	if(isset($post_count->draft))
		$count = $count + $post_count->draft;

	// pending posts
	if(isset($post_count->pending))
		$count = $count + $post_count->pending;

	// private posts
	if(isset($post_count->private))
		$count = $count + $post_count->private;

	// posts per page
	$posts_per_page = 20;

	// pagination
	if($request['page'] != 'show-all') {
		$page_num = intval($request['page']);
	} else {
		$page_num = 1;
		$posts_per_page = -1;
	}
	
	if($page_num == 0) {
		$page_num = 1;
	}

	// get pagination
	$pagination = ceil($count / $posts_per_page);
	$pagination_html = '';

	// is page num allowed?
	if($page_num >= $pagination && $request['page'] != 'show-all') {
		$page_num = $pagination;
	}

	if(is_numeric($pagination) && $pagination > 1) {

		// vars
		$active_prev = '';
		$active_next = '';

		// make prev inactive
		if($page_num == 1) {
			$active_prev = 'inactive';
		}

		//make next inactive
		if($page_num == $pagination) {
			$active_next = 'inactive';
		}

		//pagination html
		// temp <input type="number" class="admin-listen-handler" data-handler="changePage" value="' . $page_num . '" data-url="content/' . $request['post_type'] . 's/">
		$pagination_html .= '
			<div class="semplice-pagination">
				<ul>
					<li>
					<a class="show-all" href="#content/pages/show-all">Show all</a>
					</li>
					<li>
						<a href="#content/pages/' . ($page_num-1) . '" id="nav-pages" class="' . $active_prev . ' prev">' . get_svg('backend', '/icons/pages_prev') . '</a>
					</li>
					<li>
						<span>' . $page_num . ' / ' . $pagination . '</span>
					</li>
					<li>
						<a href="#content/pages/' . ($page_num+1) . '" id="nav-pages" class="' . $active_next . ' next">' . get_svg('backend', '/icons/pages_next') . '</a>
					</li>
				</ul>
			</div>
		';
	}

	// active page num
	$output['page_num'] = $page_num;

	// check if auth
	$args = array(
		'posts_per_page' => $posts_per_page,
		'offset'		 => ($page_num - 1) * $posts_per_page,
		'post_type' 	 => $request['post_type']
	);

	// on project pages, show all per default
	if($request['post_type'] == 'project') {
		// posts per page for dashboard
		$args['posts_per_page'] = -1;
		// get portfolio order
		$output['portfolio_order'] = json_decode(get_option('semplice_portfolio_order'));
		// empty pagination
		$pagination_html = '';
	}

	// get posts
	$posts = wp_get_recent_posts($args);

	// posts top row
	$posts_top_row = '';
	if($request['post_type'] != 'project') {
		$posts_top_row = '
			<div class="posts-list">
				<div class="posts-top-row admin-row">
					<div class="admin-column" data-xl-width="5"><span class="post-title">Title</span></div>
					<div class="admin-column" data-xl-width="2">Status</div>
					<div class="admin-column" data-xl-width="2">Updated</div>
				</div>
		';
	} else {
		$posts_top_row = '
			<div class="projects-list admin-row">
		';
	}

	if(!$posts) {
		$output['html'] .= 'nopost';
		// empty state
		$output['empty_state'] = '
			<div class="no-posts">
				<div class="np-illustration">
					<img src="' . get_template_directory_uri() . '/assets/images/admin/noposts.svg" alt="no-posts-illustration">
					<h3>You are short on content.</h3>
					<a class="admin-click-handler semplice-button" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="' . $request['post_type'] . '">Create New ' . $request['post_type'] . '</a>
				</diV>
			</div>
		';
	} else {
		// header
		$header = '
			<div class="admin-row">
				<div class="sub-header admin-column">
					<h2 class="admin-title">All ' . ucfirst($request['post_type']) . 's</h2>
					<a class="admin-click-handler semplice-button" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="' . $request['post_type'] . '">Add New ' . $request['post_type'] . '</a>
					' . semplice_save_spinner() . '
					' . $pagination_html . '
				</div>
			</div>
		';
		// hide heater?
		if(isset($request['hide_row_header']) && true === $request['hide_row_header']) {
			$header = '';
		}
		// iterate post
		$output['html'] .= '
			<div class="' . $request['post_type'] . 's posts admin-container">
				' . $header . '
				' . $posts_top_row . '
		';

		// define post status
		$post_status = '';

		foreach ($posts as $key => $post) {

			// is semplice?
			$is_semplice = get_post_meta($post['ID'], '_is_semplice', true);

			// get thumbnail
			if($request['post_type'] == 'project') {
				$thumbnail = semplice_get_thumbnail($post['ID']);
			} else {
				$thumbnail = false;
			}

			// format post
			$output['html'] .= semplice_post_row($post['ID'], $request['post_type'], $post['post_title'], $post['post_status'], false, $thumbnail, $is_semplice, $post['post_name']);
		}

		// close post list
		$output['html'] .= '</div>';

		// add pagination
		$output['html'] .= $pagination_html;

		// close admin row
		$output['html'] .= '</div>';
	}
	return $output;
}
// -----------------------------------------
// get dashboard projects
// -----------------------------------------

function semplice_dashboard_projects() {

	// output
	$output = '';

	// get latest 3 projects
	$args = array(
		'posts_per_page' => 3,
		'post_type' 	 => 'project'
	);

	// get posts
	$posts = wp_get_recent_posts($args);

	foreach ($posts as $key => $post) {

		// is semplice?
		$is_semplice = get_post_meta($post['ID'], '_is_semplice', true);

		// get thumbnail
		$thumbnail = semplice_get_thumbnail($post['ID']);

		// format post
		$output .= semplice_post_row($post['ID'], 'project', $post['post_title'], $post['post_status'], false, $thumbnail, $is_semplice, $post['post_name']);
	}

	// return
	return $output;
}

// -----------------------------------------
// get post row
// -----------------------------------------

function semplice_post_row($post_id, $post_type, $post_title, $post_status, $is_duplicate, $thumbnail, $is_semplice, $slug) {

	// output
	$output = '';
	$is_semplice_class = '';
	$activate_semplice = '';

	// get front page and blogpage
	if(get_option('page_on_front') == $post_id) {
		$front_or_posts = ' <span class="semibold">&mdash; Front Page</span>';
	} else if(get_option('page_for_posts') == $post_id) {
		$front_or_posts = ' <span class="semibold">&mdash; Blog Page</span>';
	} else {
		$front_or_posts = '';
	}

	if(isset($is_duplicate) && $is_duplicate === true) {
		$css = 'style="opacity: 0; transform: translateY(-30px) scale(.9);"';
	} else {
		$css = '';
	}

	// is pusblished?
	if($post_status == 'publish') {
		$post_status = 'published';
	}

	// check if post title is empty
	if(empty($post_title)) {
		$post_title = 'Untitled';
	} else {
		// post title
		$lenght = 40;
		if($post_type == 'project') {
			$lenght = 24;
		}
		$post_title = (strlen($post_title) > $lenght) ? substr($post_title, 0, $lenght) . '...' : $post_title;
	}

	// is semplice
	if(!$is_semplice) {
		$is_semplice_class = ' no-semplice';
		$activate_semplice = '<a class="edit-with-semplice semplice-button green-button admin-click-handler"  data-post-id="' . $post_id . '" data-handler="execute" data-action-type="popup" data-action="activateSemplice">Edit with Semplice</a>';
	}

	if($post_type == 'project') {
		// thumbnail
		if(!empty($thumbnail['src'])) {
			$thumbnail_html = '
				<div class="thumbnail" style="background-image: url(' . $thumbnail['src'] . ');">
					<div class="thumbnail-hover"></div>
					<div class="post-actions">
						<ul>
							<li>
								<a class="edit" href="#edit/' . $post_id . '">' . get_svg('backend', '/icons/post_edit') . '</a>
								<div class="tooltip tt-edit">Edit</div>
							</li>
							<li>
								<a class="page-settings admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="getPostSettings" data-post-id="' . $post_id . '"  data-ps-mode="posts" data-post-type="' . $post_type . '" data-thumbnail-src="' . $thumbnail['src'] . '">' . get_svg('backend', '/icons/post_settings') . '</a>
								<div class="tooltip tt-settings">Settings</div>
							</li>
							<li>
								<a class="duplicate admin-click-handler" data-handler="execute" data-action="duplicatePost" data-action-type="main" data-post-type="' . $post_type . '" data-duplicate-id="' . $post_id . '">' . get_svg('backend', '/icons/post_duplicate') . '</a>
								<div class="tooltip tt-duplicate">Duplicate</div>
							</li>
							<li>
								<a class="delete admin-click-handler" data-handler="execute" data-action="deletePost" data-action-type="popup" data-post-type="' . $post_type . '" data-delete-id="' . $post_id . '">' . get_svg('backend', '/icons/post_delete') . '</a>
								<div class="tooltip tt-delete">Delete</div>
							</li>
						</ul>
					</div>
				</div>
			';
		} else {
			$thumbnail_html = '';
		}

		$output .= '
			<div class="' . $post_type . ' admin-column' . $is_semplice_class . '" data-xl-width="3" id="' . $post_id . '" data-thumbnail-src="' . $thumbnail['src'] . '" ' . $css . '>
				' . $activate_semplice . '
				<div class="column-inner">
					' . $thumbnail_html . '
					<div class="project-meta">
						<div class="post-status">' . semplice_post_status($post_id, $post_status) . '</div>
						<div class="post-title"><h2>' . $post_title . $front_or_posts . '</h2></div>
						<a class="preview-project" href="' . home_url() . '/project/' . $slug . '?preview_id=' . $post_id . '&preview=true" target="_blank">' . get_svg('backend', '/icons/preview') . '<div class="tooltip">Preview</div></a>
					</div>
				</div>
			</div>
		';
	} else {
		$output .= '
			<div class="' . $post_type . ' post admin-row' . $is_semplice_class . '" id="' . $post_id . '" ' . $css . '>
				<div class="post-title admin-column" data-xl-width="5"><h2><a href="#edit/' . $post_id . '">' . $post_title . $front_or_posts . '</a></h2></div>
				<div class="post-status admin-column" data-xl-width="2">' . semplice_post_status($post_id, $post_status) . '</div>
				<div class="post-date admin-column" data-xl-width="2">' . get_the_date('d/m/Y', $post_id) . '</div>
				<div class="post-actions admin-column" data-xl-width="3">
					<ul>
						<li>
							<a class="page-settings admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="getPostSettings" data-post-id="' . $post_id . '"  data-ps-mode="posts" data-post-type="' . $post_type . '">' . get_svg('backend', '/icons/post_settings') . '</a>
							<div class="tooltip tt-postsettings">Settings</div>
						</li>
						<li>
							<a class="duplicate admin-click-handler" data-handler="execute" data-action="duplicatePost" data-action-type="main" data-post-type="' . $post_type . '" data-duplicate-id="' . $post_id . '">' . get_svg('backend', '/icons/post_duplicate') . '</a>
							<div class="tooltip tt-duplicate">Duplicate</div>
						</li>
						<li>
							<a class="delete admin-click-handler" data-handler="execute" data-action="deletePost" data-action-type="popup" data-post-type="' . $post_type . '" data-delete-id="' . $post_id . '">' . get_svg('backend', '/icons/post_delete') . '</a>
							<div class="tooltip tt-delete">Delete</div>
						</li>
						<li>
							<a class="preview-page" href="' . home_url() . '/' . $slug . '?preview_id=' . $post_id . '&preview=true" target="_blank">' . get_svg('backend', '/icons/preview') . '</a>
							<div class="tooltip tt-preview">Preview</div>
						</li>
					</ul>
				</div>
				' . $activate_semplice . '
			</div>
		';
	}

	return $output;
}

// -----------------------------------------
// post status
// -----------------------------------------

function semplice_post_status($post_id, $status) {

	// get link
	if($status == 'published') {
		$link = '<a class="admin-click-handler published" data-post-id="' . $post_id . '" data-post-status="draft" data-handler="execute" data-action-type="helper" data-action="updatePostStatus">' . ucfirst($status) . '<div class="tooltip">Make draft</div></a>';
	} else {
		$link = '<a class="admin-click-handler draft" data-post-id="' . $post_id . '" data-post-status="publish" data-handler="execute" data-action-type="helper" data-action="updatePostStatus">' . ucfirst($status) . '<div class="tooltip">Publish</div></a>';
	}

	// status
	$output = $link;

	// return
	return $output;
}

// -----------------------------------------
// get projects
// -----------------------------------------

function semplice_get_projects($portfolio_order, $categories) {

	// categories?
	if(is_array($categories)) {
		$categories = implode(', ', $categories);
	}
	
	// generate thumbnails
	$args = array(
		'posts_per_page'=> -1,
		'post__in' 	 	=> $portfolio_order,
		'post_type'	  	=> 'project',
		'post_status' 	=> 'publish',
		'orderby' 	  	=> 'post__in',
		'category'    => $categories,
	);

	$posts = get_posts($args);

	$projects = array();

	// go through order and add to list
	if(null !== $posts) {
		$i = 0;
		foreach ($posts as $post) {
			$projects[$i] = array(
				'post_id' => $post->ID,
				'post_title' => $post->post_title,
				'permalink' => get_permalink($post->ID),
				'image' => semplice_get_thumbnail($post->ID),
			);
			// get post settings
			$post_settings = json_decode(get_post_meta($post->ID, '_semplice_post_settings', true), true);
			// is individual thumb hover activated?
			if(isset($post_settings['thumbnail']['hover_visibility']) && $post_settings['thumbnail']['hover_visibility'] == 'enabled') {
				$projects[$i]['thumb_hover'] = $post_settings['thumbnail'];
			}
			// project type
			if(isset($post_settings['meta']['project_type']) && !empty($post_settings['meta']['project_type'])) {
				$projects[$i]['project_type'] = $post_settings['meta']['project_type'];
			} else {
				$projects[$i]['project_type'] = 'Project type';
			}

			$i++;
		}
	}

	return $projects;
}

// ----------------------------------------
// get post dropdown
// ----------------------------------------

function semplice_get_post_dropdown($post_type) {
	// get pages
	$posts = get_posts(array('posts_per_page' => -1, 'post_type' => $post_type));
	// pages array
	$posts_array = array(0 => '— Select ' . $post_type);
	// iterate pages object
	if(is_array($posts)) {
		foreach ($posts as $post) {
			$posts_array[$post->ID] = $post->post_title;
		}
		return $posts_array;
	} else {
		return array('0' => 'You have no ' . $post_type . 's');
	}
}

?>