<?php

// -----------------------------------------
// grid
// -----------------------------------------

function semplice_grid($mode) {

	// css
	$output = '';
	$gutter = 0;
	$outer_padding = 30;
	$grid_width = 1170;

	// get custom grid values
	$grid = json_decode(get_option('semplice_customize_grid'), true);

	if(is_array($grid)) {

		// outer padding
		if(isset($grid['outer_padding']) && $mode == 'frontend') {
			$outer_padding = $grid['outer_padding'];
			// outer padding only for desktop
			$output .= '
				@media screen and (min-width: 1170px) {
					.container-fluid, .container, .admin-container {
						padding: 0 ' . round($outer_padding / 18, 5) . 'rem 0 ' . round($outer_padding / 18, 5) . 'rem;
					}
				}
			';
		}

		// grid width
		if(isset($grid['width'])) {
			// is < 1170?
			if($grid['width'] < 1170) {
				$grid_width = 1170;
			} else {
				$grid_width = $grid['width'];
			}	
		}

		// css
		$output .= '.container {
			max-width: ' . ($grid_width + ($outer_padding * 2)) . 'px;
		}';
		
		// mobile gutter
		if(isset($grid['responsive_gutter']) && is_numeric($grid['responsive_gutter'])) {
			$output .= semplice_get_grid_breakpoint($grid['responsive_gutter'], $mode, false);
		}

		// xl gutter 
		if(isset($grid['gutter']) && is_numeric($grid['gutter'])) {
			$output .= semplice_get_grid_breakpoint($grid['gutter'], $mode, true);
			$gutter = $grid['gutter'];
		}		
	}

	return $output;
}

// -----------------------------------------
// grid breakpoint
// -----------------------------------------

function semplice_get_grid_breakpoint($gutter, $mode, $is_desktop) {
	// media query open
	$output = '';
	// define prefix
	$prefix = '';
	if($mode == 'editor') {
		if($is_desktop) {
			$prefix = '[data-breakpoint="xl"]';
		}
		// row
		$output .= $prefix . ' .row {
			margin-left: -' . ($gutter / 2) . 'px;
			margin-right: -' . ($gutter / 2) . 'px;
		}';
		// column
		$output .= $prefix . ' .column, .grid-column {
			padding-left: ' . ($gutter / 2) . 'px;
			padding-right: ' . ($gutter / 2) . 'px;
		}';
	} else {
		if($is_desktop) {
			$prefix = '@media screen and (min-width: 1170px) {';
		} else {
			$prefix = '@media screen and (max-width: 1169px) {';
		}

		$output .= $prefix . ' .row {
			margin-left: -' . ($gutter / 2) . 'px;
			margin-right: -' . ($gutter / 2) . 'px;
		}';
		
		$output .= '.column, .grid-column {
			padding-left: ' . ($gutter / 2) . 'px;
			padding-right: ' . ($gutter / 2) . 'px;
		}';

		// close media query
		$output .= '}';
	}

	return $output;
}

// -----------------------------------------
// masonry
// -----------------------------------------

function semplice_masonry($id, $masonry_items, $hor_gutter, $ver_gutter, $add_to_css) {

	// vars
	$masonry = '';
	$masonry_css = '';

	// masonry css
	$masonry_css = '
		<style id="' . $id . '-style" type="text/css">
			#masonry-'. $id .'{ margin: auto -' . ($hor_gutter / 2) . 'px !important; } 
			.masonry-'. $id .'-item { margin: 0px; padding-left: ' . ($hor_gutter / 2) . 'px; padding-right: ' . ($hor_gutter / 2) . 'px; padding-bottom: ' . $ver_gutter . 'px; }
			' . $add_to_css . '
		</style>
	';

	$masonry_css = str_replace(array("\r","\n", "\t"),"",$masonry_css);

	// open masonry
	$masonry .= '
		<div id="masonry-' . $id . '" class="masonry">
			<div class="masonry-item-width"></div>
			' . $masonry_items . '
		</div>
	';

	// javascript
	$masonry .= '
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					// delete old css if there
					$("#' . $id . '-style").remove();
					// add css to head
					$("head").append(\'' . $masonry_css . '\');
					// define container
					var $container = $("#masonry-' . $id . '");
					// make jquery object out of items
					var $items = $(".masonry-' . $id . '-item");

					// fire masmonry
					$container.masonry({
						itemSelector: ".masonry-' . $id . '-item",
						columnWidth: ".masonry-item-width",
						transitionDuration: 0,
						isResizable: true,
						percentPosition: true,
					});

					// show images
					showImages($container, $items);

					// load images and reveal if loaded
					function showImages($container, $items) {
						// get masonry
						var msnry = $container.data("masonry");
						// get item selector
						var itemSelector = msnry.options.itemSelector;
						// append items to masonry container
						//$container.append($items);
						$items.imagesLoaded().progress(function(imgLoad, image) {
							// get item
							var $item = $(image.img).parents(itemSelector);
							// fade in item
							// layout
							msnry.layout();
							// fade in item
							$item.css("opacity", 1);	
						});
					}
				});
			})(jQuery);
		</script>
	';

	// output
	return $masonry;
}

?>