;( $ => {
	'use strict';

	$( document ).ready( () => {

		/**
		 * Portfolio Actions.
		 *
		 * @property String ctx   - селектор каждого шаблона "portfolio".
		 * @property {Object} iso - объект создающийся для каждого шаблона "portfolio".
		 *
		 * @since 0.0.1
		 * @author Ravil.
		 */
		const $setPortfolioActions = {
			ctx: '.briz-portfolio-tmpl',


			/**
			 * Объект создающийся для каждого шаблона "portfolio".
			 *
			 * @property {Object} dom - jQuery объекты элементов шаблона "portfolio"
			 * @property {String} filter - фильтр по умолчанию.
			 *                             Default: * - отображать все записи.
			 * @property {Null/Object} iso - Объект Isotope JS.
			 *
			 * @since 0.0.1
			 */
			iso: {
				dom: {},
				filter: '*',

				/**
				 * Получаем количество отображенных записей
				 * если активный фильтер не "*",
				 * иначе количество всех записей.
				 *
				 * @return {Integer} cnt - количество записей.
				 *
				 * @since 0.0.1
				 */
				getActivePosts() {
					const selector = ( '*' === this.filter ) ? '.isotope-item' : '.' + this.filter;
					return this.dom.grid.find( selector ).length;
				},


				/**
				 * Получаем количество записей
				 * активного термина в базе данных если
				 * фильтр не "*", иначе количество всех
				 * записей всех терминов.
				 *
				 * @return {Integer} cnt - количество записей.
				 *
				 * @since 0.0.1
				 */
				getMaxPosts() {
					let cnt = 0;

					if ( '*' == this.filter ) {
						cnt = this.dom.more.data( 'all-posts-count' );
					} else {
						cnt = this.dom.filter
						       .find( 'a[href="#' + this.filter + '"]' )
						       .parent()
						       .data( 'term-posts-count' );
					}

					cnt = parseInt( cnt, 10 );
					return ( ! Number.isNaN( cnt ) ) ? cnt : 0;
				},


				/**
				 * Скрываем или показываем кнопку "show more"
				 * в зависимости от того остались ли не выведенные
				 * записи текущей категории или записи какой либо
				 * категории если активный фильтр "*" в базе данных.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				moreTrigger() {
					const maxPosts    = this.getMaxPosts(),
					      activePosts = this.getActivePosts();

					if ( activePosts < maxPosts ) {
						this.dom.more.parent().show();
					} else {
						this.dom.more.parent().hide();
					}
				},


				/**
				 * Показываем записи которые соответствуют фильтру.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				filterIsotopeItems() {
					const self = this,
					      ids = [];

					this.dom.grid.isotope( {
						filter() {
							if ( '*' == self.filter ) {
								const postId = $( this ).data( 'post-id' );

								if ( -1 === ids.indexOf( postId ) ) {
									ids.push( postId );
									return true;
								}
							} else if ( $( this ).hasClass( self.filter ) ) {
									return true;
							}
						}
					} );
				},


				/**
				 * Добавляем новые записи полученные методом Ajax.
				 *
				 * @see "getMorePosts".
				 *
				 * @param Array items - HTML .isotope-item element,
				 * @see briz_shortcodes_extends/extra/briz_tax_extra/tax_tmpl/portfolio.php
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				addIsotopeItems( items ) {
					if ( ! items || ! items.length ) {
						return;
					}

					$( items ).css( {
						visibility: 'hidden',
					} );

					this.dom.grid
						.append( items )
						.imagesLoaded()
							.done( instance => {
								this.dom.grid
									.isotope( 'appended', items ) // trigger filter
									.isotope( 'layout' );

								$( items ).css( {
									visibility: 'visible',
								} );

								this.hoverHandler();
								this.setMagnificPopup();
								this.moreTrigger();
							} );
				},


				/**
				 * Обработчик события:
				 * "Выбор активного термина записи
				 * которого нужно отобразить".
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setIsotopeTabs() {
					$( 'a', this.dom.filter ).on( 'click', evt => {
						evt.preventDefault();
						const $el = $( evt.target );
						let $link = $el.attr( 'href' );

						$link = ( $link[ 0 ] == '#' ) ? $link.substr( 1 ) : $link;
						this.filter = ( $link != '' ) ? $link : '*';

						this.filterIsotopeItems();
						this.setMagnificPopup();
						this.moreTrigger();

						$( 'li', this.dom.filter ).removeClass( 'active' );
						$el.parent().addClass( 'active' );
					} );
				},


				/**
				 * Инициализация основных функций.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setIsotope() {
					this.dom.grid.imagesLoaded()
						.done( () => {
							this.setIsotopeTabs();
							this.filterIsotopeItems();
							this.setMagnificPopup();
							this.hoverHandler();
						} );
				},


				/**
				 * Показ миниатюр ввиде всплывающих окон.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setMagnificPopup() {
					$( '.isotope-item:visible .portfolio-img-zoom', this.dom.tmpl ).magnificPopup( {
						type: 'image',
						preloader: true,
						key: 'my-key',
						gallery: {
							enabled: true
						},

						// Zoom ( CSS - Begin MFP Zoom )
						mainClass: 'mfp-with-zoom',
						zoom: {
							enabled: true,
							duration: 300,
							easing: 'ease-in-out',
							opener: function( $openerElement ) {
								var $parent = $openerElement.parents( '.isotope-item' );
								return $( '.showcase-item-thumbnail', $parent );
							}
						},

						// Fade ( CSS - Begin MFP Fade )
						/*removalDelay: 300,
						mainClass: 'mfp-fade',*/

						callbacks: {
							open: function() {},
							close: function() {},
							elementParse: function( item ) {}
						},
					} );
				},


				/**
				 * Анимация миниатюры при наведении на неё.
				 *
				 * @return {void} 
				 *
				 * @since 0.0.1
				 */
				hoverHandler() {
					$( '.isotope-item', this.dom.grid )
						.off( 'mouseenter mouseleave' )
						.on( 'mouseenter mouseleave', evt => {
							const $img = $( 'img' , $( evt.currentTarget ) );
							if ( evt.type == 'mouseenter' ) {
								setTimeout( () => {
									$img.addClass( 'active' );
								}, 300 ); // !!! Не менять
							} else {
								$img.removeClass( 'active' );
							}
						} );
				},


				/**
				 * Получаем записи из базы данных.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				getMorePosts() {
					this.dom.more.on( 'click', evt => {
						let self = this,
						    activeTermId = $( 'li.active', this.dom.filter ).data( 'term-id' );

						const shortcodeId = this.dom.tmpl.attr( 'id' ),
						      shortcodeTermId = this.dom.tmpl.data( 'shortcode-term-id' );

						if ( 'undefined' == typeof activeTermId ) {
							activeTermId = '';
						}

						$.ajax( {
							type: 'GET',
							url: briz_tax_tmpl_ajax.url,
							dataType: 'json',
							data: {
								action:            'get_more_posts',
								nonce:             briz_tax_tmpl_ajax.nonce,
								shortcode_id:      shortcodeId,
								shortcode_term_id: shortcodeTermId,
								active_term_id:    activeTermId
							},

							beforeSend() {
								// console.log( 'Loading...');
							},

							success( response ) {
								response = $.parseHTML( response.trim() );
								self.addIsotopeItems( response );
							},

							error( error ) {
								// console.log( 'Error:' );
							}
						} );
					} );
				},


				/**
				 * Добавление jQuery объекты элементов
				 * шаблона "portfolio" в свойство "this.dom"
				 * для кратости кода.
				 *
				 * @return {void}
				 *
				 * @since 0.0.1
				 */
				setProps() {
					this.dom[ 'grid' ] = this.dom.tmpl.find( '.isotope' );
					this.dom[ 'more' ] = this.dom.tmpl.find( '.showmore' );
					this.dom[ 'filter' ] = this.dom.tmpl.find( '.isotop-filter' );
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
					this.setIsotope();
					this.getMorePosts();
				}
			},


			/**
			 * Создание независимого объекта "iso"
			 * для каждого шаблона "portfolio".
			 *
			 * @return {void}
			 *
			 * @since 0.0.1
			 */
			init() {
				$( this.ctx ).each( ( idx, el ) => {
					let newIso = { dom: {} };
					newIso.dom[ 'tmpl' ] = $( el );

					$.extend( true, newIso, this.iso );
					newIso.start();
				} );
			},
		};

		$setPortfolioActions.init();

	} );
} )( jQuery );
