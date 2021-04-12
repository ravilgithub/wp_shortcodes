;( $ => {
	'use_strict';

	$( document ).ready( () => {

		const media = {
			ctx: '#briz-term-img-wrap',
			wpm: null,
			wpmArgs: {
				title: 'Select image',
				library: { type: 'image' },
				multiple: false,
				button: { text: 'Insert' }
			},

			add() {
				$( 'a', this.ctx ).on( 'click', evt => {
					evt.preventDefault();

					if ( ! this.wpm )
						this.wpm = wp.media( this.wpmArgs );

					this.select();
					this.open();
					this.wpm.open();
				} );
			},

			open() {
				this.wpm.on( 'open', () => {
					const id  = $( 'input', this.ctx ).val();

					if ( id ) {
						const img = this.wpm.state().get( 'selection' ),
						      attach = wp.media.attachment( id );

						attach.fetch();
						img.add( attach ? attach : [] );
					}
				} );
			},

			select() {
				this.wpm.on( 'select', () => {
					const img = this.wpm.state().get( 'selection' ).first().toJSON();

					if ( img ) {
						this.setAtts( img.id, img.sizes.thumbnail.url );
						this.btn( 'select' );
					}
				} );
			},

			setAtts( id = '', url = '' ) {
				if ( ! url )
					url = $( 'img', this.ctx ).data( 'default' );

				$( 'input', this.ctx ).val( id );
				$( 'img', this.ctx ).attr( 'src', url );
			},

			btn( action ) {
				const btn = $( 'button', this.ctx );

				if ( 'select' == action ) {
					btn.removeClass( 'hidden' );
				} else {
					btn.addClass( 'hidden' );
				}
			},

			del() {
				$( 'button', this.ctx ).on( 'click', () => {
					this.setAtts();
					this.btn();
				} );
			},

			init() {
				this.add();
				this.del();
			}
		};

		media.init();

	} );

} )( jQuery );
