/**
 * Функционал описывающий работу с медиа файлами.
 * Добавление, изменение и удаление медиа файлов в мета полях.
 *
 * @property {String} ctx - селектор( CSS class ) родительского элемента мета поля.
 * 	@default: '.briz-meta-media-wrap'.
 *
 * @property Object selectors - селекторы HTML элементов мета поля.
 *
 * @since 0.0.1
 * @autor Ravil
 */
export default {
	ctx: '.briz-meta-media-wrap',
	selectors: {
		btn: {
			add: 'briz-meta-media-add-btn',
			del: {
				item: 'briz-meta-media-del-item-btn',
				all: 'briz-meta-media-del-all-btn',
			}
		},
		media: {
			place: 'briz-meta-media-place',
			itemWrap: 'briz-meta-media-item-wrap',
			item: 'briz-meta-media-item',
		},
		input: 'briz-meta-media-collection',
		activeClass: 'briz-active',
	},


	/**
	 * Делегирование событий.
	 *
	 * @return {void}
	 */
	setActions() {
		document.querySelectorAll( this.ctx ).forEach( instance => {
			instance.addEventListener( 'click', evt => {
				const target = evt.target,
				      classes = target.classList;

				if ( classes.contains( this.selectors.btn.add ) ) {
					this.add( instance, target );
				} else if ( classes.contains( this.selectors.btn.del.item ) ) {
					this.delItem( instance, target );
				} else if ( classes.contains( this.selectors.btn.del.all ) ) {
					this.delAll( instance, target );
				}
			}, false );
		} );
	},


	/**
	 * Создаём объект wp.media и
	 * передаём ему первоначальные данные.
	 *
	 * @param DOM Object instance - текущий мета блок.
	 * @param DOM Object btn - кнопка которая добавляет медиа файлы.
	 *
	 * @return {void}
	 */
	add( instance, btn ) {
		const args = {
		        title: btn.dataset.title,
		        library: { type: JSON.parse( btn.dataset.libraryType ) },
		        multiple: btn.dataset.multiple,
		        button: { text: btn.dataset.buttonText }
		      },
		      wpm = wp.media( args );

		this.select( wpm, instance, args );
		this.open( wpm, instance );
		wpm.open();
	},


	/**
	 * Формирование HTML выбранных медиа файлов.
	 *
	 * @param Object wpm - WP Media Object.
	 * @param Object atts - свойства выбранного медиа файла.
	 *
	 * @return String html - разметка медиа файлa и подпись к нему если имеется.
	 */
	createEl( wpm, atts ) {
		const tagName = atts.type,
		      itemWrap = document.createElement( 'div' ),
		      figure = document.createElement( 'figure' ),
		      delItemBtn = document.createElement( 'i' );

		delItemBtn.classList.add( this.selectors.btn.del.item );
		delItemBtn.textContent = '×';

		figure.appendChild( delItemBtn );
		figure.classList.add( this.selectors.media.item );

		itemWrap.appendChild( figure );
		itemWrap.classList.add( this.selectors.media.itemWrap, atts.type );
		itemWrap.dataset.mediaId = atts.id;

		let attrs = { src: atts.url }, // для 'audio' и 'video'.
		    html = '',
		    media = '';

		if ( 'image' == tagName ) {
			const img = atts.sizes.thumbnail || atts.sizes.full;
			attrs[ 'src' ] = img.url;
			attrs[ 'alt' ] = atts.alt;
		} else if ( 'audio' == tagName ) {
			attrs[ 'controls' ] = 'controls';
		} else if ( 'video' == tagName ) {
			attrs[ 'controls' ] = 'controls';
		}

		media = document.createElement( tagName );
		for ( let i in attrs ) {
			media.setAttribute( i, attrs[ i ] );
		}

		figure.appendChild( media );

		/*if ( atts.caption ) {
			const figcaption = document.createElement( 'figcaption' );
			figcaption.textContent = atts.caption;
			figure.appendChild( figcaption );
		}*/

		return itemWrap.outerHTML;
	},


	/**
	 * Сортировка медиа файлов.
	 * Сортировка производится по типу файла.
	 * Порядок типов файлов указывается в опциях мета поля в параметре 'type'.
	 *
	 * @param Array sel - массив атрибутов для каждого из выбранного медиа файла.
	 * @param Array args - параметры WP Media.
	 *
	 * @return Array $ordered - отсортированные по типу идентификаторы медиа файлов.
	 */
	sort_attachment_files( sel, args ) {
		if ( ! Array.isArray( args.library.type ) )
			return sel;

		if ( 2 > args.library.type.length || 2 > sel.length )
			return sel;

		let ordered = [];

// ---------------------------------

		// Вариант 1
		/*let stack = {};
		sel.forEach( media => {
			const type = media.attributes.type;

			if ( type in stack )
				stack[ type ].push( media );
			else
				stack[ type ] = [ media ];
		} );

		args.library.type.forEach( type => {
			if ( type in stack )
				ordered = ordered.concat( stack[ type ] );
		} );*/

// ---------------------------------

		// Вариант 2
		args.library.type.forEach( type => {
			sel.forEach( media => {
				if ( media.attributes.type == type ) {
					ordered.push( media );
				}
			} );
		} );

// ---------------------------------

		return ordered;
	},


	/**
	 * Обработчик выбора медиа данных в библиотеке.
	 * Формирование данных о выбранных медиа файлах.
	 *
	 * @param Object wpm - WP Media Object.
	 * @param DOM Object instance - текущий мета блок.
	 * @param Array args - параметры WP Media.
	 *
	 * @return {void}
	 */
	select( wpm, instance, args ) {
		wpm.on( 'select', () => {
			let els = [],
			    ids = [];

			let sel = wpm
			        .state()
			        .get( 'selection' )
			        .toArray();

			sel = this.sort_attachment_files( sel, args );

			for ( const i in sel ) {
				const atts = sel[ i ].attributes;
				ids[ i ] = atts.id;
				els[ i ] = this.createEl( wpm, atts );
			}

			ids = JSON.stringify( ids );
			this.setMedia( instance, 'add', els, ids );
		} );
	},


	/**
	 * Обработчик открытия медиа библиотеки.
	 * Помечаем раннее выбранные медиа файлы если они есть.
	 *
	 * @param Object wpm - WP Media Object.
	 * @param DOM Object instance - текущий мета блок.
	 *
	 * @return {void}
	 */
	open( wpm, instance ) {
		wpm.on( 'open', () => {
			const sel = wpm.state().get( 'selection' ),
			      ids = instance.querySelector( '.' + this.selectors.input ).value;

			if ( ids ) {
				JSON.parse( ids )
					.forEach( id => {
						const attachment = wp.media.attachment( id );
						attachment.fetch();
						sel.add( attachment ? [ attachment ] : [] );
					} );
			}
		} );
	},


	/**
	 * Добавление медиа данных.
	 *
	 * @param DOM Object instance - текущий мета блок.
	 * @param String action  - действие которое нужно выполнить - добавить или удалить медиа файлы.
	 * @param Array els - HTML добавляемых элементов.
	 * @param Array ids - WP идентификаторы добавляемых медиа файлов.
	 *
	 * @return {void}
	 */
	setMedia( instance, action, els = '', ids = '' ) {
		const mediaPlace = instance.querySelector( '.' + this.selectors.media.place );

		mediaPlace.innerHTML = '';

		for ( const i in els ) {
			mediaPlace.insertAdjacentHTML( 'beforeend', els[ i ] );
		}

		instance.querySelector( '.' + this.selectors.input ).setAttribute( 'value', ids );
		this.btnHandler( instance, action );
	},


	/**
	 * Удаление произвольного медиа файла из мета поля.
	 *
	 * @param DOM Object btn - кнопка которая удаляет медиа файл.
	 *
	 * @return {void}
	 */
	delItem( instance, btn ) {
		const itemWrap = btn.closest( '.' + this.selectors.media.itemWrap ),
		      delItemId = itemWrap.dataset.mediaId,
		      input = instance.querySelector( '.' + this.selectors.input ),
		      ids = JSON.parse( input.value ).filter( id => delItemId != id );

		itemWrap.parentNode.removeChild( itemWrap );
		input.setAttribute( 'value', JSON.stringify( ids ) );

		if ( ! ids.length ) {
			this.btnHandler( instance, 'delAll' );
		}
	},


	/**
	 * Удаление всех медиа файлов из мета поля.
	 *
	 * @param DOM Object instance - текущий мета блок.
	 *
	 * @return {void}
	 */
	delAll( instance ) {
		this.setMedia( instance, 'delAll' );
	},


	/**
	 * Изменение текста кнопок при нажатии на них.
	 *
	 * @param DOM Object instance - текущий мета блок.
	 * @param String action  - действие которое нужно выполнить - добавить или удалить медиа файлы.
	 *
	 * @return {void}
	 */
	btnHandler( instance, action ) {
		const addBtn = instance.querySelector( '.' + this.selectors.btn.add ),
		      delBtn = instance.querySelector( '.' + this.selectors.btn.del.all );

		if ( 'add' == action ) {
			const stage = addBtn.dataset.stage;
			if ( 'addidable' == stage ) {
				addBtn.dataset.stage = 'edidable';
				addBtn.textContent = addBtn.dataset.actionText;
				delBtn.classList.add( this.selectors.activeClass );
			}
		} else {
			addBtn.dataset.stage = 'addidable';
			addBtn.textContent = delBtn.dataset.actionText;
			delBtn.classList.remove( this.selectors.activeClass );
		}
	},


	/**
	 * Изменение CSS селектора шаблона.
	 *
	 * @param String ctx - селектор( CSS class ) родительского элемента мета поля.
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
	 * @param String ctx - селектор( CSS class ) родительского элемента мета поля.
	 *
	 * @return {void}
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	init( ctx ) {
		this.setSelector( ctx );
		this.setActions();
	}
};
