/**
 * Отображение текущего значения мета поля 'range'.
 *
 * @property String selector - селектор родительского элемента мета поля "range".
 *
 * @since 0.0.1
 * @author Ravil
 */
export default {
	selector: '',

	/**
	 * Отображение текущего значения мета поля 'range'.
	 *
	 * @return {void}
	 */
	numShow() {
		document.querySelectorAll( this.selector ).forEach( el => {
			const input = el.querySelector( 'input' ),
						em    = el.querySelector( '.briz-meta-range-current-value' );

			const brizMetaRangeHandler = evt => {
				em.textContent = evt.target.value;
			};

			input.addEventListener( 'input', brizMetaRangeHandler, false );
		} );
	},


	/**
	 * Инициализация основных методов.
	 *
	 * @param String selector - селектор родительского элемента мета поля "range".
	 *
	 * @return {void}
	 */
	init( selector ) {
		if ( ! selector )
			return;

		this.selector = selector;
		this.numShow();
	}
};
