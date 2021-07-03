;( $ => {
	'use strict';

	$( document ).ready( () => {

		const range = {
			ctx: '.term-briz-range-wrap',

			numShow() {
				$( this.ctx ).each( ( idx, box ) => {
					const input = $( box ).find( 'input' ),
					      em    = $( box ).find( '.briz-range-current-value' );

					input.on( 'input', evt => {
						em.text( evt.target.value );
					} );
				} );
			},

			init() {
				this.numShow();
			}
		}

		range.init();


		/**
		 * Функционал описывающий работу с медиа файлами.
		 * Добавление, изменение и удаление медиа файлов в мета полях.
		 *
		 * @property String ctx - селектор обёртки мета поля.
		 *
		 * @since 0.0.1
		 * @autor Ravil
		 */
		const media = {
			ctx: '.briz-term-img-wrap',
			// ctx: '#briz-term-img-wrap',

			/**
			 * Объект создающийся для каждого мета поля "image".
			 *
			 * @property {Object} dom   - jQuery объекты элементов мета поля "image".
			 * @property Object wpm     - WP Media Object.
			 * @property Object wpmArgs - параметры передаваемые в WP Media Object.
			 *
			 * @since 0.0.1
			 */
			image: {
				dom: {},
				wpm: null,
				wpmArgs: {
					title: 'Select image',
					library: { type: 'image' },
					multiple: false,
					button: { text: 'Insert' }
				},


				/**
				 * Создаём объект wp.media и
				 * передаём ему первоначальные данные.
				 *
				 * @return {void}
				 */
				add() {
					$( this.dom.a ).on( 'click', evt => {
						evt.preventDefault();

						if ( ! this.wpm )
							this.wpm = wp.media( this.wpmArgs );

						this.select();
						this.open();
						this.wpm.open();
					} );
				},


				/**
				 * Обработчик открыия медиа библиотеки.
				 * Помечаем раннее выбранные медиа файлы если они есть.
				 *
				 * @return {void}
				 */
				open() {
					this.wpm.on( 'open', () => {
						const id  = $( this.dom.input ).val();

						if ( id ) {
							const img = this.wpm.state().get( 'selection' ),
							      attach = wp.media.attachment( id );

							attach.fetch();
							img.add( attach ? attach : [] );
						}
					} );
				},


				/**
				 * Обработчик выбора медиа данных в библиотеке.
				 *
				 * @return {void}
				 */
				select() {
					this.wpm.on( 'select', () => {
						const img = this.wpm.state().get( 'selection' ).first().toJSON();

						if ( img ) {
							const size = img.sizes.thumbnail || img.sizes.full;
							this.setAtts( img.id, size.url );
							this.btn( 'select' );
						}
					} );
				},


				/**
				 * Присваиваем атрибуты HTML элементам.
				 *
				 * @param Integer id - id медиа файла.
				 * @param String url - url медиа файла.
				 *
				 * @return {void}
				 */
				setAtts( id = '', url = '' ) {
					if ( ! url )
						url = $( this.dom.img ).data( 'default' );

					$( this.dom.input ).val( id );
					$( this.dom.img ).attr( 'src', url );
				},


				/**
				 * Прячем или показываем кнопку удаления из мета поля медиа файла.
				 *
				 * @param String action - действие которое совершается.
				 *
				 * @return {void}
				 */
				btn( action ) {
					const btn = $( this.dom.button );

					if ( 'select' == action ) {
						btn.removeClass( 'hidden' );
					} else {
						btn.addClass( 'hidden' );
					}
				},


				/**
				 * Удаление медиа данных.
				 *
				 * @return {void}
				 */
				del() {
					$( this.dom.button ).on( 'click', () => {
						this.setAtts();
						this.btn();
					} );
				},


				/**
				 * Добавление jQuery объекты элементов мета поля "image"
				 * в свойство "this.dom" для краткости кода.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setProps() {
					let $dom = this.dom;
					$dom[ 'input' ]  = $dom.tmpl.find( 'input' );
					$dom[ 'img' ]    = $dom.tmpl.find( 'img' );
					$dom[ 'button' ] = $dom.tmpl.find( 'button' );
					$dom[ 'a' ]      = $dom.tmpl.find( 'a' );
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
					this.add();
					this.del();
				}
			},


			/**
			 * Инициализация основных методов.
			 *
			 * @return {void}
			 */
			init() {
				$( this.ctx ).each( ( $idx, $el ) => {
					let newImage = { dom: {} };
					newImage.dom[ 'tmpl' ] = $( $el );

					$.extend( true, newImage, this.image );
					newImage.start();
				} );
			}
		};

		media.init();

	} );
} )( jQuery );
