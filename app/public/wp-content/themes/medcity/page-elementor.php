<?php
/**
 * Template Name: Medcity Elementor 
 * Template Post Type: page, footer
 * 
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package Medcity
 * @since 1.1.1
 * @author Chinh Duong Manh
 * @email duongmanhchinh@gmail.com
 */
// Header
get_header('elementor');
// Content
while ( have_posts() )
{
    the_post();
    the_content();
}
// Footer
get_footer('elementor');