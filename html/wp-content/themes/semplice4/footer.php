<?php

// -----------------------------------------
// semplice
// footer.php
// -----------------------------------------

?>
	<?php get_template_part('partials/photoswipe', 'standard'); ?>
	<div class="back-to-top">
		<a class="semplice-event" data-event-type="helper" data-event="scrollToTop"><?php echo get_svg('frontend', '/icons/arrow_up'); ?></a>
	</div>
	<?php wp_footer(); # include wordpress footer ?>
	</body>
</html>