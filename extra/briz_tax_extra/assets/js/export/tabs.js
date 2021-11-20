/**
 * Функционал обеспечивающий работу шаблона "Tabs".
 *
 * @property {String} ctx - селектор шаблона "Tabs".
 * @since 0.0.1
 * @autor Ravil
 */
const tabs = {
	ctx: '',

	/**
	 * Выбераем все шаблоны "Tabs".
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	getTabs() {
		document
			.querySelectorAll( this.ctx )
			.forEach(
				el => {
					this.setMaxHeight( el );
					this.addEvent( el );
				}
			);
	},

	/**
	 * Что-бы страница не меняла высоту,
	 * вычисляем максимально возможную высоту шаблона "Tabs".
	 *
	 * @param {Object} el - шаблон "Tabs".
	 * @return {void}
	 * @since 0.0.1
	 */
	setMaxHeight( el ) {
		const inners = el.querySelectorAll( '.tab-content-inner' );
		let maxHeight = 0;
		
		inners.forEach( inner => {
			maxHeight = Math.max( inner.offsetHeight, maxHeight );
		} );
		inners[ 0 ].parentNode.style.height = maxHeight + 'px';
	},

	/**
	 * Прослушиваем событие "click" на внутренних элемента шаблона "Tabs".
	 *
	 * @param {Object} el - шаблон "Tabs".
	 * @return {void}
	 * @since 0.0.1
	 */
	addEvent( el ) {
		el.onclick = evt => {
			evt.preventDefault();
			this.clickHandler( evt );
		};
	},

	/**
	 * Обработчик события.
	 *
	 * @param {Object} evt - объект события.
	 * @return {void}
	 * @since 0.0.1
	 */
	clickHandler( evt ) {
		if ( ! evt.target.closest( 'li' ) )
			return;

		const li = evt.target.closest( 'li' ),
		      anchor = evt.target.getAttribute( 'href' ),
		      inner = evt.currentTarget.querySelector( anchor );

		this.showActiveTab( [ li, inner ] );
	},

	/**
	 * Показываем контент активного элемента tab'a и
	 * прячем не активные элементы.
	 *
	 * @param {Array} els - элемент tab'a.
	 * @return {void}
	 * @since 0.0.1
	 */
	showActiveTab( els ) {
		els.forEach( el => {
			el.classList.add( 'active' );
			this.getSiblings( el ).forEach( sibling => {
				sibling.classList.remove( 'active' );
			} );
		} );
	},

	/**
	 * Получаем сестренские элементы, активного элемента шаблона "Tabs".
	 *
	 * @param {Object} el - активный элемент шаблона.
	 * @return {Array}    - сестренские элементы.
	 * @since 0.0.1
	 */
	getSiblings( el ) {
		// Native - latest, Edge13+
		/*return [ ...el.parentNode.children ].filter(
			child => child !== el
		);*/

		// Native (alternative) - latest, Edge13+
		/*return Array.from( el.parentNode.children ).filter(
			child => child !== el
		);*/

		// Native - IE10+
		return Array.prototype.filter.call(
			el.parentNode.children,
			child => child !== el
		);
	},

	/**
	 * Let's go.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init: function( ctx ) {
		if ( ! ctx ) return;
		this.ctx = ctx;
		this.getTabs();
	}
};

export { tabs };
