;( $ => {
	'use strict';
	
	$( document ).ready( () => {

		$( '.briz-media-button' ).on( 'click', evt => {
			let args = {
				title: 'Insert a media',
				library: { type: 'image' },
				multiple: false,
				button: { text: 'Insert' }
			};

			let win = wp.media( args );

			win.on( 'select', () => {
				let res = win.state().get( 'selection' ).first();
				console.log( res );

				let el = $( evt.target );
				let imagePlace = el.parent().find( '.briz-media-place' );

				$( '<img />', {
					src: res.attributes.url
				} ).appendTo( imagePlace );
			} );

			win.open();
		} );

	} );
} )( jQuery );