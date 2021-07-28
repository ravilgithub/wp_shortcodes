/**
 * Функционал описывающий работу с медиа файлами.
 * Добавление, изменение и удаление медиа файлов в мета полях.
 *
 * @since 0.0.1
 * @autor Ravil
 */
export default {
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
			this.dom.a.addEventListener( 'click', evt => {
				evt.preventDefault();

				if ( ! this.wpm ) {
					this.wpm = wp.media( this.wpmArgs );
					this.wpm.on( 'select', this.select.bind( this ) );
					this.wpm.on( 'open', this.open.bind( this ) );
				}
				
				this.wpm.open();
			}, false );
		},


		/**
		 * Обработчик открыия медиа библиотеки.
		 * Помечаем раннее выбранные медиа файлы если они есть.
		 *
		 * @return {void}
		 */
		open() {
			const id  = this.dom.input.value;

			if ( id ) {
				const img = this.wpm.state().get( 'selection' ),
							attach = wp.media.attachment( id );

				attach.fetch();
				img.add( attach ? attach : [] );
			}
			console.log( 'open' );
			console.log( this.dom );
		},


		/**
		 * Обработчик выбора медиа данных в библиотеке.
		 *
		 * @return {void}
		 */
		select() {
			console.log( 'select' );
			console.log( this.dom );
			const img = this.wpm.state().get( 'selection' ).first().toJSON();

			// console.log( 'first', this.wpm.state().get( 'selection' ).first() );
			// console.log( 'img', img );

			if ( img ) {
				const size = img.sizes.thumbnail || img.sizes.full;
				this.setAtts( img.id, size.url );
				this.btn( 'select' );
			}
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
				url = this.dom.img.dataset.default;

			this.dom.input.value = id;
			this.dom.img.setAttribute( 'src', url );
		},


		/**
		 * Прячем или показываем кнопку удаления из мета поля медиа файла.
		 *
		 * @param String action - действие которое совершается.
		 *
		 * @return {void}
		 */
		btn( action ) {
			if ( 'select' == action ) {
				this.dom.button.classList.remove( 'hidden' );
			} else {
				this.dom.button.classList.add( 'hidden' );
			}
		},


		/**
		 * Удаление медиа данных.
		 *
		 * @return {void}
		 */
		del() {
			this.dom.button.addEventListener( 'click', () => {
				this.setAtts();
				this.btn();
			}, false );
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
			this.dom[ 'button' ] = this.dom.tmpl.querySelector( 'button' );
			this.dom[ 'input' ]  = this.dom.tmpl.querySelector( 'input' );
			this.dom[ 'img' ]    = this.dom.tmpl.querySelector( 'img' );
			this.dom[ 'a' ]      = this.dom.tmpl.querySelector( 'a' );
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
	init( selector ) {
		document.querySelectorAll( selector ).forEach( el => {
			// Object.assign( {}, this.image, { dom: { tmpl: el } } ).start();

			jQuery.extend( true, { dom: { tmpl: el } }, this.image ).start();
		} );
	}
};
