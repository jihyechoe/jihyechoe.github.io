<div id="semplice-editor">
	<!-- column count -->
	<div class="column-count"><span class="count"></span><sup class="col">Col</sup></div>
	<!-- grid -->
	<div id="semplice-grid" data-breakpoint="xl">
		<section class="content-block-grid">
			<div class="container">
				<div class="grid-row">
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
				</div>
			</div>
		</section>
	</div>

	<!-- top bar -->
	<header id="editor-header">
		<!-- exit without saving -->
		<div class="exit-without-saving">
			<a class="editor-action exit-button semplice-navigator-hover" data-action="slideIn" data-action-type="sidebar" data-element="#semplice-navigator" data-name="navigator"></a>
		</div>
		<!-- mobile  -->
		<div id="mobile-edit">
			Editing <span>Desktop</span>
		</div>
		<!-- add content -->
		<div class="editor-add">
			<nav>
				<ul>
					<li>
						<a class="add-content has-tooltip" data-module="paragraph">
							<?php echo get_svg('backend', '/icons/module_paragraph'); ?>
						</a>
						<div class="tooltip">Add Paragraph</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="image">
							<?php echo get_svg('backend', '/icons/module_image'); ?>
						</a>
						<div class="tooltip">Add Image</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="gallery">
							<?php echo get_svg('backend', '/icons/module_gallery'); ?>
						</a>
						<div class="tooltip">Add Gallery Slider</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="video">
							<?php echo get_svg('backend', '/icons/module_video'); ?>
						</a>
						<div class="tooltip">Add Self Hosted Video</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="spacer">
							<?php echo get_svg('backend', '/icons/module_spacer'); ?>
						</a>
						<div class="tooltip">Add Horizontal Spacer</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="button">
							<?php echo get_svg('backend', '/icons/module_button'); ?>
						</a>
						<div class="tooltip">Add Button</div>
					</li>
					<li>
						<a class="add-spacer-column has-tooltip" data-module="spacer-column">
							<?php echo get_svg('backend', '/icons/module_spacercolumn'); ?>
						</a>
						<div class="tooltip">Add Spacer Column</div>
					</li>
					<li class="cover-button">
						<a class="text-link editor-action" data-action="coverDropdown" data-action-type="helper">Cover</a>
						<div class="cover-dropdown">
							<div class="option">
								<div class="option-inner">
									<div class="attribute span4">
										<h4>Visibility</h4>
										<div class="option-switch">
											<ul class="twoway">
												<li class="cover-hidden active">
													<a name="cover" data-switch-val="hidden" data-input-type="switch" switch-type="twoway" class="listen-cover" data-option-type="cover">Hidden</a>
												</li>
												<li class="cover-visible">
													<a name="cover" data-switch-val="visible" data-input-type="switch" switch-type="twoway" class="listen-cover" data-option-type="cover">Visible</a>
												</li>
												<input type="hidden" name="cover" data-input-type="switch" switch-type="twoway" class="listen-cover" data-option-type="cover">
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="option">
								<div class="option-inner">
									<div class="attribute span4">
										<h4 class="import-cover-title">Import existing Cover</h4>
										<div class="select-box">
											<div class="sb-arrow"></div>
											<select name="import_cover" data-input-type="select-box" class="listen-import-cover">
												<option value="enabled" selected="">Select Page or Project</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="option">
								<div class="option-inner">
									<div class="attribute span4">
										<h4>Reset</h4>
										<div class="option-switch">
											<a class="reset-cover semplice-button delete-button editor-action" data-handler="execute" data-action-type="popup" data-action="resetCover">Reset Cover</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a class="editor-action show-modules text-link" data-action="slideIn" data-action-type="sidebar" data-element="#semplice-modules" data-name="modules">Modules</a>
					</li>
					<li>
						<a class="editor-action show-blocks text-link" data-action="slideIn" data-action-type="sidebar" data-element="#semplice-blocks" data-name="blocks">Blocks</a>
					</li>
				</ul>
			</nav>
		</div>
		<!-- save -->
		<div class="editor-meta">
			<nav>
				<ul>
					<li class="branding-button">
						<a class="editor-action has-tooltip cursor-pointer icon-button" data-action="brandingDropdown" data-action-type="helper">
							<?php echo get_svg('backend', '/icons/branding'); ?>
						</a>
						<div class="tooltip">Branding</div>
						<div class="branding-dropdown">
							<div class="inner">
								<div class="left"></div>
								<div class="right"></div>
							</div>
						</div>
					</li>
					<li>
						<a class="page-settings has-tooltip cursor-pointer admin-click-handler" data-handler="execute" data-action="init" data-action-type="postSettings" data-ps-mode="editor">
							<?php echo get_svg('backend', '/icons/post_settings'); ?>
						</a>
						<div class="tooltip">Page Settings</div>
					</li>
					<li>
						<a class="footer-settings has-tooltip cursor-pointer editor-action" data-handler="execute" data-action-type="popup" data-action="footerSettings">
							<?php echo get_svg('backend', '/icons/post_settings'); ?>
						</a>
						<div class="tooltip">Footer Settings</div>
					</li>
					<li class="breakpoints-button">
						<a class="editor-action cursor-pointer has-tooltip icon-button" data-handler="execute" data-action="breakpointsDropdown" data-action-type="helper">
							<?php echo get_svg('backend', '/icons/mobile_switch'); ?>
						</a>
						<div class="tooltip">Responsive</div>
						<div class="breakpoints-dropdown">
							<ul>
								<li><a class="change-breakpoint xl active-breakpoint" data-change-breakpoint="xl"><?php echo get_svg('backend', '/icons/breakpoints_desktop_wide'); ?><div class="tooltip">Desktop Wide</div></a></li>
								<li><a class="change-breakpoint lg" data-change-breakpoint="lg"><?php echo get_svg('backend', '/icons/breakpoints_desktop'); ?><div class="tooltip">Desktop</div></a></li>
								<li><a class="change-breakpoint md" data-change-breakpoint="md"><?php echo get_svg('backend', '/icons/breakpoints_tablet_wide'); ?><div class="tooltip">Tablet Wide</div></a></li>
								<li><a class="change-breakpoint sm" data-change-breakpoint="sm"><?php echo get_svg('backend', '/icons/breakpoints_tablet_portrait'); ?><div class="tooltip">Tablet Portrait</div></a></li>
								<li><a class="change-breakpoint xs" data-change-breakpoint="xs"><?php echo get_svg('backend', '/icons/breakpoints_mobile'); ?><div class="tooltip">Mobile</div></a></li>
							</ul>
						</div>
					</li>
					<li>
						<a class="show-preview has-tooltip cursor-pointer" href="" target="_blank">
							<?php echo get_svg('backend', '/icons/preview'); ?>
						</a>
						<div class="tooltip">Show Preview</div>
					</li>
					<li class="publish-button">
						<a class="text-link editor-action" data-action="publishDropdown" data-action-type="helper">Publish</a>
						<div class="publish-dropdown">
							<h3 class="unpublished-changes-text">Unpublished Changes</h3>
							<div class="option">
								<div class="option-inner">
										<div class="attribute">
												<h4>Status</h4>
												<div class="select-box">
														<div class="sb-arrow"></div>
														<select class="post-status-sb" name="post-status">
															<option value="publish">Published</option>
															<option value="draft">Draft</option>
															<!-- <option value="private">Private</option> -->
														</select>
												</div>
										</div>
								</div>
								<div class="option-inner post-password-option">
										<div class="attribute">
												<h4>Password protect</h4>
												<input type="text" name="post-password" placeholder="Leave empty if not needed">
										</div>
								</div>
							</div>
							<div class="update-button">
								<a class="editor-action semplice-button" data-action="post" data-action-type="save" data-save-mode="publish" data-change-status="yes">Update</a>
							</div>
						</div>
						<div id="unpublished-changes"></div>
					</li>
					<li>
						<?php
							global $admin_api;
							echo semplice_ajax_save_button('<a class="ajax-save-button editor-save text-link editor-action" data-action="post" data-action-type="save" data-save-mode="draft" data-change-status="no">');
						?>
					</li>
					<li>
						<a class="editor-action save-exit" data-action="saveAndExitDropdown" data-action-type="helper"><?php echo get_svg('backend', '/icons/save_and_exit'); ?></a>
						<ul class="save-exit-dropdown">
							<li><a class="editor-action confirm" data-action="postAndExit" data-action-type="save" data-exit-mode="close" data-post-type="page" data-reopen="undefined" data-new-url="undefined">Save &amp; Exit</a></li>
							<li><a class="editor-action cancel" data-action="exit" data-action-type="main" data-exit-mode="close" data-post-type="page" data-reopen="undefined" data-new-url="undefined">Exit without saving</a>
						</ul>
					</li>
			</div>
	</header>
	
	<!-- editor content -->
	<div id="editor-content" data-ep-init="" data-active-wysiwyg="" data-wysiwyg-type="">
		<!-- edit popups -->
		<div id="edit-popup"></div>
		<div id="content-holder"><!-- holder --></div>
	</div>

	<!-- navigator -->
	<div id="semplice-navigator" class="editor-sidebar semplice-navigator-hover">
		<?php 
			// get editor api
			global $editor_api;
			// output navigator
			echo $editor_api->navigator(); 
		?>
	</div>

	<!-- modules -->
	<div id="semplice-modules" class="editor-sidebar">
		<?php echo semplice_get_modules(); ?>
	</div>

	<!-- blocks -->
	<div id="semplice-blocks" class="editor-sidebar">
		<?php
			// include blocks
			global $editor_api;
			// output list
			echo $editor_api->blocks->list_blocks();
		?>
	</div>

	<!-- wysiwyg toolbar -->
	<div id="wysiwyg-toolbar"></div>

	<!-- re-order -->
	<div id="semplice-reorder">
		<a class="editor-action reorder" data-handler="execute" data-action-type="helper" data-action="reOrder"><?php echo get_svg('backend', '/icons/reorder'); ?></a>
		<div class="tooltip">Re-Order Sections</div>
	</div>

	<!-- coverslider open popup-->
	<div id="cs-open-popup">
		<a class="editor-action open" data-handler="execute" data-action-type="coverslider" data-action="editPopup"><?php echo get_svg('backend', '/icons/coverslider_edit'); ?></a>
		<div class="tooltip">Edit Coverslider</div>
	</div>
	
	<!-- editor templates -->
	<?php require get_template_directory() . '/admin/editor/templates.php'; ?>

</div>