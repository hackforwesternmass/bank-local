<?php
/**
 * Format the callouts for display
 */
function bl_callouts( $id ){
	$section = get_post_meta( $id, 'section_points', true ); 
	$classes = array( 'one', 'two', 'three' );
	foreach ( $section as $i => $callout ) {
		if ( ! empty( $callout['text'] ) ) 
			printf( '<div class="callout %1$s">%2$s</div>', $classes[$i], $callout['text'] );
	}
}