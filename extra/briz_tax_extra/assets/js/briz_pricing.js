/**
 * Pricing.
 *
 * @property {String} ctx - селектор каждого шаблона "pricing".
 * @property {String} triggerClass - класс элемента шаблона "pricing", который является переключателем цены.
 * @property {String} periodNameClass - класс элемента шаблона "pricing", который содержит название ценового периода.
 *
 * @since 0.0.1
 * @author Ravil.
 */
const pricing = {
	ctx: '.briz-pricing-tmpl',
	triggerClass: 'price-trigger-tumbler-inner', // без точки
	periodNameClass: '.trigger-period-name',


	/**
	 * Смена CSS классов элементов шаблона.
	 *
	 * @param {DOM Object} tmpl  - объект шаблона.
	 * @param {DOM Object} el    - элемент шаблона у которого сменяется CSS класс.
	 * @param {String} className - CSS класс.
	 *
	 * @return {Void}
	 *
	 * @since 0.0.1
	 */
	classToggler( tmpl, el, className = 'active' ) {
		if ( ! el )
			return;

		if ( 'string' === typeof el ) {
			tmpl.querySelectorAll( el ).forEach( item => {
				item.classList.toggle( className );
			} );
		} else {
			el.classList.toggle( className );
		}
	},


	/**
	 * Смена цены карточки и анимация переключателя цены.
	 *
	 * @return {Void}
	 *
	 * @since 0.0.1
	 */
	changePrice() {
		document.querySelectorAll( this.ctx ).forEach( tmpl => {
			tmpl.onclick = evt => {
				if ( ! evt.target.classList.contains( this.triggerClass ) )
					return;

				this.classToggler( tmpl, evt.target.parentNode );
				this.classToggler( tmpl, evt.target.parentNode.dataset.trigger );
				this.classToggler( tmpl, this.periodNameClass );
			};
		} );
	},


	/**
	 * Let's go.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 */
	init: function() {
		this.changePrice();
	}
};

pricing.init();
