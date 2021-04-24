;( $ => {
	'use_strict';

	$( document ).ready( () => {

		/**
		 * Функционал описывающий работу с медиа файлами.
		 * Добавление, изменение и удаление медиа файлов в мета полях.
		 *
		 * @property String ctx     - селектор обёртки мета поля.
		 * @property Object wpm     - WP Media Object.
		 * @property Object wpmArgs - параметры передаваемые в WP Media Object.
		 *
		 * @since 0.0.1
		 * @autor Ravil
		 */
		const media = {
			ctx: '#briz-term-img-wrap',
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
				$( 'a', this.ctx ).on( 'click', evt => {
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
					const id  = $( 'input', this.ctx ).val();

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
					url = $( 'img', this.ctx ).data( 'default' );

				$( 'input', this.ctx ).val( id );
				$( 'img', this.ctx ).attr( 'src', url );
			},


			/**
			 * Прячем или показываем кнопку удаления из мета поля медиа файла.
			 *
			 * @param String action - действие которое совершается.
			 *
			 * @return {void}
			 */
			btn( action ) {
				const btn = $( 'button', this.ctx );

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
				$( 'button', this.ctx ).on( 'click', () => {
					this.setAtts();
					this.btn();
				} );
			},


			/**
			 * Инициализация основных методов.
			 *
			 * @return {void}
			 */
			init() {
				this.add();
				this.del();
			}
		};

		media.init();

	} );

} )( jQuery );
