/**
 * Отображение текущего значения мета поля 'range'
 *
 * @property String ctx - селектор обёртки мета поля.
 *
 * @since 0.0.1
 * @author Ravil
 */
export default {
	ctx: '',

	numShow() {
		document.querySelectorAll( this.ctx ).forEach( el => {
			const input = el.querySelector( 'input' ),
			      em    = el.querySelector( '.briz-range-current-value' );

			input.addEventListener( 'input', evt => {
				em.textContent = evt.target.value;
			}, false );
		} );
	},


	init( ctx ) {
		if ( ! ctx )
			return;

		this.ctx = ctx;
		this.numShow();
	}
};
