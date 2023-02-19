import { slider_defaults } from './slider_defaults.js';

/**
 * Функционал обеспечивающий работу слайдера в шаблонах.
 *
 * @property {String} ctx - селектор шаблона в котором находится слайдер.
 * @property {Object} tmplSliderAtts - пользовательские параметры слайдера.
 *
 * @since 0.0.1
 * @autor Ravil
 */
const slider = {
	ctx: '',
	tmplSliderAtts: {},


	/**
	 * Приведение значения свойства к типу данных, указанному в файле значений по умолчанию.
	 *  @see ./slider_default.js
	 *   {String} @type - тип данных
	 *
	 * @param {String} type - тип данных к которому нужно привести значение свойства.
	 * @param {Mixed} val   - значение свойства.
	 *
	 * @return {Mixed}      - приведённое к соответствующиму типу значение свойства.
	 *
	 * @since 0.0.1
	 */
	toType( type, val ) {
		switch ( type ) {
			case 'number': return Math.abs( parseInt( val ) );
			case 'boolean': return !! val;
			default: return val;
		}
	},


	/**
	 * Рекурсивный обход по свойствам указанным в файле значений по умолчанию
	 * и замена значений пользовательскими.
	 *
	 * @param {Object} defs - значения свойств по умолчанию.
	 *  @see ./slider_default.js
	 *
	 * @param {Object} atts - пользовательские значения свойств.
	 *
	 * @return {Object} result - значения параметров для слайдера.
	 *
	 * @since 0.0.1
	 */
	prepareAtts( defs, atts, result = {} ) {
		if ( 'dataType' in defs ) {
			// console.log( atts );
			return atts ? this.toType( defs.dataType, atts ) : defs.value;
		} else {
			for ( const i in defs ) {
				// console.log( i );
				// console.log( i, atts[ i ] );
				result[ i ] = this.prepareAtts( defs[ i ], atts[ i ] );
			}
			return result;
		}
	},


	/**
	 * Получаем параметры слайдера.
	 *
	 * @param {DOM Object} ctx - текущий шаблон.
	 *
	 * @return {Object} - значения параметров для слайдера.
	 *
	 * @since 0.0.1
	 */
	getAtts( ctx ) {
		let atts = ctx.querySelector( '.swiper' ).dataset.sliderCustomAtts;
		// atts = ( atts && '[]' !== atts && 'undefined' !== typeof atts ) ? JSON.parse( atts ) : this.tmplSliderAtts;

		try {
			atts = JSON.parse( atts );
			jQuery.extend( true, atts, this.tmplSliderAtts );
		} catch ( e ) {
			// Если не параметров для слайдера из админки, берём параметры из JS файла который вызывает объект slider.
			atts = this.tmplSliderAtts;
		}

		return this.prepareAtts( slider_defaults, atts );
	},


	/**
	 * Создание слайдера.
	 *
	 * @return {Void}
	 *
	 * @since 0.0.1
	 */
	setSlider() {
		const ctxs = ( typeof this.ctx === 'object' && this.ctx !== null ) ? [ this.ctx ] : document.querySelectorAll( this.ctx );

		for ( const ctx of ctxs ) {
			// console.log( ctx );
			const sliderSelector = ( this.scoped ) ? ':scope > .swiper' : '.swiper',
			      container = ctx.querySelector( sliderSelector );

			// let atts = Object.assign( {}, this.getAtts() );
			let atts = this.getAtts( ctx );

			atts.navigation.prevEl = ctx.querySelector( atts.navigation.prevEl );
			atts.navigation.nextEl = ctx.querySelector( atts.navigation.nextEl );
			atts.pagination.el = ctx.querySelector( atts.pagination.el );

			// console.log( this.ctx, atts );

			new Swiper( container, atts );
		}
	},


	/**
	 * Let's go.
	 *
	 * @param {String} ctx - селектор шаблона в котором находится слайдер.
	 * @param {Object} tmplSliderAtts - пользовательские параметры слайдера.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx, tmplSliderAtts, scoped = false ) {
		if ( ! ctx || ! tmplSliderAtts )
			return false;
		this.ctx = ctx;
		this.scoped = scoped;
		this.tmplSliderAtts = tmplSliderAtts;
		this.setSlider();
	}
};

export { slider };
