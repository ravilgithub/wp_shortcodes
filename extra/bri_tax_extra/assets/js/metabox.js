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
				let selected, imgs = [];
				
				selected = win
				        .state()
				        .get( 'selection' )
				        .toArray();

				// console.log( selected );

				for ( let i in selected ) {
					imgs[ i ] = $( '<img />', {
						src: selected[ i ].attributes.url
					} );
				}

				// console.log( imgs );

				btn
				  .parent()
				  .find( '.briz-media-place' )
				  .html( imgs );
			} );

			win.open();
		} );

	} );
} )( jQuery );
