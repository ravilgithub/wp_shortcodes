;( $ => {
	'use strict';
	
	$( document ).ready( () => {

		$( '.briz-media-button' ).on( 'click', evt => {
			let args, win, btn;
			
			btn = $( evt.target );
			
			args = {
				title: btn.data( 'title' ),
				library: { type: btn.data( 'library-type' ) },
				multiple: btn.data( 'multiple' ),
				button: { text: btn.data( 'button-text' ) }
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
