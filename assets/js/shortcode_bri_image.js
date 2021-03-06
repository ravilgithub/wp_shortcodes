;( $ => {
	'use_strict';

	$( document ).ready( () => {

		/**
		 * Функционал картинок шорткода bri_image.
		 *
		 * @since 0.0.1
		 * @autor Ravil
		 */
		const $setShortcodeBriImageActions = {

			/**
			 * Показ миниатюр ввиде всплывающих окон.
			 * 
			 * @return {void}
			 * 
			 * @since 0.0.1
			 */
			setMagnificPopup() {
				$( '.shortcode_bri_image' ).magnificPopup( {
					delegate: 'a.shortcode_bri_image_mfp_popup_icon',
					type: 'image',
					preloader: true,
					// gallery: {
					// 	enabled: true
					// },

					// Zoom ( CSS - Begin MFP Zoom )
					mainClass: 'mfp-with-zoom',
					zoom: {
						enabled: true,
						duration: 300,
						easing: 'ease-in-out',
						opener( $openerElement ) {
							const $parent = $openerElement.parents( '.shortcode_bri_image' );
							return $( 'img', $parent );
						}
					},

					// Fade ( CSS - Begin MFP Fade )
					// removalDelay: 300,
					// mainClass: 'mfp-fade',

					callbacks: {
						beforeOpen( attr ) {
							// console.log( attr );
							// console.log( arguments );
							// console.log( this );
							// this.delegate = 'img';
						},
						open() {},
						close() {},
						elementParse( item ) {}
					},
				} );
			},

			/**
			 * Инициализация.
			 */
			init: function() {
				this.setMagnificPopup();
			}
		};

		$setShortcodeBriImageActions.init();

	} );
} )( jQuery );
