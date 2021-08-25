;( $ => {
	'use strict';

	$( document ).ready( () => {

		/**
		 * Features Actions.
		 *
		 * @property {String} ctx - селектор каждого шаблона "features".
		 * @property {Object} tab - объект создающийся для каждого шаблона "features".
		 *
		 * @since 0.0.1
		 * @author Ravil.
		 */
		const $featuresTabsAnimate = {
			ctx: '.briz-features-tmpl',

			/**
			 * Объект создающийся для каждого шаблона "features".
			 *
			 * @property {Object} dom - jQuery объекты элементов шаблона "features".
			 *
			 * @since 0.0.1
			 */
			tab: {
				dom: {},

				/**
				 * Показаваем/Акцентируем внимание на активных элементах и прячем не активные.
				 *
				 * @param {jQuery Object / String} $el       - елемент который надо сделать активным.
				 * @param {jQuery Object / String} $siblings - сестренские елементы которые надо дективировать.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				classToggle( $el, $siblings ) {
					$( $el )
						.addClass( 'active' )
						.siblings( $siblings )
							.removeClass( 'active' );
				},


				/**
				 * Присваиваем высоту активному элементу( контенту ) табуляции,
				 * исходя из высоты его содержимого.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setHeight() {
					$( this.dom.contentInner )
						.filter( '.active' )
							.imagesLoaded()
								.done( instance => {
									const $childHeight = instance.elements[ 0 ].clientHeight;
									$( this.dom.content ).height( $childHeight );
								} );
				},


				/**
				 * Обработчик события "click".
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				clickHandler() {
					$( 'li', this.dom.list ).on( 'click', $event => {
						$event.preventDefault();
						const $el = $event.target,
						      $tabContent = $( 'a', $el ).attr( 'href' );

						this.classToggle( $el, 'li' );
						this.classToggle( $tabContent, this.dom.contentInner );
						this.setHeight();
					} );
				},


				/**
				 * Обработчик события "resize".
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				resizeHandler() {
					$( window ).on( 'resize', () => {
						this.setHeight();
					} );
				},


				/**
				 * Добавление jQuery объекты элементов шаблона "features"
				 * в свойство "this.dom" для краткости кода.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setProps() {
					let $dom = this.dom;
					$dom[ 'list' ] = $dom.tmpl.find( '.tabs-list' );
					$dom[ 'content' ] = $dom.tmpl.find( '.tabs-content' );
					$dom[ 'contentInner' ] = $dom.tmpl.find( '.tab-content-inner' );
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
					this.setHeight();
					this.clickHandler();
					this.resizeHandler();
				}
			},


			/**
			 * Создание независимого объекта "tab"
			 * для каждого шаблона "features".
			 *
			 * @return {void}
			 *
			 * @since 0.0.1
			 */
			init() {
				$( this.ctx ).each( ( $idx, $el ) => {
					let newTab = { dom: {} };
					newTab.dom[ 'tmpl' ] = $( $el );

					$.extend( true, newTab, this.tab );
					newTab.start();
				} );
			},
		};

		$featuresTabsAnimate.init();

	} );

} )( jQuery );
