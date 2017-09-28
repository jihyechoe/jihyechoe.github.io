<?php

// -----------------------------------------
// semplice
// admin/editor/blocks.php
// -----------------------------------------

class blocks {

	// public vars
	public $db;
	public $table_name;
	public $db_version;

	public function __construct() {

		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->table_name = $wpdb->prefix . 'semplice_content_blocks';

		// db version
		$this->db_version = get_option("semplice_content_blocks_db_version");

		// add action
		add_action('after_switch_theme', array(&$this, 'status'));
	}

	// -----------------------------------------
	// get block
	// -----------------------------------------
	
	public function get($id, $type) {

		// get json
		switch($type) {
			case 'layout':
				$ram = file_get_contents(get_template_directory() . '/admin/editor/blocks/' . $id . '.json');
			break;
			case 'user':
				// get block from the db
				$block = $this->db->get_row("SELECT content FROM $this->table_name WHERE id = $id", ARRAY_A);
				// add content to ram
				$ram = $block['content'];
			break;
		}

		// decode
		$ram = json_decode($ram, true);

		// is content?
		if(is_array($ram)) {
			// create block array
			$block = semplice_generate_ram_ids($ram, false, true);
			// return new block
			return $block;
		} else {
			return 'noram';
		}
	}

	// -----------------------------------------
	// save block
	// -----------------------------------------

	public function save($content, $name) {

		// empty name?
		if(empty($name)) {
			$name = 'Untitled';
		}

		// save revision in the database
		$this->db->insert(
			$this->table_name,
			array(
				"name"		 	 => json_encode($name),
				"content"		 => $content,
			)
		);

		// output newest list
		return $this->user_blocks();
	}

	// -----------------------------------------
	// delete blocks
	// -----------------------------------------

	public function delete($id) {
		// delete block from db
		$this->db->delete($this->table_name, array('id' => $id));
	}

	// -----------------------------------------
	// list blocks
	// -----------------------------------------

	public function list_blocks() {
		// get layout blocks
		$layout_blocks = $this->layout_blocks();
		// return list
		return '
			<ul>
				<li><a class="blocks-default-tab" href="#layout">Layout Blocks</a></li>
				<li><a href="#user-defined">My Blocks</a></li>
			</ul>
			<div class="tab-content">
				<div id="layout" class="block-tab">
					<h4>Boost your workflow<br />with our layout blocks.</h4>
					<div class="layout-blocks">
						' . $layout_blocks['nav'] . '
					</div>
				</div>
				<div id="user-defined" class="block-tab">
					' . $this->user_blocks() . '
				</div>
			</div>
		';
	}

	// -----------------------------------------
	// layout blocks
	// -----------------------------------------

	public function layout_blocks() {

		// types
		$types = array(
			'image' => array(
				'name' => 'Image',
				'count' => 6,
			),
			'button' => array(
				'name' => 'Button',
				'count' => 3,
			),
			'column' => array(
				'name' => 'Col',
				'count' => 3,
			),
			'list' => array(
				'name' => 'List',
				'count' => 2,
			),
			'icon'	=> array(
				'name' => 'Icons',
				'count' => 2,
			),
			'motion' => array(
				'name' => 'Motion',
				'count' => 4,
			),
		);

		// vars
		$blocks = array('list' => array(), 'nav' => '');

		// loop through types
		foreach ($types as $type => $content) {
			// add to type nav
			$blocks['nav'] .= '<li><a class="editor-action" data-action-type="blocks" data-action="listView" data-block-category="' . $type . '"><img src="' . get_template_directory_uri() . '/assets/images/admin/blocks/categories/' . $type . '.png"></a></li>';
			// open block list
			$blocks['list'][$type] = '<ul class="layout-blocks-' . $type . ' layout-blocks-list">';
			// add back button
			$blocks['list'][$type] .= '<li class="back-button"><a class="editor-action" data-action-type="blocks" data-action="overview"><span>&larr;</span> Back to overview</a></li>';
			// loop through blocks
			if($content['count'] > 0) {
				for($i = 1; $i <= $content['count']; $i++) {
					$blocks['list'][$type] .= '<li><a class="add-block" data-block-id="' . $type . '_' . $i . '" data-block-type="layout"><img src="' . get_template_directory_uri() . '/assets/images/admin/blocks/covers/' . $type . '_' . $i . '.png"></a></li>';
				}
			} else {
				$blocks['list'][$type].= '<li class="empty-category">No blocks yet in this category.';
			}
			// close blocklist
			$blocks['list'][$type] .= '</ul>';

		}

		// wrap nav
		$blocks['nav'] = '<ul class="overview">' . $blocks['nav'] . '</ul>';

		// output list
		return $blocks;
	}

	// -----------------------------------------
	// user blocks
	// -----------------------------------------

	public function user_blocks() {
		
		// output
		$output = '';

		// get blocks
		$blocks = $this->db->get_results( 
			"
			SELECT * 
			FROM $this->table_name
			ORDER BY ID DESC
			"
		);

		if(!empty($blocks)) {

			// list start
			$output .= '
				<h4>Add & Customize your<br />personal blocks.</h4>
				<ul class="user-defined">
			';

			// loop throuh blocks
			foreach($blocks as $block) {
				$output .= '
					<li id="block-' . $block->id . '">
						<a class="add-block editor-action" data-action-type="blocks" data-action="add" data-block-id="' . $block->id . '" data-block-type="user">
							<h5>' . json_decode($block->name) . '</h5>
						</a>
						<a class="remove-block editor-action" data-action-type="popup" data-action="deleteBlock" data-block-id="' . $block->id . '"></a>
					</li>
				';
				
			}

			// list end
			$output .= '</ul>';
		} else {
			// empty state
			$output .= '
				<div class="no-blocks">
					<div class="inner">
						<p>Hey! You can also<br />create your own blocks.<br />See how it works.</p>
						<a class="blocks-help-video" href="https://vimeo.com/143198710" target="_blank"><img src="' . get_template_directory_uri() . '/assets/images/admin/no_blocks.png"></a>
					</div>
				</div>
			';
		}

		// output
		return $output;
	}

	// -----------------------------------------
	// check db status
	// -----------------------------------------

	public function status() {

		// atts
		$atts = array(
			'db_version' => '1.0',
			'is_update'  => false
		);

		// check if table is already created
		if($this->db->get_var("SHOW TABLES LIKE '$this->table_name'") !== $this->table_name || $this->db_version !== $atts['db_version']) {
			// setup blocks (install or update)
			$this->setup($atts);
		}
	}

	// -----------------------------------------
	// setup database for blocks
	// -----------------------------------------

	public function setup($atts) {
		// charset
		$charset_collate = $this->db->get_charset_collate();

		// database tables
		$atts['sql'] = "CREATE TABLE $this->table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name tinytext NOT NULL,
				content longtext NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";

		// install or update table
		if (!function_exists('blocks_db_install')) {
			function blocks_db_install($atts) {
		
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				
				dbDelta($atts['sql']);

				if($atts['is_update'] !== true) {
					// add db version to wp_options
					add_option('semplice_content_blocks_db_version', $atts['db_version']);
				} else {
					// update db version in wp_optionss
					update_option('semplice_content_blocks_db_version', $atts['db_version']);
				}
			}
		}
		
		// check if table exists, if not install table
		if($this->db->get_var("SHOW TABLES LIKE '$this->table_name'") !== $this->table_name) {

			blocks_db_install($atts);
			
		}

		if ($this->db_version !== $atts['db_version']) {

			// is update
			$atts['is_update'] = true;
			
			// update db
			blocks_db_install($atts);
			
		}
	}
}
?>