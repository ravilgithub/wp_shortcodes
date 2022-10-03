/**
 * Функционал обеспечивающий работу шаблона "Аккордеон".
 *
 * @property {String} ctx - селектор шаблона "Аккордеон".
 * 	Default: '.accordion-container'.
 *
 * @since 0.0.1
 * @autor Ravil
 */
const accordion = {
	ctx: '.accordion-container',


	/**
	 * Выбераем все шаблоны "Аккордеон".
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	selectAccords() {
		document
			.querySelectorAll( this.ctx )
			.forEach( el => {
				this.setHeight( [ el.firstElementChild ] );
				this.addEvent( el );
			} );
	},


	/**
	 * Присваиваем высоту контенту !первого элемента
	 * аккордеона равного высоте его содержимого,
	 * при загрузку страницы.
	 *
	 * Присваиваем высоту контенту !активного элемента
	 * аккордиона равного высоте его содержимого.
	 *
	 * Присваиваем нулевую высоту !не активному элементу аккордиона.
	 *
	 * @param {Object} els            - элементы аккордиона.
	 * @param {String/Integer} height - высота элемента аккордиона.
	 *                                  Default: auto
	 * @return {void}
	 * @since 0.0.1
	 */
	setHeight( els, height = 'auto' ) {
		els.forEach(
			el => el.querySelector( '.accordion-item-content' ).style.height = height
		);
	},


	/**
	 * Прослушиваем событие "click" на внутренних элемента шаблона "Аккордеон".
	 *
	 * @param {Object} el - шаблон "Аккордеон".
	 * @return {void}
	 * @since 0.0.1
	 */
	addEvent( el ) {
		el.addEventListener( 'click', this.clickHandler.bind( this ), false );
	},


	/**
	 * Обработчик события.
	 *
	 * @param {Object} evt - объект события.
	 * @return {void}
	 * @since 0.0.1
	 */
	clickHandler( evt ) {
		if ( ! evt.target.closest( '.accordion-item' ) )
			return;

		const item = evt.target.closest( '.accordion-item' ),
		      siblings = this.getSiblings( item );

		this.addClass( item );
		this.removeClass( siblings );

		this.setHeight( [ item ] );
		this.setHeight( siblings, 0 );
	},


	/**
	 * Получаем сестренские элементы, активного элемента шаблона "Аккордеон".
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
	 * Показываем контент активного элемента аккордиона.
	 *
	 * @param {Object} item - элемент аккордиона.
	 * @return {void}
	 * @since 0.0.1
	 */
	addClass( item ) {
		item.classList.add( 'active' );
	},


	/**
	 * Прячем контент не активного элемента аккордиона.
	 *
	 * @param {Object} siblings - элементы аккордиона.
	 * @return {void}
	 * @since 0.0.1
	 */
	removeClass( siblings ) {
		siblings.forEach(
			sibling => sibling.classList.remove( 'active' )
		);
	},


	/**
	 * Изменение CSS селектора шаблона.
	 *
	 * @param {String} ctx - селектор шаблона "Аккордеон".
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
	 * @param {String} ctx - селектор шаблона "Аккордеон".
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx ) {
		this.setSelector( ctx );
		this.selectAccords();
	},
};

export { accordion };
