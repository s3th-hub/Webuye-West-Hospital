<?php
/**
 * @package Bravis-Themes
 */
$back_totop_on = meddox()->get_theme_opt('back_totop_on', true); ?>
		</div><!-- #main -->

		<?php meddox()->footer->getFooter(); ?>
		<?php  do_action( 'pxl_anchor_target') ?>
		<?php if (isset($back_totop_on) && $back_totop_on) : ?>
		    <a class="pxl-scroll-top" href="#">
		    	
		    </a>
		<?php endif; ?>

		</div><!-- #wapper -->
	<?php wp_footer(); ?>
	</body>
</html>
