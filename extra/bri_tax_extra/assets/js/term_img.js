;( $ => {
	'use_strict';

	$( document ).ready( () => {

		const media = {
			add() {
				$( '#briz-term-img-wrap a' ).on( 'click', evt => {
					evt.preventDefault();

					const args = {
						title: 'Select image',
						library: { type: 'image' },
						multiple: 0,
						button: { text: 'Insert' }
					},
					wpm = wp.media( args );

					wpm.open();
				} );
			},

			init() {
				this.add();
			}
		};

		media.init();

	} );

} )( jQuery );
