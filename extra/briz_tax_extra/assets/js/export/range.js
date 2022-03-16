/**
 * Отображение текущего значения мета поля 'range'.
 *
 * @property String ctx - селектор( CSS class ) родительского элемента мета поля.
 * 	@default: '.briz-meta-range-wrap'.
 *
 * @since 0.0.1
 * @author Ravil
 */
export default {
	ctx: '.briz-meta-range-wrap',


	/**
	 * Отображение текущего значения мета поля 'range'.
	 *
	 * @return {void}
	 */
	numShow() {
		document.querySelectorAll( this.ctx ).forEach( el => {
			const input = el.querySelector( 'input' ),
						em    = el.querySelector( '.briz-meta-range-current-value' );

			const brizMetaRangeHandler = evt => {
				em.textContent = evt.target.value;
			};

			input.addEventListener( 'input', brizMetaRangeHandler, false );
		} );
	},


	/**
	 * Изменение CSS селектора шаблона.
	 *
	 * @param {String} ctx - селектор( CSS class ) родительского элемента мета поля.
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
	 * @param {String} ctx - селектор( CSS class ) родительского элемента мета поля.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx ) {
		this.setSelector( ctx );
		this.numShow();
	}
};
