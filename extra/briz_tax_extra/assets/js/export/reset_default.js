/**
 * Функционал кнопки возврата значени мета полей
 * записи или термина к значениям по умолчанию.
 *
 * Reset button
 * Post edit
 * Term add/edit
 *
 * @property {Object} ctx - объект содержащий CSS селекторы:
 * 	@property {String} field - CSS класс мета поля.
 * 		Default: '.briz-meta-field'.
 * 	@property {String} resetAllBtn - CSS класс кнопки возврата значений всех мета
 * 	полей мета бокса( для записей ) или термина к значениям по умолчанию.
 * 		Default: '.briz-meta-reset-all'.
 *
 * @property {Object} items - DOM коллекция мета полей и кнопок
 * возврата значений всех мета полей к значению по умолчанию.
 *
 * @property {String} resetBtnClass - CSS класс индивидуальной кнопки
 * возврата значения по умолчанию мета поля.
 *
 * @property {String} highLightClass - CSS класс элемента для подсветки
 * мета поля, значение которого возвращено к значению по умолчанию.
 *
 * @property {String} hideClass - CSS класс показывающий/скрывающий элемент для подсветки
 * мета поля, значение которого возвращено к значению по умолчанию.
 *
 * @since 0.0.1
 * @author Ravil
 */
