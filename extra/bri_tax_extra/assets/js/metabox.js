;( $ => {
	'use strict';

	$( document ).ready( () => {

		let media = {
			add() {
				$( '.briz-media-button' ).on( 'click', evt => {
					let args,
					    wpm,
					    btn = $( evt.target );

					args = {
						title: btn.data( 'title' ),
						library: { type: btn.data( 'library-type' ) },
						multiple: btn.data( 'multiple' ),
						button: { text: btn.data( 'button-text' ) }
					};

					wpm = wp.media( args );

					this.select( wpm, btn );
					this.open( wpm, btn );
					wpm.open();
				} );
			},

			select( wpm, btn ) {
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
								this.btnHandler( btn, 'add' );
								return imgs;
							} )
							.end()
						.find( 'input[type=hidden]' )
							.attr( 'value', JSON.stringify( ids ) );
				} );
			},

			open( wpm, btn ) {
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
			},

			del() {
				$( '.briz-del-media-button' ).on( 'click', evt => {
					let btn = $( evt.target );
					this.btnHandler( btn, 'del' );
				} );		
			},

			btnHandler( btn, action ) {
				if ( 'add' === action ) {
					console.log( 'edit' );
				} else {
					console.log( 'add' );
				}
			},

			init() {
				this.add();
				this.del();
			}
		};

		media.init();
	} );
} )( jQuery );
