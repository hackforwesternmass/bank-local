jQuery(document).ready(function($) {

	$( '.sortable' ).sortable({
		handle: 'td.move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true
	});

	$( '.sortable' ).on('click', '.remove', function(e) {
		var item = $(this).closest('.item');
		item.remove();
		e.preventDefault();
		if ( $( '.sortable tr' ).length < 3 ) $( '.add-row' ).removeAttr('disabled');
	})

	$( '.add-row' ).on('click', function(e) {
		e.preventDefault();
		
		if ( $( '.sortable tr' ).length >= 3 ) return;
		
		var tmpl = _.template( $( "#tmpl-new-row" ).html() ),
			i = _.max( _.map( $( '.sortable tr' ), function(el){ return $(el).data('i'); }) ),
			row = tmpl({ i: i+1, text: '', title: '' }),
			html = $( row ).insertBefore( $( this ) );
		$( '.sortable' ).append( html );
		
		if ( $( '.sortable tr' ).length >= 3 ) $(this).attr('disabled','disabled');
	})
});