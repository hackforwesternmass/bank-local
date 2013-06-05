<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bank Local
 */

if ( WP_DEBUG ){
	$intro_id = 85;
	$you_id = 86;
	$community_id = 87;
	$join_id = 88;
} else {
	$intro_id = 8;
	$you_id = 9;
	$community_id = 10;
	$join_id = 11;
}

get_header(); ?>

<div class="bg image hand top"></div>

<header id="a-story" class="sky-top">
	<div class="container">
		<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		<?php bl_callouts( $intro_id ); ?>
	</div>
</header>

<section id="benefits-for-you" class="sky-bottom">
	<div class="bg image clouds-1 bottom"></div>
	<div class="bg image clouds-2 bottom"></div>
	<div class="bg image rainbow lower"></div>
	<div class="bg image hills mid"></div>

	<div class="container">
		<div class="image bird top"></div>
		<h3><?php echo get_the_title( $you_id ); ?></h3>
		<?php bl_callouts( $you_id ); ?>
	</div>
</section>

<section id="benefits-for-community" class="valley">
	<div class="bg image waves mid">
		<div class="waves-1"><div></div></div>
		<div class="waves-2"><div></div></div>
		<div class="seamonster"></div>
		<div class="waves-3"><div></div></div>
	</div>
	<div class="bg image trees mid"></div>
	<div class="bg image houses mid"></div>

	<div class="container">
		<h3><?php echo get_the_title( $community_id ); ?></h3>
		<?php bl_callouts( $community_id ); ?>
	</div>
</section>

<section id="make-the-switch">
	<div class="image pig-bottom bottom"></div>
	<div class="image pig top"></div>

	<div class="container">
		<h3><?php echo get_the_title( $join_id ); ?></h3>
		<?php bl_callouts( $join_id ); ?>
	</div>

	<!--<div class="bg">
	<?php //if ( function_exists( 'bl_display_map' ) ) bl_display_map(); ?>
	</div>-->
</section>

<div class="bg image dollar fixed higher"></div>

<?php get_footer(); ?>