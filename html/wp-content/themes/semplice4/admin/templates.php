<?php global $admin_api, $semplice_get_content; ?>
<?php
	// default nav settings
	$nav_settings = $admin_api->customize['navigations']->default_nav_settings();
	// get menu
	$menu = wp_nav_menu(
		array (
			'echo' => false,
			'container' => false,
			//'fallback_cb' => '__return_false',
			'theme_location' => 'main-menu',
		)
	);
?>

<!-- admin templates -->
<div id="admin-templates">
	<!-- not found -->
	<script id="not-found-template" type="text/template">
		<div class="semplice-error">
			<span><?php echo get_svg('backend', '/icons/popup_important'); ?></span>
			<h1>It looks like your permalinks are not working.<br/>Please make sure that permalinks are enabled<br />and that you have a working htaccess file in place.</h1>
			<a class="semplice-button" href="<?php echo admin_url('options-permalink.php'); ?>">Permalink Settings</a>
		</div>
	</script>
	<!-- no rest api -->
	<script id="no-rest-api-template" type="text/template">
		<div class="semplice-error">
			<span><?php echo get_svg('backend', '/icons/popup_important'); ?></span>
			<h1>Semplice requires WordPress 4.4 or higher with an activated<br />Rest-API. Please update your site and try again.</h1>
			<a class="semplice-button admin-click-handler" data-handler="execute" data-action="exit" data-action-type="main">Exit to Wordpress</a>
		</div>
	</script>
	<!-- no rest api -->
	<script id="php-error-template" type="text/template">
		<div class="semplice-error">
			<span><?php echo get_svg('backend', '/icons/popup_important'); ?></span>
			<h1>Semplice requires PHP version 5.3 or higher.<br />Please contact your web host to update your PHP version.</h1>
			<a class="semplice-button admin-click-handler" data-handler="execute" data-action="exit" data-action-type="main">Exit to Wordpress</a>
		</div>
	</script>
	<!-- add new post -->
	<script id="add-post-template" type="text/template">
		<div id="semplice-add-post" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<h3>Add new {{postType}}</h3>
					{{options}}
				</div>
				<div class="popup-footer">
					<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler semplice-button add-post-button" data-handler="execute" data-action="savePost" data-action-type="main" data-post-type="{{postType}}">Add</a>
				</div>
			</div>
		</div>
	</script>
	<script id="add-post-page-template" type="text/template">
		<div class="option">
			<div class="option-inner">
				<div class="attribute span4-popup">
					<h4>Title</h4>
					<input type="text" placeholder="Page title" name="post-title" class="is-meta">
				</div>
			</div>
		</div>
		<div class="option">
			<div class="option-inner">
				<div class="attribute span4-popup">
					<div class="is-checkbox">
						<h4>Content Type</h4>
						<div class="option-switch">
							<ul class="twoway page-type-switch">
								<li class="active">
									<a class="admin-click-handler" data-handler="switchChange" data-name="content_type" data-switch-val="page" data-input-type="switch" switch-type="twoway">Page</a>
								</li>
								<li>
									<a class="admin-click-handler" data-handler="switchChange" data-name="content_type" data-switch-val="coverslider" data-input-type="switch" switch-type="twoway">Coverslider</a>
								</li>
								<input class="is-meta" type="hidden" name="content_type" data-input-type="switch" switch-type="twoway">
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="option">
			<div class="option-inner">
				<div class="attribute span4-popup">
					<div class="is-checkbox">
						<h4 class="attr-title-no-margin">Add page to menu</h4>
						<div class="option-switch">
							<ul class="twoway">
								<li class="active">
									<a class="admin-click-handler" data-handler="switchChange" data-name="add_to_menu" data-switch-val="no" data-input-type="switch" switch-type="twoway">No</a>
								</li>
								<li>
									<a class="admin-click-handler" data-handler="switchChange" data-name="add_to_menu" data-switch-val="yes" data-input-type="switch" switch-type="twoway">Yes</a>
								</li>
								<input class="is-meta" type="hidden" name="add_to_menu" data-input-type="switch" switch-type="twoway">
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	<script id="add-post-footer-template" type="text/template">
		<div class="option">
			<div class="option-inner">
				<div class="attribute span4-popup">
					<h4>Title</h4>
					<input type="text" placeholder="Footer title" name="post-title" class="is-meta">
				</div>
			</div>
		</div>
	</script>
	<script id="add-post-project-template" type="text/template">
		<div class="option">
			<div class="option-inner">
				<div class="attribute span4-popup">
					<h4>Title</h4>
					<input type="text" placeholder="Project title" name="post-title" class="is-meta">
				</div>
			</div>
			<div class="option-inner">
				<div class="attribute span4-popup">
					<h4>Type</h4>
					<input type="text" placeholder="Corporate Design" name="project-type" class="is-meta">
				</div>
			</div>
			<div class="option-inner">
				<div class="attribute span4-popup">
					<h4>Thumbnail</h4>
					<div class="media-upload-box onboarding-upload-box">
						<a class="semplice-button white-button admin-click-handler new-project-thumb" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-upload="newProjectThumb" name="new-project-thumb">Add project thumbnail</a>
						<input type="hidden" name="project-thumbnail" class="is-meta" value="">
					</div>
				</div>
			</div>
		</div>
	</script>
	<!-- edit popup template -->
	<script id="admin-edit-popup-template" type="text/template">
		<div class="ep-content">
			<div class='inner'>
				<div class="handlebar"><!-- draggable handle --></div>
				<nav class='ep-tabs-nav'>
					<ul>
						{{tabsNav}}
						<li><a class='close-edit-popup'><!-- close ep --></a></li>
					</ul>
				</nav>
				<div class="edit-popup-help"><div class="close-popup-notice" data-mode="help"><?php echo get_svg('backend', '/icons/ep_close_help'); ?></div><div class="content"></div></div>
				<div class='ep-tabs'>
				</div>
			</div>
		</div>
	</script>
	<!-- onboarding container -->
	<script id="onboarding-template" type="text/template">
		<div id="onboarding">
			<div class="inner" data-step="{{step}}">
				{{content}}
			</div>
		</div>
	</script>
	<!-- onboarding complete -->
	<script id="onboarding-completed-template" type="text/template">
		<div class="heading">
			<div class="step-title">Setup completed</div>
			<div class="hero-title"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/onboarding/finish_title.svg" alt="onboarding-title"></div>
		</div>
		<div class="content">
			<div class="finish-notice">
				<p>Your setup is now complete and you can start using Semplice.</p>
			</div>
		</div>
		<div class="footer">
			<a class="onboarding-button admin-click-handler" href="#dashboard">Proceed to dashboard</a> 
		</div>
	</script>
	<!-- customize template -->
	<script id="customize-template" type="text/template">
		<div id="customize" class="{{customizeClass}}">
			{{content}}
		</div>
	</script>
	<!-- grid template -->
	<script id="grid-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-content">
				{{content}}
			</div>
		</div>
	</script>
	<!-- webfont templates -->
	<script id="webfonts-template" type="text/template">
		<div class="customize-sidebar">
				<div class="webfonts-ressources">
					<h3 class="sidebar-title">Resources</h3>
					<div class="sidebar-spacer-full"></div>
						<ul>
							{{ressource}}
						</ul>
					<a class="add-ressource-button admin-click-handler" data-handler="execute" data-action="addRessourcePopUp" data-setting-type="webfonts" data-action-type="customize" data-options="service" data-mode="add">+ Add Resource</a>
				</div>
		</div>
		<div class="customize-inner">
			<div class="customize-heading">
				<div class="inner">
					<div class="admin-row">
						<div class="sub-header admin-column">
							<h2 class="admin-title">Webfonts</h2>
							<a class="admin-click-handler semplice-button gray-button" data-handler="execute" data-action="addWebfontPopUp" data-setting-type="webfonts" data-action-type="customize" data-options="add-font" data-mode="add">Add webfont</a> 
						</div>
					</div>
				</div>
			</div>
			<div class="customize-content">
				<div class="webfonts">
					<ul>
						{{content}}
					</ul>
				</div>
			</div>
		</div>
	</script>
	<script id="webfonts-onboarding-template" type="text/template">
		<div class="customize-content">
			<div class="webfonts-onboarding">
				<div class="head"><img src="<?php echo get_template_directory_uri() . '/assets/images/admin/customize_webfonts_ob_image.png'; ?>"></div>
				<div class="content">
					<h2>Custom Webfonts</h2>
					<p>In Semplice you can add fonts from any external service (like Typekit, Fonts.com) or just add your own self hosted fonts.</p>
					<a class="semplice-button admin-click-handler" data-handler="execute" data-action="addRessourcePopUp" data-setting-type="webfonts" data-action-type="customize" data-options="service" data-mode="add">Add your first Webfont</a>
				</div>
				<div class="help-videos">
					<a href="https://vimeo.com/214124569/e1337fa720" target="_blank">Add serviced fonts</a>
					<a class="self-hosted" href="https://vimeo.com/214964290/5c4cc9f3aa" target="_blank">Add selfhosted fonts</a>
				</div>
			</div>
		</div>
	</script>
	<script id="webfonts-addfont-popup-template" type="text/template">
		<div id="webfonts-add-font" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<h3>Add new webfont</h3>
					{{options}}
				</div>
				<div class="popup-footer">
					<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="semplice-button admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="{{mode}}Webfont" data-font-id="{{id}}">{{mode}} Webfont</a>
				</div>
				<div class="webfonts-help">
					<div class="close-popup-notice" data-mode="webfonts">
						<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
					</div>
					<div class="content">
						{{content}}
					</div>
				</div>
			</div>
		</div>
	</script>
	<script id="webfonts-addfont-list-template" type="text/template">
		<li id="{{fontId}}">
			<a class="admin-click-handler edit-font" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="addWebfontPopUp" data-font-id="{{fontId}}" data-mode="edit" data-options="add-font">
				<p class="font-name">{{name}}</p>
				<h4 class="font-preview {{fontId}}">ABCabc0123 The quick brown fox</h4>
			</a>
			<div class="webfonts-actions">
				<ul>
					<li><a class="admin-click-handler edit" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="addWebfontPopUp" data-font-id="{{fontId}}" data-mode="edit" data-options="add-font"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
					<li><a class="admin-click-handler delete" data-handler="execute" data-action-type="popup" data-type="removeFont" data-action="deleteWebfont" data-delete-id="{{fontId}}"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
				</ul>
			</div>
		</li>
	</script>
	<script id="webfonts-ressource-popup-template" type="text/template">
		<div id="webfonts-add-ressource" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<h3>Add new resource</h3>
					<div class="option">
						<div class="option-inner">
							<div class="attribute span4-popup">
								<h4>Resource type <span class="show-help">(?)<span><b>Webservice</b><br />Integrate any fonts you like from a webfont service such as Fonts.com, Typekit, Google Fonts etc. <a href="https://vimeo.com/214124569/e1337fa720" target="_blank">Here is a little video tutorial for you.</a><br /><br /><b>Self hosted</b><br />Integrate fonts that are hosted on your own web server. <a href="https://vimeo.com/214964290/5c4cc9f3aa" target="_blank">You can see how that works in this video.</a></span></span></h4>
								<div class="option-switch">
									<ul class="twoway webfonts-type-switch">
										<li><a class="admin-click-handler" data-handler="switchChange" data-callback="webfontsRessourceSwitch" data-name="ressource-type" data-switch-val="service" data-ressource-id="{{id}}">Service</a></li>
										<li><a class="admin-click-handler" data-handler="switchChange" data-name="ressource-type" data-callback="webfontsRessourceSwitch" data-switch-val="self-hosted" data-ressource-id="{{id}}">Self Hosted</a></li>
										<input type="hidden" name="ressource-type" value="service" class="is-webfonts-setting">
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="options">
						{{options}}
					</div>
				</div>
				<div class="popup-footer">
					<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="semplice-button admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="{{mode}}Ressource" data-ressource-id="{{id}}">{{mode}}</a>
				</div>
				<div class="webfonts-help">
					<div class="close-popup-notice" data-mode="webfonts">
						<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
					</div>
					<div class="content">
						{{content}}
					</div>
				</div>
			</div>
		</div>
	</script>
	<script id="webfonts-ressource-list-template" type="text/template">
		<li id="{{id}}" class="{{type}}"{{css}}>
			<h5 class="ressource-name">{{name}}</h5>
			<div class="webfonts-ressources-actions">
				<ul>
					<li><a class="admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="addRessourcePopUp" data-mode="edit" data-ressource-id="{{id}}" data-options="{{type}}"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
					<li><a class="admin-click-handler" data-handler="execute" data-action-type="popup" data-type="removeRessource" data-action="deleteWebfont" data-delete-id="{{id}}"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
				</ul>
			</div>
		</li>
	</script>
	<script id="webfonts-unassigned" type="text/template">
		<div class="webfonts-unassigned" {{css}}>
			<h2>You have unassigned webfonts</h2>
			<p>We've detected that you removed some of the fonts you are using in your posts. Feel free to<br />re-assign them to automatically replace the removed fonts in your posts.</p>
			<div class="unassigned-fonts-head">
				<div>Missing Fonts</div>
				<div>Replace With</div>
			</div>
			<div class="unassigned-fonts">
				{{fonts}}
			</div>
		</div>
	</script>
	<script id="delete-webfont-template" type="text/template">
		<div id="semplice-delete" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Delete {{type}}</h3>
					<p>Are you sure you want to delete this {{type}}?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="{{action}}" data-action-type="customize" data-setting-type="webfonts" data-delete-id="{{id}}">Delete</a>
				</div>					
			</div>
		</div>
	</script>
	<script id="onoff-switch-template" type="text/template">
		<div class="onoff-switch">
			<div class="title">
				<h6>{{title}}</h6>
			</div>
			<div class="switch admin-click-handler switch-{{default}}" data-handler="onOffSwitch">
				<div class="circle">
			</div>
			<input type="hidden" name="{{name}}" value="{{default}}" {{attributes}}>
		</div>
	</script>
	<!-- navigations -->
	<script id="navigations-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-heading">
				<div class="inner navigations-inner">
					<div class="admin-row">
						<div class="sub-header admin-column">
							<h2 class="admin-title">Navigations</h2>
							<a class="semplice-button gray-button" href="#customize/navigations/add">Add Navigation</a> 
						</div>
					</div>
				</div>
			</div>
			<div class="customize-content navigations-inner">
				<div class="navigations">
					<ul>
						{{content}}
					</ul>
				</div>
			</div>
		</div>
	</script>
	<script id="navigations-list-template" type="text/template">
		<li id="{{id}}">
			<a class="navigation {{preset}}{{lastInRow}}" href="#customize/navigations/edit/{{id}}">
				<img alt="preset-two bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/{{presetUrl}}_full.png'; ?>">
				<p>{{name}}{{defaultNav}}</p>
			</a>
			<div class="edit-nav-hover">
				<ul>
					<li>
						<a class="navigation-duplicate" href="#customize/navigations/edit/{{id}}"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a>
						<div class="tooltip tt-edit">Edit</div>
					</li>
					<li>
						<a class="navigation-duplicate admin-click-handler" data-handler="execute" data-action="removePopup" data-setting-type="navigations" data-action-type="customize" data-nav-id="{{id}}"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a>
						<div class="tooltip tt-remove">Remove</div>
					</li>
					<li>
						<a class="navigation-remove admin-click-handler" data-handler="execute" data-action="duplicate" data-setting-type="navigations" data-action-type="customize" data-nav-id="{{id}}"><?php echo get_svg('backend', '/icons/post_duplicate'); ?></a>
						<div class="tooltip tt-duplicate">Duplicate</div>
					</li>
					<li>
						<a class="navbar-default" data-nav-id="{{id}}"><?php echo get_svg('backend', '/icons/save_checkmark'); ?></a>
						<div class="tooltip tt-default">Default</div>
					</li>
				</ul>
			</div>
		</li>
	</script>
	<script id="navigations-presets-template" type="text/template">
		<div class="customize-inner navigation-presets">
			<div class="customize-heading navigation-presets-heading">
				<div class="inner">
					<div class="admin-row">
						<div class="sub-header admin-column">
							<h2 class="admin-title">Select your navigation preset</h2>
							<a class="close-navigation-presets {{isFirst}}" href="#customize/navigations"><?php echo get_svg('backend', '/icons/close_admin'); ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="customize-content">
				<div class="presets">
					<a class="preset admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_left_menu_right">
						<div class="images">
							<img alt="preset-one bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_one_bg.png'; ?>">
							<img alt="preset-one nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_one_nav.png'; ?>">
						</div>
						<p>Logo on the left; menu on the right</p>
					</a>
					<a class="preset admin-click-handler preset-right" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_left_menu_left">
						<div class="images">
							<img alt="preset-two bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_two_bg.png'; ?>">
							<img alt="preset-two nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_two_nav.png'; ?>">
						</div>
						<p>Logo and menu on the left</p>
					</a>
					<a class="preset admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_right_menu_left">
						<div class="images">
							<img alt="preset-three bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_three_bg.png'; ?>">
							<img alt="preset-three nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_three_nav.png'; ?>">
						</div>
						<p>Logo on the right; menu on the left</p>
					</a>
					<a class="preset admin-click-handler preset-right" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_right_menu_right">
						<div class="images">
							<img alt="preset-four bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_four_bg.png'; ?>">
							<img alt="preset-four nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_four_nav.png'; ?>">
						</div>
						<p>Logo and menu on the right</p>
					</a>
					<a class="preset admin-click-handler coming-soon" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_middle_menu_sides">
						<div class="images">
							<img alt="preset-five bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_five_bg.png'; ?>">
							<img alt="preset-five nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_five_nav.png'; ?>">
						</div>
						<p>Logo in the middle; menu on both sides</p>
					</a>
					<a class="preset admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_middle_menu_stacked">
						<div class="images">
							<img alt="preset-six bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_six_bg.png'; ?>">
							<img alt="preset-six nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_six_nav.png'; ?>">
						</div>
						<p>Logo and menu stacked in the middle</p>
					</a>
					<a class="preset admin-click-handler coming-soon" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_hidden_menu_middle">
						<div class="images">
							<img alt="preset-seven bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_seven_bg.png'; ?>">
							<img alt="preset-seven nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_seven_nav.png'; ?>">
						</div>
						<p>Logo hidden; menu in the middle</p>
					</a>
					<a class="preset admin-click-handler preset-right coming-soon" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_left_menu_vertical_right">
						<div class="images">
							<img alt="preset-eight bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_eight_bg.png'; ?>">
							<img alt="preset-eight nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_eight_nav.png'; ?>">
						</div>
						<p>Logo on the left, vertical menu on the right</p>
					</a>
					<a class="preset admin-click-handler coming-soon" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_middle_menu_corners">
						<div class="images">
							<img alt="preset-nine bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_nine_bg.png'; ?>">
							<img alt="preset-nine nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_nine_nav.png'; ?>">
						</div>
						<p>Logo in the middle; menu on four corners</p>
					</a>
					<a class="preset admin-click-handler preset-right coming-soon" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="logo_middle_menu_vertical_left_right">
						<div class="images">
							<img alt="preset-ten bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_ten_bg.png'; ?>">
							<img alt="preset-ten nav" class="preset-nav-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/preset_ten_nav.png'; ?>">
						</div>
						<p>Logo in the middle, vertical menu on left and right</p>
					</a>
				</div>
			</div>
		</div>
	</script>
	<script id="navigations-edit-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-content">
				<div class="browser-top">
					<div class="dots">
						<div class="dot"></div>
						<div class="dot"></div>
						<div class="dot"></div>
					</div>	
				</div>
				{{content}}
			</div>
		</div>
	</script>
	<script id="np-logo-left-menu-right" type="text/template">
		<?php echo $admin_api->customize['navigations']->get_preset('preset_one', $nav_settings); ?>
	</script>
	<script id="np-logo-left-menu-left" type="text/template">
		<?php echo $admin_api->customize['navigations']->get_preset('preset_two', $nav_settings); ?>
	</script>
	<script id="np-logo-right-menu-left" type="text/template">
		<?php echo $admin_api->customize['navigations']->get_preset('preset_three', $nav_settings); ?>
	</script>
	<script id="np-logo-right-menu-right" type="text/template">
		<?php echo $admin_api->customize['navigations']->get_preset('preset_four', $nav_settings); ?>
	</script>
	<script id="np-logo-middle-menu-stacked" type="text/template">
		<?php echo $admin_api->customize['navigations']->get_preset('preset_six', $nav_settings); ?>
	</script>
	<script id="navigations-delete-template" type="text/template">
		<div id="navigations-delete" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Delete navigation</h3>
					<p>Are you sure you want to delete this navigation?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="remove" data-setting-type="navigations" data-action-type="customize" data-delete-id="{{id}}">Delete</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- edit menu -->
	<script id="navigations-edit-menu-template" type="text/template">
		<div class="edit-menu">
			<div class="close-popup-notice" data-mode="menu">
				<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
			</div>
			<div class="content">
				{{content}}
			</div>
		</div>
	</script>
	<!-- add menu item -->
	<script id="navigations-add-menu-item-template" type="text/template">
		<li class="semplice-menu-item" id="nav-item-{{id}}" data-type="{{type}}">
			<a class="menu-items-handle"></a>
			<a class="show-options admin-click-handler" data-handler="execute" data-action-type="menu" data-action="showOptions" data-id="{{id}}">{{title}}</a>
			<a class="remove-nav-item admin-click-handler" data-handler="execute" data-action-type="menu" data-action="remove" data-id="{{id}}"></a>
			<div class="item-options">
				<label class="first-label">Title</label>
				<input type="text" name="menu_title" class="item-title admin-listen-handler" data-handler="menuItemTitle" value="{{title}}" placeholder="Title" data-id="{{id}}">
				<div class="classes-target">
					<div class="classes">
						<label>Classes</label>
						<input type="text" name="menu_classes" class="item-classes admin-listen-handler" data-handler="updateMenu" value="" placeholder="Classes">
					</div>
					<div class="target">
						<label class="target-label">Target</label>
						<div class="select-box">
							<div class="sb-arrow"></div>
							<select name="menu_target">
								<option value="_blank">New Tab</option>
								<option value="_self">Same Tab</option>
							</select>
						</div>
					</div>
				</div>
				{{link}}
				<div class="save-new-menu-item">
					<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="hideOptions">Save Changes</a>
				</div>
			</div>
		</li>
	</script>
	<!-- typography -->
	<script id="typography-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-heading">
				<div class="inner typography-inner">
					<div class="admin-row">
						<div class="sub-header admin-column">
							<h2 class="admin-title">Typography</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="customize-content typography-inner">
				<div class="typography">
					{{content}}
				</div>
			</div>
		</div>
	</script>
	<!-- thumb hover-->
	<script id="thumbhover-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-heading">
				<div class="inner thumbhover-inner">
					<div class="admin-row">
						<div class="sub-header admin-column">
							<h2 class="admin-title">Thumb Hover</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="customize-content thumbhover-inner">
				<p class="note">Create your global portfolio thumbnail hover below (will apply to each thumbnail).<br />Of course, you can also create a custom hover for each individual project. <a href="https://vimeo.com/211601701/96fec1ea40" target="_blank">Watch the video tutorial</a>.</p>
				<div class="thumb-hover-preview">
					{{content}}
				</div>
			</div>
		</div>
	</script>
	<!-- transitions-->
	<script id="transitions-template" type="text/template">
		<div class="transitions-preview no-transition">
			<div class="out tp-visible">
				<div class="admin-container">
					<div class="admin-row">
						<div class="admin-column content" data-xl-width="12">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/admin/transitions/text_out.svg'; ?>" alt="text out">
						</div>
					</div>
				</div>
			</div>
			<div class="in tp-not-visible transition-hidden">
				<div class="admin-container">
					<div class="admin-row">
						<div class="admin-column content" data-xl-width="12">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/admin/transitions/text_in.svg'; ?>" alt="text out">
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	<!-- blog-->
	<script id="blog-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-content">
				<div id="content-holder">
					<?php echo $semplice_get_content->customize(); ?>
					<div class="post-divider search-divider"></div>
				</div>
			</div>
		</div>
	</script>
	<!-- footer-->
	<script id="footer-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-heading">
				<div class="inner footer-inner">
					<div class="admin-row">
						<div class="sub-header admin-column">
							<h2 class="admin-title">Footer <a class="admin-click-handler semplice-button" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="footer">Add New Footer</a></h2>
						</div>
					</div>
				</div>
			</div>
			<div class="customize-content footer-inner">
				{{content}}
			</div>
		</div>
	</script>
	<!-- advanced-->
	<script id="advanced-customize-template" type="text/template">
		<div class="customize-inner">
			<div class="customize-content">
				<div class="browser-top">
					<div class="dots">
						<div class="dot"></div>
						<div class="dot"></div>
						<div class="dot"></div>
					</div>	
				</div>
				{{content}}
			</div>
		</div>
	</script>
	<!-- media upload template -->
	<script id="editor-image-upload-template" type="text/template">
		<div class="media-upload-box {{uploadVisibility}}" data-upload-box="{{contentId}}">
			<div class="upload-button admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" {{attributes}}></div>
			<div class="image-preview-wrapper">
				<img class="image image-preview" src="{{imageSrc}}">
				<div class="edit-image">
					<ul>
						<li><a class="admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" {{attributes}}><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
						<li><a class="editor-action" data-action="bgImage" data-action-type="delete" data-content-id="{{contentId}}" {{attributes}}><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
					</ul>
				</div>
			</div>
			<input type="hidden" {{attributes}}>
		</div>
	</script>
	<script id="admin-image-upload-template" type="text/template">
		<div class="media-upload-box {{uploadVisibility}}">
			<div class="upload-button admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" {{attributes}}></div>
			<div class="image-preview-wrapper">
				<img class="image image-preview" src="{{imageSrc}}">
				<div class="edit-image">
					<ul>
						<li><a class="admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" {{attributes}}><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
						<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" {{attributes}}><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
					</ul>
				</div>
			</div>
			<input type="hidden" {{attributes}}>
		</div>
	</script>
	<script id="video-upload-template" type="text/template">
		<div class="media-upload-box" data-upload-box="{{contentId}}">
			<a class="semplice-button video-upload white-button admin-click-handler" data-handler="execute"  data-action="upload" data-action-type="media" data-media-type="video" {{attributes}}>{{buttonText}}</a>
			<a class="editor-action remove-media" data-action="video" data-action-type="delete" data-content-id="{{contentId}}" {{attributes}}><?php echo get_svg('backend', '/icons/media_delete'); ?></a>
			<input type="hidden" {{attributes}}>
		</div>
	</script>
	<script id="gallery-upload-template" type="text/template">
		<div class="media-upload-box" data-upload-box="{{contentId}}">
			<ul class="gallery-images{{visibility}}">{{images}}</ul>
			<a class="semplice-button gallery-upload semplice-button admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="gallery" {{attributes}}>Upload Images</a>
			<input type="hidden" {{attributes}}>
		</div>
	</script>
	<!-- theme settings template -->
	<script id="settings-template" type="text/template">
		<div id="settings">
			<div class="settings-inner">{{options}}</div>
		</div>
	</script>
	<!-- page settings template -->
	<script id="post-settings-template" type="text/template">
		<div id="post-settings">
			<div class="inner">
				<div class="ps-header">
					<nav>
						<ul>
							{{thumbnailNavTab}}
							<li><a class="ps-tab admin-click-handler" data-handler="psTabchange" data-ps-tab="ps-meta">Settings</a></li>
							<li><a class="ps-tab admin-click-handler" data-handler="psTabchange" data-ps-tab="ps-seo">SEO &amp; Share</a></li>
						</ul>
					</nav>
					<a class="admin-click-handler cancel" data-handler="execute" data-action-type="postSettings" data-action="save" data-save-action="close">Cancel</a>
					<a class="save-post-settings admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="save" data-save-action="save"><?php echo get_svg('backend', '/icons/post_settings_save'); ?></a>
				</div>
				<div class="ps-tabs">
					{{thumbnailTab}}
					<div id="ps-meta"><div class="tab-content"></div></div>
					<div id="ps-seo"><div class="tab-content"></div></div>
				</div>
			</div>
		</div>
	</script>
	<script id="post-settings-thumbnail-template" type="text/template"> 
		<div id="ps-thumbnail" class="{{thumbnailVisibility}}">
			<div class="empty-thumbnail">
				<div class="et-inner">
					<h4>Project thumbnail</h4>
					<p>Upload a new thumbnail or choose an existing one from the media <br />library. This will be displayed in your portfolio grid.</p>
					<a class="semplice-button upload-thumbnail admin-click-handler" data-handler="execute" data-action-type="media" data-action="upload" data-upload="thumbnail" data-media-type="thumbnail">Add Thumbnail</a>
				</div>
			</div>
			<div class="ps-thumbnail-preview">
				<img class="ps-thumbnail-preview-img" src="{{thumbnail}}">
				<div class="edit-image">
					<ul>
						<li><a class="admin-click-handler" data-handler="execute" data-action-type="media" data-action="upload" data-upload="thumbnail" data-media-type="thumbnail"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
						<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" name="thumbnail"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
					</ul>
				</div>
			</div>
			<div class="ps-thumbnail-options">
				<div class="tab-content"></div>
			</div>
		</div>
	</script>
	<script id="post-settings-seo-template" type="text/template">
		<div class="options">
			<div class="option">
				<div class="option-heading seo-heading">
					<h3>SEO Settings</h3>
					<p class="description">Below you can change and optimize your SEO settings.<br />To change your title & description click directly into the preview below.<br /><br />In order to change your SEO defaults you need to navigate to your<br />WordPress dashboard and click 'SEO' in the navigation to open your Yoast SEO plugin.</p>
				</div>
			<div class="title-spacer"></div>
		</div>
		<div class="semplice-seo-snippets">
			<div class="google-preview">
				<p class="snippet-preview">Title and description</p>
				<div class="snippet-inner">
					<input type="text" placeholder="Title" value="{{seoTitle}}" data-input-type="input-text" class="ps-setting admin-listen-handler seo-title" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_title">
					<p class="page-slug">{{permalink}}<span class="slug-tip">Please change the url in the settings tab</span></p>
					<textarea rows="1" type="text" placeholder="Meta description" data-input-type="textarea" class="ps-setting admin-listen-handler meta-desc adaptive-textarea" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_metadesc">{{metaDesc}}</textarea>
				</div>
				
			</div>
			<div class="facebook-preview">
				<p class="snippet-preview">Facebook</p>
				<div class="snippet-inner">
					<div class="media-upload-box {{fbUploadVisibility}}">
						<div class="upload-button admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image"><div class="image-note">1200px x 630px</div></div>
							<div class="image-preview-wrapper">
								<img class="image image-preview" src="{{facebookImage}}">
								<div class="edit-image">
									<ul>
										<li><a class="admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
										<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
									</ul>
								</div>
							</div>
						<input type="hidden" data-input-type="admin-image-upload" class="ps-setting admin-listen-handler" data-handler="postSettings" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image">
					</div>
					<div class="facebook-meta">
						<input type="text" placeholder="Facebook title" value="{{facebookTitle}}" data-input-type="input-text" class="ps-setting admin-listen-handler facebook-title" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-title">
						<textarea rows="1" type="text" placeholder="Facebook description" data-input-type="textarea" class="ps-setting admin-listen-handler facebook-desc adaptive-textarea" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-description">{{facebookDesc}}</textarea>
						<p class="facebook-url">{{facebookUrl}}</p>
					</div>
				</div>
			</div>
			<div class="twitter-preview">
				<p class="snippet-preview">Twitter</p>
				<div class="snippet-inner">
					<div class="media-upload-box {{twitterUploadVisibility}}">
						<div class="upload-button admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image"><div class="image-note image-note-twitter">1024px x 512px</div></div>
							<div class="image-preview-wrapper">
								<img class="image image-preview" src="{{twitterImage}}">
								<div class="edit-image">
									<ul>
										<li><a class="admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
										<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
									</ul>
								</div>
							</div>
						<input type="hidden" data-input-type="admin-image-upload" class="ps-setting admin-listen-handler" data-handler="postSettings" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image">
					</div>
					<div class="twitter-meta">
						<input type="text" placeholder="twitter title" value="{{twitterTitle}}" data-input-type="input-text" class="ps-setting admin-listen-handler twitter-title" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-title">
						<textarea rows="1" type="text" placeholder="twitter description" data-input-type="textarea" class="ps-setting admin-listen-handler twitter-desc adaptive-textarea" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-description">{{twitterDesc}}</textarea>
						<p class="twitter-url">{{twitterUrl}}</p>
					</div>
				</div>
			</div>
		</div>
	</script>
	<script id="post-settings-yoast-template" type="text/template">
		<div class="no-yoast">
			<h3>Yoast SEO is not installed.</h3>
			<p>In order to enable the SEO fields in Semplice you have to install the <a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank">Yoast SEO Plugin</a>. To avoid conflicts with SEO plugins Semplice has no on board SEO functionality.<br /><br /><span>Please note that our admin panel and the 'Single Page App' mode only supports the Yoast SEO Plugin. If you would rather add / change your SEO settings in the standard Wordpress admin and you don't plan on using the 'Single Page App' mode you can of course use any plugin you like.</span></p>
		</div>
	</script>
	<!-- code mirror -->
	<script id="codemirror-template" type="text/template">
		<div id="codemirror-pagesettings">
			<textarea id="code_mirror" {{attributes}}>{{code}}</textarea>
		</div>
	</script>
	<!-- categories -->
	<script id="categories-template" type="text/template">
		<div class="select-categories">
			<nav {{attributes}}>
				<ul>
					<?php 
						// list categories
						wp_category_checklist();
					?>
				</ul>
			</nav>
			<div class="add-new-category">
				<div class="add-category-form hide">
					<input type="text" name="category-name" placeholder="Category Name">
					<input type="hidden" name="category-parent">
					<div class="categories-dropdown"><div class="select-box"><div class="sb-arrow"></div><?php wp_dropdown_categories('hide_empty=0&depth=5&hierarchical=1'); ?></div></div>
					<a class="semplice-button white-button admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="addCategory">Add Category</a>
				</div>
				<a class="semplice-button white-button admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="showAddCategoryForm">Add Category</a>
			</div>
		</div>
	</script>
	<!-- select categories -->
	<script id="select-categories-template" type="text/template">
		<div class="grid-categories select-categories">
			<div class="close-popup-notice" data-mode="categories">
				<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
			</div>
			<div class="content">
				<p class="notice-heading">Select Categories</p>
				<nav {{attributes}}>
					<ul>
						<?php 
							// list categories
							wp_category_checklist();
						?>
					</ul>
				</nav>
			</div>
		</div>
	</script>
	<!-- add effect template -->
	<script id="motion-effects-template" type="text/template">
		<div id="motion-effects">
			<nav>
				<ul>
					<li><a class="add-motion-effect" data-effect="opacity">Opacity</a></li>
					<li><a class="add-motion-effect" data-effect="move">Move</a></li>
					<li><a class="add-motion-effect" data-effect="rotate">Rotate</a></li>
					<li><a class="add-motion-effect" data-effect="scale">Scale</a></li>
				</ul>
			</nav>
		</div>
		<div class="added-effects"><!-- added motion effects --></div>
		<a {{attributes}}>Add effect</a>
	</script>
	<!-- code mirror -->
	<script id="code-mirror-template" type="text/template">
		<div id="code-editor">
			<div class="code-editor-save">
				<p>Code Editor<p>
				<div class="buttons">
					<a class="code-cancel admin-click-handler" data-handler="codemirror" data-mode="cancel">cancel</a>
					<a class="code-save admin-click-handler" data-handler="codemirror" data-mode="save" data-attribute="{{attribute}}" data-id="{{contentId}}">save</a>
				</div>
			</div>
			<textarea id="code_mirror">{{code}}</textarea>
		</div>
	</script>
	<!-- unsaved changes -->
	<script id="admin-unsaved-changes" type="text/template">
		<div id="semplice-exit" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Unsaved Changes</h3>
					<p>Do you want to save your progress before continuing?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="execute" data-action-type="helper" data-action="triggerHashchange">Don't Save</a>
				<a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="{{type}}" data-action="save" data-customize-setting="{{setting}}" data-settings-setting="{{setting}}" data-hashchange="yes">Save &amp; continue</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- delete post popup -->
	<script id="delete-post-template" type="text/template">
		<div id="semplice-delete" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Delete post</h3>
					<p>Are you sure you want to delete this post?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="deletePost" data-action-type="main" data-delete-id="{{postId}}" data-post-type="{{postType}}">Delete</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- activate semplice -->
	<script id="activate-semplice-template" type="text/template">
		<div id="activate-semplice" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<h3>Edit with Semplice v4</h3>
					<p>This page was created with an older version of Semplice or another theme. The content is not compatible with Semplice v.4. You can click "Start editing" to edit the page with the current version, but you won’t be able to see or edit the original content within Semplice.</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="helper" data-action="activateSemplice" data-post-id="{{id}}">Start editing</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- no motions template -->
	<script id="no-motions-template" type="text/template">
		<div class="no-motions">
			<h3>Custom Animations</h3>
			<p>Per default automatic animations will reveal your content while scrolling. Click 'Activate Animations' to enable custom animations for this page or project.</p>
			<a class="activate-motions semplice-button" data-layout="{{mode}}" data-id="{{id}}">Activate Animations</a>
		</div>
	</script>
	<!-- theme update -->
	<script id="update-template" type="text/template">
		<div class="semplice-update">
			<div class="inner">
				<p><span>Update available!</span> New version: {{newVersion}} &mdash; <a href="https://www.semplice.com/changelog-v4-studio" target="_blank">Changelog</a></p>
				<div class="update-button">
					<a href="<?php echo admin_url('themes.php'); ?>">Update Semplice</a>	
				</div>
			</div>
		</div>
	</script>
	<script id="update-edition-template" type="text/template">
		<div class="semplice-update">
			<div class="inner">
				<p><span>Studio Upgrade available!</span> Please upgrade to the studio edition now!</p>
				<div class="update-button">
					<a href="<?php echo admin_url('themes.php'); ?>">Upgrade to Studio</a>	
				</div>
			</div>
		</div>
	</script>
	<!-- wrong folder -->
	<script id="wrong-folder-template" type="text/template">
		<div class="wrong-folder">
			<div class="wrong-folder-icon"><?php echo get_svg('backend', '/icons/popup_important'); ?></div>
			<p>To activate the Semplice One-click Update, your theme root folder must be called <span>/semplice4</span>. At the moment your theme root folder is: <span>/<?php echo get_template(); ?></span>. Please <a href="http://help.semplicelabs.com/customer/portal/articles/1911702-how-to-change-the-theme-root-folder-for-the-auto-update" target="_blank">read our small guide</a> on how to change that. Don't worry it's pretty easy and straight forward.</p>
		</div>
	</script>
	<!-- about -->
	<script id="about-template" type="text/template">
		<div id="about-semplice" class="popup">
			<div class="popup-inner">
				<a class="admin-click-handler close-about" data-handler="hidePopup">Close</a>
				<div class="popup-content">
					<h3><img src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/adler_about.png" alt="Adler"></h3>
					<?php echo semplice_about(); ?>
				</div>				
			</div>
		</div>
	</script>
	<!-- enable transitions-->
	<script id="enable-transitions-template" type="text/template">
		<div id="enable-transitions" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Enable Transitions</h3>
					<p>Transitions require your website to be set to 'Single Page App'. That means we can load new content without page reloads to make it more smooth.<br /><br /><span class="warning">Warning:</span> The 'Single Page App' mode is experimental. If you experience problems with plugins or anything else, you can always change this back on the Settings page</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="helper" data-action="enableTransitions">Activate Transitions</a>
				</div>					
			</div>
		</div>
	</script>
</div>