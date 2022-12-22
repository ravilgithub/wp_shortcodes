'use strict';

/**
* Функционал обеспечивающий работу шаблона "Subscribe".
*
* @property {String} ctx - селектор корневого элемента шаблона "Subscribe".
* 	Default: '.briz-subscribe-tmpl'.
*
* @since 0.0.1
* @autor Ravil
*/
const subscribe = {
	ctx: '.briz-subscribe-tmpl',

	selectors: {
		/*// CUSTOM FORM
		inputParent: '.form-group',
		input: '.newsletter-email' */
		
		// NEWSLETTER PLUGIN DEFAULT FORM
		inputParent: '.tnp-field',
		input: '.tnp-email'
	},


	/**
	 * Получаем коллекцию корневых элементов шаблона "Subscribe".
	 *
	 * @return {Array} - коллекция корневых элементов шаблона.
	 * @since 0.0.1
	 */
	getInstance() {
		return document.querySelectorAll( this.ctx );
	},


	/**
	 * Делегирование корневому элементу шаблона, события клик на элементе табуляции.
	 *
	 * @return {false|void}
	 * @since 0.0.1
	 */
	setEvent() {
		const instances = this.getInstance();

		if ( ! instances.length )
			return false;

		instances.forEach( inst => {
			const input = inst.querySelector( this.selectors.input );

			if ( input ) {
				input.value = '';

				[ 'focus', 'blur' ].forEach( evtType => {
					input.addEventListener( evtType, this.eventHandler.bind( this ), false );
				} );
			}
		} );
	},


	/**
	 * Обработчик события.
	 *
	 * @param {Event Object} evt - объект события.
	 *
	 * @return {false|void}
	 * @since 0.0.1
	 */
	eventHandler( evt ) {
		evt.preventDefault();
		const inputParent = evt.target.closest( this.selectors.inputParent );

		if ( ! inputParent )
			return false;

		if ( evt.type === 'focus' )
			inputParent.classList.add( 'on-focus' );
		else if ( evt.target.value === '' )
			inputParent.classList.remove( 'on-focus' );
	},


	/**
	 * Изменение CSS селектора корневого элемента шаблона.
	 *
	 * @param {String} ctx - селектор корневого элемента шаблона.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	setCtx( ctx ) {
		if ( ! ctx ) return;
		this.ctx = ctx;
	},


	/**
	 * Let's go.
	 *
	 * @param {String} ctx - селектор корневого элемента шаблона.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx ) {
		this.setCtx( ctx );
		this.setEvent();
	}
}.init( '.briz-subscribe-tmpl' );
