<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @package Medcity
 * @since 1.1.1
 * @author Chinh Duong Manh - duongmanhchinh@gmail.com
 */ 
$back_totop_on = medcity_get_opt('back_totop_on', true);

medcity_elementor_footer();
medcity_search_popup();
medcity_sidebar_hidden(); 
if (isset($back_totop_on) && $back_totop_on) : ?>
    <a href="#" class="scroll-top"><i class="fas fac-arrow-up"></i></a>
<?php 
	endif; 
wp_footer(); 
?>
</body>
</html>
