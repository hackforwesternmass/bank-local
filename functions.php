<?php
/**
 * Bank Local functions and definitions
 *
 * @package Bank Local
 */

/**
 * Enqueue scripts and styles
 */
function bank_local_scripts() {
	wp_enqueue_style( 'bank-local-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'bank_local_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Create the Custom Post Type "Sections" with meta for points & design
 * Remove Posts from the menu (because we aren't using them)
 * Note: We're leaving pages for informational purposes.
 */
require get_template_directory() . '/inc/post-type-setup.php';