<!-- editor templates -->
<div id="editor-templates">
	<!-- edit popup template -->
	<script id="edit-popup-template" type="text/template">
		<div class="ep-content">
			<div class='ep-switch'>
				<ul>
					<li><a class='ep-content load-edit-popup active-switch' data-layout='content' data-switch="content" data-id="{{contentId}}" data-module="{{module}}"><!-- content --><span class="switch-tooltip">Content</span></a></li>
					<li><a class='ep-column load-edit-popup' data-layout='column' data-switch="column" data-id="{{contentId}}"><?php echo get_svg('backend', '/icons/ep_switch_column'); ?><span class="switch-tooltip">Column</span></a></li>
					<li><a class='ep-section load-edit-popup' data-layout='section' data-switch="section" data-id="{{contentId}}"><?php echo get_svg('backend', '/icons/ep_switch_section'); ?><span class="switch-tooltip">Section</span></a></li>
				</ul>
			</div>
			<div class="inner edit-popup-inner" data-popup-id="{{id}}">
				<div class="handlebar"><!-- draggable handle --></div>
				<nav class="ep-tabs-nav">
					<ul>
						{{tabsNav}}
						<li><a class="close-edit-popup" data-module="{{module}}" data-id="{{id}}"><!-- close ep --></a></li>
					</ul>
				</nav>
				<div class="edit-popup-help"><div class="close-popup-notice" data-mode="help"><?php echo get_svg('backend', '/icons/ep_close_help'); ?></div><div class="content"></div></div>
				<div class="ep-tabs">
				</div>
				<ul class="actions">
					<li><a class="editor-action duplicate mep-icon" data-action-type="duplicate" data-action="{{mode}}" data-id="{{id}}"><!-- Duplicate --></a><div class="tooltip tooltip-duplicate">Duplicate {{mode}}</div></li>
					<li><a class="editor-action delete mep-icon" data-layout-type="{{mode}}" data-action-type="popup" data-action="delete" data-id="{{id}}"><!-- Delete --></a><div class="tooltip tooltip-delete">Delete {{mode}}</div></li>
					<li><a class="save-block mep-icon editor-action" data-action-type="popup" data-action="saveBlock" data-content-id="{{sectionId}}"><!-- Save Block --></a><div class="tooltip tooltip-save">Save as block</div></li>
				</ul>
			</div>
		</div>
	</script>
	<!-- add section -->
	<script id="section-template" type="text/template">
		<section id="{{sectionId}}" class="content-block" data-column-mode-xs="single" data-column-mode-sm="single">
			<div class="container">
				<div id="{{rowId}}" class="row">
					<div id="{{columnId}}" class="column" data-xl-width="12">
						<div class="column-edit-head">
							<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
							<p>Col</p>
						</div>
						<div class="content-wrapper">
							<div id="{{contentId}}" class="column-content" data-module="{{module}}">
								{{content}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</script>
	<!-- add section with spacer column-->
	<script id="section-spacer-column-template" type="text/template">
		<section id="{{sectionId}}" class="content-block" data-column-mode-xs="single" data-column-mode-sm="single">
			<div class="container">
				<div id="{{rowId}}" class="row">
					<div id="{{columnId}}" class="column spacer-column" data-xl-width="12">
						<div class="column-edit-head">
							<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
							<p>Col</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</script>
	<!-- add empty section -->
	<script id="empty-section-template" type="text/template">
		<section id="{{sectionId}}" class="content-block" data-column-mode-xs="single" data-column-mode-sm="single">
			<div class="container">
				<div id="{{rowId}}" class="row">
				</div>
			</div>
		</section>
	</script>
	<!-- add column -->
	<script id="column-template" type="text/template">
		<div id="{{columnId}}" class="column" data-xl-width="12">
			<div class="column-edit-head">
				<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
				<p>Col</p>
			</div>
			<div class="content-wrapper">
				<div id="{{contentId}}" class="column-content" data-module="{{module}}">
					{{content}}
				</div>
			</div>
		</div>
	</script>
	<!-- add spacer column -->
	<script id="spacer-column-template" type="text/template">
		<div id="{{columnId}}" class="column spacer-column" data-xl-width="12">
			<div class="column-edit-head">
				<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
				<p>Col</p>
			</div>
			<div class="column-count"></div>
		</div>
	</script>
	<!-- add content -->
	<script id="content-template" type="text/template">
		<div id="{{contentId}}" class="column-content" data-module="{{module}}">
			{{content}}
		</div>
	</script>
	<!-- add column -->
	<script id="cover-template" type="text/template">
		<div id="{{columnId}}" class="column" data-xl-width="12">
			<div class="column-edit-head">
				<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
				<p>Col</p>
			</div>
			<div class="content-wrapper">
				<div id="{{contentId}}" class="column-content" data-module="{{module}}">
					{{content}}
				</div>
			</div>
		</div>
	</script>
	<!-- image module template -->
	<script id="module-template-image" type="text/template">
		<div class="ce-image"><img class="is-content" src="<?php echo get_template_directory_uri() . '/assets/images/admin/placeholders/image.png'; ?>" alt="default editor image"></div>
	</script>
	<!-- paragraph module template -->
	<script id="module-template-paragraph" type="text/template">
		<div class="is-content wysiwyg-editor wysiwyg-edit" data-wysiwyg-id="{{id}}" contenteditable="false"><p>Hey there, this is the default text for a new paragraph. Feel free to edit this paragraph by clicking on the yellow edit icon. After you are done just click on the yellow checkmark button on the top right. Have Fun!</p></div>
	</script>
	<!-- gallery odule template -->
	<script id="module-template-gallery" type="text/template">
		<img class="is-content" src="<?php echo get_template_directory_uri() . '/assets/images/admin/placeholders/gallery.png'; ?>" alt="gallery-placeholder">
	</script>
	<!-- oembed module template -->
	<script id="module-template-oembed" type="text/template">
		<img class="is-content" src="<?php echo get_template_directory_uri() . '/assets/images/admin/placeholders/oembed.png'; ?>" alt="oembed-placeholder">
	</script>
	<!-- video module template -->
	<script id="module-template-video" type="text/template">
		<div class="ce-video">
			<img src="<?php echo get_template_directory_uri() . '/assets/images/admin/placeholders/video.png'; ?>" class="is-content" alt="video-placeholder">
		</div>
	</script>
	<!-- spacer module template -->
	<script id="module-template-spacer" type="text/template">
		<div class="spacer-container">
			<div class="is-content">
				<div class="spacer"><!-- horizontal spacer --></div>
			</div>
		</div>
	</script>
	<!-- portfolio grid module template -->
	<script id="module-template-portfoliogrid" type="text/template">
	</script>
	<!-- dribbbble module template -->
	<script id="module-template-dribbble" type="text/template">
	</script>
	<!-- instagram module template -->
	<script id="module-template-instagram" type="text/template">
	</script>
	<!-- gallerygrid module template -->
	<script id="module-template-gallerygrid" type="text/template">
	</script>
	<!-- button module template -->
	<script id="module-template-button" type="text/template">
		<div class="ce-button">
			<div class="is-content">
				<a>Semplice Button</a>
			</div>
		</div>
	</script>
	<!-- code module template -->
	<script id="module-template-code" type="text/template">
		<div class="ce-code">
			<img src="<?php echo get_template_directory_uri() . '/assets/images/admin/placeholders/code.png'; ?>" class="is-content" alt="code-placeholder">
		</div>
	</script>
	<!-- share module template -->
	<script id="module-template-share" type="text/template">
		<?php echo semplice_share_box_html(array('type' => 'icons'), false); ?>
	</script>
	<!-- share module template -->
	<script id="module-template-share-buttons" type="text/template">
		<?php echo semplice_share_box_html(array('type' => 'buttons'), false); ?>
	</script>
	<!-- mailchimp module template -->
	<script id="module-template-mailchimp" type="text/template">
		<div class="mailchimp-newsletter is-content">
			<form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate">
				<input type="text" value="" name="FNAME" id="mce-FNAME" class="mailchimp-input" size="16" placeholder="First Name" data-font-size="18px">
				<input type="email" value="" name="EMAIL" id="mce-EMAIL" class="mailchimp-input" size="16" placeholder="E-Mail Address">
				<button class="mailchimp-submit-button" type="submit"  value="Subscribe" name="subscribe" id="mc-embedded-subscribe">Subscribe</button>
			</form>
		</div>
	</script>
	<!-- exit popup -->
	<script id="exit-template" type="text/template">
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
				<a class="editor-action cancel" data-action="exit" data-action-type="main" data-exit-mode="close" data-post-type="{{postType}}" data-reopen="{{reOpenUrl}}" data-new-url="{{newUrl}}">Don't Save</a>
				<a class="editor-action confirm semplice-button" data-action="postAndExit" data-action-type="save" data-exit-mode="close" data-post-type="{{postType}}" data-reopen="{{reOpenUrl}}" data-new-url="{{newUrl}}">Save &amp; Exit</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- delete popup -->
	<script id="delete-template" type="text/template">
		<div id="semplice-delete" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Delete content</h3>
					<p>Are you sure you want to delete this content?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-action="{{action}}" data-action-type="delete" data-id="{{id}}">Delete</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- actijve editor -->
	<script id="active-editor" type="text/template">
		<a href="#edit/{{postId}}" id="editor-active">
			<div class="inner">
				<h5>Last Edited Post</h5>
				<h4>{{postTitle}}</h4>
			</div>
		</a>
	</script>
	<!-- reset changes popup -->
	<script id="reset-changes-template" type="text/template">
		<div id="breakpoint-reset-changes" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Are you sure?</h3>
					<p>This will reset all changes made to the section in this breakpoint. This includes styles, options and content. (for example customized paragraphs)</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action="resetChanges" data-action-type="helper" data-content-id="{{id}}">Reset Changes</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- copy styles popup -->
	<script id="copy-styles-template" type="text/template">
		<div id="breakpoint-copy-styles" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Are you sure?</h3>
					<p>This will reset all changes made to the section in this breakpoint. This includes styles, options and content. (for example customized paragraphs)</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action="copyStyles" data-action-type="helper" data-content-id="{{id}}" data-val="{{val}}">Copy Styles</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- save block popup -->
	<script id="save-block-template" type="text/template">
		<div id="save-block" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<h3>Save section as block</h3>
					<p class="block-notice">This will save your section as a block. It's only possible to save sections as a block, not single content or columns. </p>
					<div class="option">
						<div class="option-inner">
							<div class="attribute span4-popup">
								<input type="text" placeholder="Block Name" name="block-name">
							</div>
						</div>
					</div>
				</div>
				<div class="popup-footer">
					<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button save-block-button" data-action="save" data-action-type="blocks" data-content-id="{{id}}">Save</a>
				</div>
			</div>
		</div>
	</script>
	<!-- dribbble popup -->
	<script id="dribbble-popup-template" type="text/template">
		<div id="dribbble-token" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<h3>Connect Dribbble</h3>
					<div class="option">			
						<div class="option-inner">
							<div class="attribute span4-popup">
								<h4>Username</h4>
								<input type="text" placeholder="Username" name="dribbble-id">
							</div>
						</div>
					</div>
					<div class="option">
						<div class="option-inner">
							<div class="attribute span4-popup">
								<h4>Token</h4>
								<input type="text" placeholder="Access Token" name="dribbble-token">
							</div>
						</div>
					</div>
				</div>
				<div class="popup-footer">
					<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button save-block-button" data-action="dribbbleToken" data-action-type="save" data-content-id="{{id}}">Save</a>
				</div>
			</div>
		</div>
	</script>
	<!-- delete block popup -->
	<script id="delete-block-template" type="text/template">
		<div id="semplice-delete-block" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Delete block</h3>
					<p>Are you sure you want to delete this block?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-action="delete" data-action-type="blocks" data-block-id="{{id}}">Delete</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- publish dropdown -->
	<script id="publish-dropdown-template" type="text/template">
		{{ options }}
		<a class="editor-action" data-action="post" data-action-type="save" data-save-mode="publish">Update</a>
	</script>
	<!-- import cover popup -->
	<script id="import-cover-template" type="text/template">
		<div id="semplice-import-cover" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Import Cover</h3>
					<p>This will overwrite your existing cover. Are you sure?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action-type="helper" data-action="importCover" data-post-id="{{postId}}">Import</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- reset cover popup -->
	<script id="reset-cover-template" type="text/template">
		<div id="semplice-reset-cover" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<div class="important">
						<?php echo get_svg('backend', '/icons/popup_important'); ?>
					</div>
					<h3>Reset Cover</h3>
					<p>Are you sure you want to reset your cover?</p>
				</div>
				<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-action-type="helper" data-action="resetCover">Reset</a>
				</div>					
			</div>
		</div>
	</script>
	<!-- default cover tmeplate -->
	<script id="default-cover-template" type="text/template">
		<?php echo semplice_default_cover('hidden'); ?>
	</script>
	<!-- empty editor -->
	<script id="empty-editor-template" type="text/template">
		<div id="empty-editor">
			<div class="drag-and-drop"><img src="<?php echo get_template_directory_uri() . '/assets/images/admin/empty_editor_drag.png'; ?>"></div>
			<div class="content">
				<h3 class="text">Drag an item from the topbar &amp;<br />and drop here to add content.</h3>
			</div>
			<div class="help-videos">
				<a href="https://vimeo.com/218478975/01b7db221e" target="_blank">Watch Tutorial</a>
				<!--
				<span>or</span>
				<a class="demo-content" href="link/to/video/tutorial" target="_blank">Load demo content</a>
				-->
			</div>
		</div>
	</script>
	<!-- footer rename popup -->
	<script id="footer-settings-template" type="text/template">
		<div id="semplice-footer-settings" class="popup">
			<div class="popup-inner">
				<div class="popup-content">
					<h3>Footer settings</h3>
					<div class="option">
						<div class="option-inner">
							<div class="attribute span4-popup">
								<h4>Title</h4>
								<input type="text" placeholder="Footer title" name="title" class="is-footer-setting" value="{{title}}">
							</div>
						</div>
					</div>
				</div>
				<div class="popup-footer">
					<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button add-post-button" data-handler="execute" data-action="footerTitle" data-action-type="save" data-post-id="{{id}}">Save</a>
				</div>
			</div>
		</div>
	</script>
	<!-- select covers -->
	<script id="select-covers-template" type="text/template">
		<div class="grid-categories select-covers">
			<div class="close-popup-notice" data-mode="covers">
				<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
			</div>
			<div class="content">
				<p class="notice-heading">Select Pages and Projects</p>
				<nav class="editor-action" data-handler="execute" data-action-type="coverslider" data-action="add">
					<ul class="cover-list">{{posts}}</ul>
				</nav>
			</div>
		</div>
	</script>
</div>