;( $ => {
	'use strict';
	
	$( document ).ready( () => {

		$( '.briz-media-button' ).on( 'click', evt => {
			let args, win, btn;
			
			btn = $( evt.target );
			
			args = {
				title: 'Insert a media',
				library: { type: 'image' },
				multiple: false,
				button: { text: 'Insert' }
			};

			win = wp.media( args );

			win.on( 'select', () => {
				let res, img;
				
				res = win
				        .state()
				        .get( 'selection' )
				        .first();

				img = $( '<img />', {
					src: res.attributes.url
				} );

				btn
				  .parent()
				  .find( '.briz-media-place' )
				  .html( img );
			} );

			win.open();
		} );

	} );
} )( jQuery );
