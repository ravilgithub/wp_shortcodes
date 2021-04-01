;( $ => {
	'use strict';

	$( document ).ready( () => {

		// Stickers Massonry
		const $stickersMassonry = {
			msnry: false,
			ctx: '.stickers-content-grid',

			msnryInit () {
				if ( ! this.msnry ) {
					this.msnry = $( this.ctx ).masonry( {
						itemSelector: '.stickers-content-item',
						columnWidth: '.stickers-content-item',
						percentPosition: true,
					} );
				}
			},

			msnryReload() {
				if ( this.msnry ) {
					this.msnry.masonry( 'reloadItems' );
				}
			},

			msnryDestroy() {
				if ( this.msnry ) {
					this.msnry.masonry( 'destroy' );
					this.msnry = false;
				}
			},

			setMasonry() {
				// Потестить на Android
				if ( $( window ).width() > 976 ) {  // для FireFox
				// if ( $( window ).width() > 991 ) {  // для FireFox
				// if ( ( ( ! Modernizr.touch ) && ( $( window ).width() > 976 ) ) || ( $( window ).width() > 991 ) ) {  // Для Opera
					this.msnryInit();
					this.msnryReload();
				} else {
					this.msnryDestroy();
				}
			},

			init() {
				this.setMasonry();
			},
		};

		$stickersMassonry.init();
		console.log( 'stickers' );

	} );

} )( jQuery );