export default {
	ctx: { field: '.briz-meta-field', resetAllBtn: '.briz-meta-reset-all' },
	items: {},
	resetBtnClass: 'briz-reset-default',
	highLightClass: '.briz-unsaved',
	hideClass: 'briz-hidden',


	/**
	 * Показываем или скрывам элемент для подсветки
	 * мета поля, значение которого возвращено к значению по умолчанию.
	 *
	 * @param {DOM Object} field           - мета поле.
	 * @param {String/Number/Object} field - значени по умолчанию.
	 * @param {String/Number/Object} curr  - текущее значение.
	 * @param {Boolean} empty              - может ли значение мета поля быть пустым.
	 * @param {String} type                - тип мета поля.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	highLight( field, def, curr, empty, type ) {
		let showStar = false;

		if ( def.length ) {
			if ( 'object' == typeof def ) {
				if ( def.length != curr.length ) {
					showStar = true;
				} else {
					const arr = def.filter( v => ! curr.includes( v ) );
					if ( arr.length ) {
						showStar = true;
					}
				}
			} else {
				if ( 'number' == type ) {
					def = parseFloat( def );
					curr = parseFloat( curr );
				}

				if ( def != curr ) {
					showStar = true;
				}
			}
		} else if ( ! empty ) {
			showStar = true;
		}

		// console.log( !! def );
		// console.log( empty );

		if ( showStar ) {
			// показываем
			field.querySelector( this.highLightClass ).classList.remove( this.hideClass );
		}	else {
			// прячем
			field.querySelector( this.highLightClass ).classList.add( this.hideClass );
		}
	},


	/**
	 * Возврат значения по умолчанию мета поля типа "Radio".
	 *
	 * @param {DOM Object} field    - мета поле.
	 * @param {String/Number} field - значени по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	radio( field, def ) {
		field.querySelectorAll( 'input' ).forEach( input => {
			input.checked = ( input.value == def ) ? true : false;
		} );
	},


	/**
	 * Возврат значения по умолчанию мета поля типа "Checkbox".
	 *
	 * @param {DOM Object} field           - мета поле.
	 * @param {String/Number/Object} field - значени по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	checkbox( field, def ) {
		field.querySelectorAll( 'input' ).forEach( input => {
			input.checked = ( def.includes( input.value ) ) ? true : false;
		} );
	},


	/**
	 * Возврат значения по умолчанию мета поля типа "Select".
	 *
	 * @param {DOM Object} field    - мета поле.
	 * @param {String/Number} field - значени по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	select( field, def ) {
		field.querySelectorAll( 'option' ).forEach( input => {
			input.selected = ( input.value == def ) ? true : false;
		} );
	},


	/**
	 * Возврат значения по умолчанию мета поля типа "Textarea, WP Editor".
	 *
	 * @param {DOM Object} field    - мета поле.
	 * @param {String/Number} field - значени по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	textarea( field, def ) {
		field.querySelector( 'textarea' ).value = def;
	},


	/**
	 * Возврат значения по умолчанию мета поля типа "Range".
	 *
	 * @param {DOM Object} field    - мета поле.
	 * @param {String/Number} field - значени по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	range( field, def ) {
		const input = field.querySelector( 'input' );
		input.value = def;
		input.dispatchEvent( new Event( 'input' ) );
	},


	/**
	 * Возврат значения по умолчанию мета поля типов: "Text, Number, Color, Url".
	 *
	 * @param {DOM Object} field    - мета поле.
	 * @param {String/Number} field - значени по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	other( field, def ) {
		field.querySelector( 'input' ).value = def;
	},


	/**
	 * Обработчик нажатия на кнопки возврата значения по умолчанию мета поля.
	 *
	 * @param {DOM Object} field - мета поле.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	clickHandler( field ) {
		const type = field.dataset.brizMetaFieldType;

		if ( ! type )
			return;

		let def = field.dataset.brizMetaFieldDefault,
		    curr = field.dataset.brizMetaFieldCurrent;

		switch ( type ) {
			case 'textarea':
			case 'wp_editor': this.textarea( field, def ); break;
			case 'select': this.select( field, def ); break;
			case 'radio': this.radio( field, def ); break;
			case 'range': this.range( field, def ); break;
			case 'checkbox':
				def = JSON.parse( def );
				curr = JSON.parse( curr );
				this.checkbox( field, def );
				break;
			default: this.other( field, def );
		}

		const empty = field.dataset.brizMetaFieldEmpty;
		this.highLight( field, def, curr, empty, type );
	},


	/**
	 * Добавление обработчика нажатия на индивидуальную кнопку
	 * возврата значения по умолчанию мета поля.
	 *
	 * @param {DOM Object} field - мета поле.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	resetItem() {
		this.items.fields.forEach( field => {  // общее 2
			field.onclick = evt => {
				if ( evt.target.classList.contains( this.resetBtnClass ) )
					this.clickHandler( field );
			};
		} );
	},


	/**
	 * Добавление обработчика нажатия на кнопку возврата значений всех мета
	 * полей мета бокса( для записей ) или термина к значениям по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	resetAll() {
		this.items.resetBtns.forEach( btn => {
			btn.onclick = evt => {
				const id = btn.dataset.metaBoxId;
				let fields = this.items.fields;

				if ( id ) {
					const metaBox = document.querySelector( '#' + id );
					if ( metaBox )
						fields = metaBox.querySelectorAll( this.ctx.field ); // общее 1
				}

				fields.forEach( field => {  // общее 2
					this.clickHandler( field );
				} );
			};
		} );
	},


	/**
	 * Создание DOM коллекции мета полей и кнопок возврата
	 * значений всех мета полей к значению по умолчанию.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	async getItems() {
		this.items[ 'fields' ] = document.querySelectorAll( this.ctx.field ); // общее 1
		this.items[ 'resetBtns' ] = document.querySelectorAll( this.ctx.resetAllBtn );
	},


	/**
	 * Изменение CSS селекторов мета полей и кнопок возврата значений всех мета
	 * полей мета бокса( для записей ) или термина к значениям по умолчанию.
	 *
	 * @param {Object} ctx - объект содержащий CSS селекторы:
	 * 	@property {String} field - CSS класс мета поля.
	 * 		Default: '.briz-meta-field'.
	 * 	@property {String} resetAllBtn - CSS класс кнопки возврата значений всех мета
	 * 	полей мета бокса( для записей ) или термина к значениям по умолчанию.
	 * 		Default: '.briz-meta-reset-all'.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	setSelectors( ctx ) {
		if ( ! ctx )
			return;

		for( const i in this.ctx) {
			if ( i in ctx && ctx[ i ] ) {
				this.ctx[ i ] = ctx[ i ];
			}
		}
	},


	/**
	 * Let's go.
	 *
	 * @param {Object} ctx - объект содержащий CSS селекторы:
	 * 	@property {String} field - CSS класс мета поля.
	 * 		Default: '.briz-meta-field'.
	 * 	@property {String} resetAllBtn - CSS класс кнопки возврата значений всех мета
	 * 	полей мета бокса( для записей ) или термина к значениям по умолчанию.
	 * 		Default: '.briz-meta-reset-all'.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx ) {
		this.setSelectors( ctx );

		this.getItems()
			.then()
			.then( () => {
				this.resetItem();
				this.resetAll();
			}	);
	}
};
