<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Bank Local
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php bloginfo( 'name' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
<script>
jQuery( document ).ready( function( $ ) {
	$( document.querySelectorAll( ".container" ) ).each(function ( i, el ) {
		var item = document.getElementById( $(el).data('bg') );
		$( item ).css({ height: $(el).css('height') });
	});
} );
</script>
</head>

<body <?php body_class(); ?>>