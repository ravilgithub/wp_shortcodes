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
				let selected,
				    imgs = [],
				    ids = [];
				
				selected = win
				            .state()
				            .get( 'selection' )
				            .toArray();

				// console.log( selected );

				for ( let i in selected ) {
					let atts = selected[ i ].attributes;
					ids[ i ] = atts.id;
					imgs[ i ] = $( '<img />', {
						src: atts.url,
						alt: atts.alt
					} );
				}

				// console.log( imgs );

				btn
				  .parent()
				  .find( '.briz-media-place' )
				    .html( imgs )
				    .end()
				  .find( 'input[type=hidden]' )
				    .attr( 'value', JSON.stringify( ids ) );
			} );

			win.open();
		} );

	} );
} )( jQuery );
