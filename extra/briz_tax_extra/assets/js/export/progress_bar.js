/**
 * Функционал обеспечивающий работу шаблона "Progress bar".
 *
 * @property {String} ctx - селектор шаблона "Progress bar".
 * 	@default: 'wow'.
 *
 * @since 0.0.1
 * @autor Ravil
 */
const progressBar = {
	ctx: 'wow',
	duration: 1500,
	easingName: 'easeOutQuad',


	/**
	 * Функция плавности по умолчанию.
	 * jQuery Easing "easeOutQuad".
	 *
	 * @param {Float} x - число 0..1
	 * @return {Float}
	 */
	stdEasing( x ) {
		return 1 - ( 1 - x ) * ( 1 - x );
	},


	/**
	 * Возвращаем функцию плавности.
	 * Объект с функциями плавности находится тут:
	 * ~/briz_shortcodes_extends/assets/vendors/briz-easing/briz.easing.js
	 *
	 * @return {Function} - функция плавности.
	 * @since 0.0.1
	 */
	getEasing() {
		const w = window,
		      name = this.easingName;

		if ( w.brizEasing && w.brizEasing[ name ] )
			return w.brizEasing[ name ];
		return this.stdEasing;
	},


	/**
	 * Анимация элеметов Progress bar'a.
	 *
	 * @param {Object} selector - DOM шаблона "Progress bar".
	 * @return {void}
	 * @since 0.0.1
	 */
	progress( selector ) {
		const easing = this.getEasing();

		selector
			.querySelectorAll( '.progress-bar-item' )
			.forEach( el => {
				let starttime = null;
				const ruler = el.querySelector( '.ruler' ),
				      num = Math.abs( parseInt( el.dataset.progressTarget, 10 ) );

				if ( isNaN( num ) )
					return;

				// https://medium.com/burst/understanding-animation-with-duration-and-easing-using-requestanimationframe-7e3fd1688d6c
				const animate = timestamp => {
					if ( ! starttime ) {
						starttime = timestamp;
					}

					const runtime = timestamp - starttime,
					      progress = runtime / this.duration,
					      width = Math.ceil( num * Math.min( easing( progress ), 1 ), 10 );

					ruler.style.width = width + '%';
					ruler.dataset.ruler = this.setSymbolPosition( ruler, width );

					if ( runtime < this.duration && width < num ) {
						window.requestAnimationFrame( animate );
					}
				}

				window.requestAnimationFrame( animate );
			} );
	},


	/**
	 * Устанавливаем символ до или после ширины элемента "ruler".
	 *
	 * @param {Object} ruler - DOM елемент шаблона "Progress bar".
	 * @param {Integer} width - ширина элемента "ruler".
	 * @return {String} dataParam - число с символом.
	 * @since 0.0.1
	 */
	setSymbolPosition( ruler, width ) {
		const symbol = ruler.dataset.symbol,
		      symbolPosition = ruler.dataset.symbolPosition;

		let dataParam = width,
		    resultSymbol = '%';

		if ( symbol ) {
			resultSymbol = symbol;
		}

		if ( 'before' == symbolPosition ) {
			dataParam = resultSymbol + width;
		} else if ( 'after' == symbolPosition ) {
			dataParam = width + resultSymbol;
		}

		return dataParam;
	},


	/**
	 * Запуск анимации элементов шаблона "Progress bar"
	 * только в том случае если шаблон виден на экране.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	setWOW() {
		let self = this;
		var $wow = new WOW( {
			boxClass: this.ctx,
			animateClass: 'animated',
			offset: 200,
			mobile: true,
			live: true,
			scrollContainer: null,
			callback( box ) {
				self.progress( box );
			},
		});

		$wow.init();
	},


	/**
	 * Изменение CSS селектора шаблона.
	 *
	 * @param {String} ctx - селектор шаблона "Progress bar".
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	setSelector( ctx ) {
		if ( ! ctx ) return;
		this.ctx = ctx;
	},


	/**
	 * Let's go.
	 *
	 * @param {String} ctx - селектор шаблона "Progress bar".
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx ) {
		this.setSelector( ctx );
		this.setWOW();
	}
};

export { progressBar };
