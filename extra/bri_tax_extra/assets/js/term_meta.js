import range from './export/range.js';
range.init( '.term-briz-range-wrap' );

import media from './export/media.js';
media.init( '.briz-term-img-wrap');


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
		const media_button = {

			/**
			 * Создаём объект wp.media и
			 * передаём ему первоначальные данные.
			 *
			 * @return void
			 */
			add() {
				$( '.briz-term-media-button' ).on( 'click', evt => {
					const btn = $( evt.target ),
					      args = {
					        title: btn.data( 'title' ),
					        library: { type: btn.data( 'library-type' ) },
					        multiple: btn.data( 'multiple' ),
					        button: { text: btn.data( 'button-text' ) }
					      },
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
				const type = atts.type;

				let tag = '',
				    atrs = { src: atts.url }, // для 'audio' и 'video'.
				    html = '';

				if ( 'image' == type ) {
					tag = '<img />';
					atrs[ 'alt' ] = atts.alt;
					atrs[ 'src' ] = atts.sizes.thumbnail.url || atts.sizes.full.url;
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
					let els = [],
					    ids = [];

					const sel = wpm
					        .state()
					        .get( 'selection' )
					        .toArray();

					for ( const i in sel ) {
						const atts = sel[ i ].attributes;
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
					const sel = wpm.state().get( 'selection' ),
					      ids = btn
					              .parent()
					              .find( 'input[type=hidden]' )
					              .val();

					if ( ids ) {
						JSON.parse( ids )
							.forEach( id => {
								const attachment = wp.media.attachment( id );
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
					const btn = $( evt.target );
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
				const btnTxt = btn.data( 'action-text' ),
				      activeClassName = 'briz-del-media-button-active';

				if ( 'add' == action ) {
					const stage = btn.data( 'stage' );
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
					  .find( '.briz-term-media-button' )
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

		media_button.init();

	} );
} )( jQuery );
