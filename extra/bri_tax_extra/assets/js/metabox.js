;( $ => {
	'use strict';
	
	$( document ).ready( () => {
		let add_action_txt,
		    edit_action_txt;

		let getBtnActionTxt = ( btn, action ) => {
			if ( 'del' === action ) {
				btn = btn.parent().find( '.briz-media-button' );
				console.log( btn );
			}
			add_action_txt = btn.data( 'add-text' );
			edit_action_txt = btn.data( 'edit-text' );
		};

		let btnHandler = ( btn, action ) => {
			getBtnActionTxt( btn, action );

			if ( 'add' === action ) {
				console.log( edit_action_txt );
			} else {
				console.log( add_action_txt );
			}
		};

		$( '.briz-del-media-button' ).on( 'click', evt => {
			let btn = $( evt.target );
			btnHandler( btn, 'del' );
		} );

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
						.html( () => { 
							btnHandler( btn, 'add' );
							return imgs;
						} )
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
