'use strict';

/**
* Функционал обеспечивающий работу шаблона "Video".
*
* @property {String} ctx - селектор корневого элемента шаблона "Video".
* 	Default: '.briz-video-tmpl'.
*
* @since 0.0.1
* @autor Ravil
*/
const video = {
	ctx: '.briz-video-tmpl',
	selectors: {
		button: 'mfp-iframe',
		iframeContainerClass: 'bri-mfp-video-iframe',
	},


	/**
	 * Получаем коллекцию корневых элементов шаблона "Video".
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
			inst.addEventListener( 'click', this.eventHandler.bind( this ), false );
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
		const trgt = evt.target;

		if ( ! trgt.classList.contains( this.selectors.button ) )
			return false;

		this.setVideoIframe( trgt );
	},


	/**
	 * Показ видео ввиде всплывающего окона.
	 *
	 * @param {DOM Object} btn - элемент на котором произошол клик.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	setVideoIframe( btn ) {
		if ( ! jQuery )
			return false;

		jQuery( btn ).magnificPopup( {
			type: 'iframe',
			mainClass: this.selectors.iframeContainerClass,
			callbacks: {
				open: function() {},
				close: function() {
					//console.log( $.magnificPopup.instance );
				}
			},
		} ).magnificPopup( 'open' );
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
}.init( '.briz-video-tmpl' );
