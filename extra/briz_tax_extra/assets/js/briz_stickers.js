;( $ => {
	'use strict';

	$( document ).ready( () => {

		/**
		 * Stickers Actions.
		 *
		 * @property {String} ctx  - селектор каждого шаблона "stickers".
		 * @property {Object} stkr - объект создающийся для каждого шаблона "stickers".
		 *
		 * @since 0.0.1
		 * @author Ravil.
		 */
		const $stickersMassonry = {
			ctx: '.briz-stickers-tmpl',


			/**
			 * Объект создающийся для каждого шаблона "stickers".
			 *
			 * @property {Boolean / Object} msnry - объект Masonry. Default: false.
			 * @property {Object} dom - jQuery объекты элементов шаблона "stickers".
			 *
			 * @since 0.0.1
			 */
			stkr: {
				msnry: false,
				dom: {},


				/**
				 * Инициализация объекта "Masonry".
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				msnryInit () {
					if ( ! this.msnry ) {
						this.dom.grid.imagesLoaded()
							.done( instance => {
								this.msnry = this.dom.grid.masonry( {
									itemSelector: this.dom.item,
									columnWidth: this.dom.item,
									percentPosition: true,
								} );
							} )
							.fail( err => {
								console.log( err );
							} );
					}
				},


				/**
				 * Пересборка элементов.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				msnryReload() {
					if ( this.msnry ) {
						this.msnry.masonry( 'reloadItems' );
					}
				},


				/**
				 * Удаление всего функционала "Masonry".
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				msnryDestroy() {
					if ( this.msnry ) {
						this.msnry.masonry( 'destroy' );
						this.msnry = false;
					}
				},


				/**
				 * Определение действий в зависимости от ширины экрана.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setMasonry() {
					// Потестить на Android
					// для FireFox
					if ( $( window ).width() > 976 ) {
					// Для Opera
					// if ( ( ( ! Modernizr.touch ) && ( $( window ).width() > 976 ) ) || ( $( window ).width() > 991 ) ) {
						this.msnryInit();
						this.msnryReload();
					} else {
						this.msnryDestroy();
					}
				},


				/**
				 * Обработчик события "resize".
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				resizeHandler() {
					$( window ).on( 'resize', () => {
						this.setMasonry();
					} );
				},


				/**
				 * Добавление jQuery объекты элементов шаблона "stickers"
				 * в свойство "this.dom" для кратости кода.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setProps() {
					let dom = this.dom;
					dom[ 'grid' ] = dom.tmpl.find( '.stickers-content-grid' );
					dom[ 'item' ] = '.stickers-content-item';
				},


				/**
				 * Let's go.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				start() {
					this.setProps();
					this.setMasonry();
					this.resizeHandler();
				}
			},


			/**
			 * Создание независимого объекта "stkr"
			 * для каждого шаблона "stickers".
			 *
			 * @return {void}
			 *
			 * @since 0.0.1
			 */
			init() {
				$( this.ctx ).each( ( idx, $el ) => {
					let newStkr = { dom: {} };
					newStkr.dom[ 'tmpl' ] = $( $el );

					$.extend( true, newStkr, this.stkr );
					newStkr.start();
				} );
			},
		};

		$stickersMassonry.init();
	} );

} )( jQuery );
