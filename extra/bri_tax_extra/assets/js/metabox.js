;( $ => {
	'use strict';
	
	$( document ).ready( () => {

		$( '.briz-media-button' ).on( 'click', evt => {
			let args, wpm, btn;
			
			btn = $( evt.target );
			
			args = {
				title: btn.data( 'title' ),
				library: { type: btn.data( 'library-type' ) },
				multiple: btn.data( 'multiple' ),
				button: { text: btn.data( 'button-text' ) }
			};

			wpm = wp.media( args );

			wpm.on( 'select', () => {
				let sel,
						imgs = [],
						ids = [];
				
				sel = wpm
				        .state()
				        .get( 'selection' )
				        .toArray();

				for ( let i in sel ) {
					let atts = sel[ i ].attributes;
					ids[ i ] = atts.id;
					imgs[ i ] = $( '<img />', {
						src: atts.url,
						alt: atts.alt
					} );
				}

				btn
					.parent()
					.find( '.briz-media-place' )
						.html( imgs )
						.end()
					.find( 'input[type=hidden]' )
						.attr( 'value', JSON.stringify( ids ) );
			} );

			wpm.on( 'open', () => {
				let sel = wpm.state().get( 'selection' ),
						ids = btn
										.parent()
										.find( 'input[type=hidden]' )
										.val();

				JSON.parse( ids )
					.forEach( id => {
						let attachment = wp.media.attachment( id );
						attachment.fetch();
						sel.add( attachment ? [ attachment ] : [] );
					} );
			} );

			wpm.open();
		} );

	} );
} )( jQuery );
