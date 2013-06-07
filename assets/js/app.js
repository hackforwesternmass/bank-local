( function( window, $, undefined ) {
	"use strict";
	var document = window.document,
		throttle = false;

	// On event the case becomes a fact
	$( window ).bind( 'scroll', function() {
		throttle = true;
	});
	
	setInterval( function() {
		if ( throttle ) {
			// Once the case is the case, the action occurs and the fact is no more
			throttle = false;
			// Check position of dollar
			var offset = $( document.getElementById( 'dollar' ) ).offset();
			if ( offset.top > 3700 ){
				$( document.getElementById( 'dollar' ) ).css({ visibility:'hidden' });
			} else {
				$( document.getElementById( 'dollar' ) ).css({ visibility:'visible' });
			}
		}
	}, 50 );

} )( window, jQuery );