<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Bank Local
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php if ( function_exists('bl_display_map') ) bl_display_map(); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
