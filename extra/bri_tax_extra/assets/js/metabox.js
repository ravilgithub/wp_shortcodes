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

			createEl( wpm, atts ) {
				let type = atts.type,
						tag = '',
						atrs = { src: atts.url },
						html = '';

				if ( 'image' == type ) {
					tag = '<img />';
					atrs[ 'alt' ] = atts.alt;
				} else if ( 'audio' == type ) {
					tag = '<audio />';
					atrs[ 'controls' ] = 'controls';
				} else if ( 'video' == type ) {
					tag = '<video />'
					atrs[ 'controls' ] = 'controls';
				}

				if ( atts.caption ) {
					html = $( '<figcaption />', { text: atts.caption } )
					        .get( 0 )
					        .outerHTML;
				}

				html += $( tag, atrs )
				          .get( 0 )
				          .outerHTML;

				return html;
			},

			select( wpm, btn ) {
				wpm.on( 'select', () => {
					let sel,
					    els = [],
					    ids = [];

					sel = wpm
					        .state()
					        .get( 'selection' )
					        .toArray();

					console.log( sel );

					for ( let i in sel ) {
						let atts = sel[ i ].attributes;
						ids[ i ] = atts.id;
						els[ i ] = this.createEl( wpm, atts );
					}

					ids = JSON.stringify( ids );
					this.setMedia( btn, 'add', els, ids );
				} );
			},

			open( wpm, btn ) {
				wpm.on( 'open', () => {
					let sel = wpm.state().get( 'selection' ),
							ids = btn
							        .parent()
							        .find( 'input[type=hidden]' )
							        .val();

					if ( ids ) {
						JSON.parse( ids )
							.forEach( id => {
								let attachment = wp.media.attachment( id );
								attachment.fetch();
								sel.add( attachment ? [ attachment ] : [] );
							} );
					}
				} );
			},

			setMedia( btn, action, els = '', ids = '' ) {
				btn
					.parent()
					.find( '.briz-media-place' )
						.html( () => {
							this.btnHandler( btn, action );
							return els;
						} )
						.end()
					.find( 'input[type=hidden]' )
						.attr( 'value', ids );
			},

			del() {
				$( '.briz-del-media-button' ).on( 'click', evt => {
					let btn = $( evt.target );
					this.setMedia( btn, 'del' );
				} );
			},

			btnHandler( btn, action ) {
				let btnTxt = btn.data( 'action-text' );

				if ( 'add' == action ) {
					let stage = btn.data( 'stage' );
					if ( 'addidable' == stage ) {
						btn
						  .data( 'stage', 'edidable' )
						  .text( btnTxt )
						  .parent()
						  .find( '.briz-del-media-button' )
						    .addClass( 'briz-del-media-button-active' );
					}
				} else {
					btn
					  .removeClass( 'briz-del-media-button-active' )
					  .parent()
					  .find( '.briz-media-button' )
					    .data( 'stage', 'addidable' )
					    .text( btnTxt );
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
