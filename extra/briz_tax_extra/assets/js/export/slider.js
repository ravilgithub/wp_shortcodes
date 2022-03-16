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
		if ( 'type' in defs ) {
			return ( atts ? this.toType( defs.type, atts ) : defs.value );
		} else {
			for ( const i in defs ) {
				result[ i ] = this.prepareAtts( defs[ i ], atts[ i ] );
			}
			return result;
		}
	},


	/**
	 * Получаем параметры слайдера.
	 *
	 * @return {Object} - значения параметров для слайдера.
	 *
	 * @since 0.0.1
	 */
	getAtts() {
		let atts = document.querySelector( `${this.ctx} .swiper-container` ).dataset.sliderCustomAtts;
		atts = ( atts && '[]' !== atts && 'undefined' !== typeof atts ) ? JSON.parse( atts ) : this.tmplSliderAtts;
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
		new Swiper( `${this.ctx} .swiper-container`, Object.assign( {}, this.getAtts() ) );
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
	init( ctx, tmplSliderAtts ) {
		if ( ! ctx || ! tmplSliderAtts )
			return false;
		this.ctx = ctx;
		this.tmplSliderAtts = tmplSliderAtts;
		this.setSlider();
	}
};

export { slider };
