;( $ => {
	'use strict';

	$( document ).ready( () => {

		/**
		 * Facts Animate Number Progress.
		 *
		 * @property {String} ctx   - селектор каждого шаблона "facts".
		 * @property {Object} facts - объект создающийся для каждого шаблона "facts".
		 *
		 * @since 0.0.1
		 * @author Ravil.
		 */
		const setFactsAnimation = {
			ctx: '.briz-facts-tmpl',


			/**
			 * Объект создающийся для каждого шаблона "facts".
			 *
			 * @property {Object} dom - jQuery объекты элементов шаблона "facts".
			 *
			 * @since 0.0.1
			 */
			facts: {
				dom: {},


				/**
				 * Анимация цифр.
				 * 
				 * @return {void}
				 * 
				 * @since 0.0.1
				 */
				startProgress() {
					$( this.dom.nums ).each( ( idx, num ) => {
						const number = num.dataset.number,
									symbol = num.dataset.symbol,
									position = num.dataset.symbolPosition;

						$( num ).animateNumber( {
							number: number,
							easing: 'easeInQuad',
							numberStep( now, tween ) {
								now = Math.floor( now );

								if ( 'before' == position ) {
									now = symbol + now;
								} else if ( 'after' == position ) {
									now += symbol;
								}

								$( tween.elem ).text( now );
							}
						}, 2000 );
					});
				},


				/**
				 * Запуск анимации цифр при прокрутке.
				 * 
				 * @return {void}
				 * 
				 * @since 0.0.1
				 */
				createWow() {
					const $self = this,
								wow = new WOW( {
									boxClass: $self.dom.boxClass,
									animateClass: 'animated',
									offset: 200,
									mobile: true,
									live: true,
									scrollContainer: null,
									callback( box ) {
										$self.startProgress();
									}
								} );
					
					wow.init();
				},


				/**
				 * Параллакс эффект фона шаблона "facts"
				 * 
				 * @return {void}
				 * 
				 * @since 0.0.1
				 */
				createParallax() {
					$( '.parallax-window', this.ctx ).parallax( {
						iosFix: true,
						androidFix: true,
						speed: 0.1,
						//naturalWidth: 1920,
						//naturalHeight: 1276,
					} );
				},


				/**
				 * Добавление jQuery объекты элементов шаблона "facts"
				 * в свойство "this.dom" для краткости кода.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setProps() {
					let dom = this.dom;
					dom[ 'nums' ] = dom.tmpl.find( '.progress-num' );
					dom[ 'boxClass' ] = 'facts-items-wrap';
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
					this.createWow();
					this.createParallax();
				}
			},


			/**
			 * Создание независимого объекта "facts"
			 * для каждого шаблона "facts".
			 *
			 * @return {void}
			 *
			 * @since 0.0.1
			 */
			init() {
				$( this.ctx ).each( ( idx, el ) => {
					let newFacts = { dom: {} };
					newFacts.dom[ 'tmpl' ] = $( el );

					$.extend( true, newFacts, this.facts );
					newFacts.start();
				} );
			}
		};

		setFactsAnimation.init();

	} );
} )( jQuery );
