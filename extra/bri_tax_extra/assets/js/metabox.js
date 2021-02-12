;( $ => {
	'use strict';

	$( document ).ready( () => {

		/**
		 * Функционал описывающий работу с медиа файлами.
		 * Добавление, изменение и удаление медиа файлов в мета полях.
		 *
		 * @since 0.0.1
		 * @autor Ravil
		 */
		let media = {

			/**
			 * Создаём объект wp.media и
			 * передаём ему первоначальные данные.
			 *
			 * @return void
			 */
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


			/**
			 * Формирование HTML выбранных медиа файлов.
			 *
			 * @param Object wpm - WP Media Object.
			 * @param Object atts - свойства выбранного медиа файла.
			 *
			 * @return String html - разметка медиа файлa и подпись к нему если имеется.
			 */
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


			/**
			 * Обработчик выбора медиа данных в библиотеке.
			 * Формирование данных о выбранных медиа файлах.
			 *
			 * @param Object wpm - WP Media Object.
			 * @param jQuery Object btn - кнопка Add/Edit media.
			 *
			 * @return void
			 */
			select( wpm, btn ) {
				wpm.on( 'select', () => {
					let sel,
					    els = [],
					    ids = [];

					sel = wpm
					        .state()
					        .get( 'selection' )
					        .toArray();

					for ( let i in sel ) {
						let atts = sel[ i ].attributes;
						ids[ i ] = atts.id;
						els[ i ] = this.createEl( wpm, atts );
					}

					ids = JSON.stringify( ids );
					this.setMedia( btn, 'add', els, ids );
				} );
			},


			/**
			 * Обработчик открыия медиа библиотеки.
			 * Помечаем раннее выбранные медиа файлы если они есть.
			 *
			 * @param Object wpm - WP Media Object.
			 * @param jQuery Object btn - кнопка Add/Edit media.
			 *
			 * @return void
			 */
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


			/**
			 * Добавление медиа данных.
			 *
			 * @param jQuery Object btn - кнопка Add/Edit или Delete media.
			 * @param String action - действие которое нужно выполнить - добавить или удалить медиа файлы.
			 * @param Array els - HTML добавляемых элементов.
			 * @param Array ids - WP идентификаторы добавляемых медиа файлов.
			 *
			 * @return void
			 */
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


			/**
			 * Удаление медиа данных.
			 *
			 * @return void
			 */
			del() {
				$( '.briz-del-media-button' ).on( 'click', evt => {
					let btn = $( evt.target );
					this.setMedia( btn, 'del' );
				} );
			},


			/**
			 * Изменение текста кнопок при нажатии на них.
			 *
			 * @param jQuery Object btn - кнопка Add/Edit или Delete media.
			 * @param String action - действие которое нужно выполнить - добавить или удалить медиа файлы.
			 *
			 * @return void
			 */
			btnHandler( btn, action ) {
				let btnTxt = btn.data( 'action-text' ),
				    activeClassName = 'briz-del-media-button-active';

				if ( 'add' == action ) {
					let stage = btn.data( 'stage' );
					if ( 'addidable' == stage ) {
						btn
						  .data( 'stage', 'edidable' )
						  .text( btnTxt )
						  .parent()
						  .find( '.briz-del-media-button' )
						    .addClass( activeClassName );
					}
				} else {
					btn
					  .removeClass( activeClassName )
					  .parent()
					  .find( '.briz-media-button' )
					    .data( 'stage', 'addidable' )
					    .text( btnTxt );
				}
			},


			/**
			 * Инициализация основных методов.
			 */
			init() {
				this.add();
				this.del();
			}
		};

		media.init();

	} );
} )( jQuery );
