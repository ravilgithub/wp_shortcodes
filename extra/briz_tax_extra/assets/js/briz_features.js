/**
* Функционал обеспечивающий работу шаблона "Features".
*
* @property {String} ctx - селектор корневого элемента шаблона "Features".
* 	Default: '.briz-features-tmpl'.
*
* @since 0.0.1
* @autor Ravil
*/
const features = {
	ctx: '.briz-features-tmpl',
	selectors: {
		tab: 'tab-item',
		anchor: 'tab-anchor',
		content: '.tabs-content'
	},


	/**
	 * Стартовый метод.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	firstAction() {
		this.getInstance().forEach( i => {
			const content = this.getActiveContent( i );
			if ( content )
				this.setContentHeight( content );

			this.setEvent( i );
		} );
	},


	/**
	 * Получаем коллекцию корневых элементов шаблона "Features".
	 *
	 * @return {Array} - коллекция корневых элементов шаблона.
	 * @since 0.0.1
	 */
	getInstance() {
		return document.querySelectorAll( this.ctx );
	},


	/**
	 * Делегирование корневому элементу шаблона, события клик на элементе табуляции.
	 *
	 * @param {DOM Object} inst - корневой элемент шаблона "Features".
	 * @return {void}
	 * @since 0.0.1
	 */
	setEvent( inst ) {
		inst.addEventListener( 'click', this.tabs.bind( this ), false );
	},


	/**
	 * Выбор активного элемента контента.
	 *
	 * @param {DOM Object} evt - объект события.
	 * @return {void|false}
	 * @since 0.0.1
	 */
	tabs( evt ) {
		let trgt = evt.target;
		const inst = evt.currentTarget;

		let contentId = '';
		if ( trgt.classList.contains( this.selectors.anchor ) ) {
			evt.preventDefault();
			contentId = trgt.getAttribute( 'href' );
			trgt = trgt.parentNode;
		} else if ( trgt.classList.contains( this.selectors.tab ) ) {
			contentId = trgt.querySelector( 'a' ).getAttribute( 'href' );
		} else {
			return false;
		}

		const content = inst.querySelector( contentId );
		if ( ! content )
			return false;

		this.toggleClass( trgt );
		this.toggleClass( content );
		this.setContentHeight( content );
	},


	/**
	 * Присваивание/Удаление классов.
	 *
	 * @param {DOM Object} el - активный элемент.
	 * @return {void}
	 * @since 0.0.1
	 */
	toggleClass( el ) {
		el.classList.add( 'active' );

		this.getSiblings( el ).forEach( sibling => {
			sibling.classList.remove( 'active' );
		} );
	},


	/**
	 * Нахождение сестренских элементов.
	 *
	 * @param {DOM Object} el - активный элемент.
	 * @return {void}
	 * @since 0.0.1
	 */
	getSiblings( el ) {
		return Array.prototype.filter.call( el.parentNode.children, child => child != el );
	},


	/**
	 * Получаем видимый элемент контента.
	 *
	 * @param {DOM Object} inst - корневой элемент шаблона "Features".
	 * @return {DOM Object} - видимый элемент контента.
	 * @since 0.0.1
	 */
	getActiveContent( inst ) {
		const contentParent = inst.querySelector( this.selectors.content );
		if ( ! contentParent )
			return false;

		const content = contentParent.children;
		if ( ! content.length )
			return false;

		return Array.prototype.filter.call( content, i => i.classList.contains( 'active' ) )[ 0 ];
	},


	/**
	 * Определяем высоту контента.
	 *
	 * @param {DOM Object} content - активный элемент контента.
	 * @return {void}
	 * @since 0.0.1
	 */
	setContentHeight( content ) {
		imagesLoaded( content, () => {
			content.parentNode.style.height = content.clientHeight + 'px';
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
		window.addEventListener( 'resize', evt => {
			this.getInstance().forEach( i => {
				const content = this.getActiveContent( i );
				if ( content )
					this.setContentHeight( content );
			} );
		}, false );
	},


	/**
	 * Изменение CSS селектора корневого элемента шаблона.
	 *
	 * @param {String} ctx - селектор корневого элемента шаблона.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	setCtx( ctx ) {
		if ( ! ctx ) return;
		this.ctx = ctx;
	},


	/**
	 * Let's go.
	 *
	 * @param {String} ctx - селектор корневого элемента шаблона.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx ) {
		this.setCtx( ctx );
		this.firstAction();
		this.resizeHandler();
	}
}.init();
