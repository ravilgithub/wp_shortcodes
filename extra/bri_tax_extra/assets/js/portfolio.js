'use strict';

/**
 * Portfolio Actions.
 */
;( function( $ ) {
	$( document ).ready( function() {
		
		/**
		 * Главный объект.
		 * 
		 * @param {Object} iso - объект создающийся для каждого шаблона "portfolio".
		 * 
		 * @return {void}
		 * 
		 * @since 0.0.1
		 * @author Ravil.
		 */
		const $setPortfolioActions = {

			/**
			 * Объект создающийся для каждого шаблона "portfolio".
			 * 
			 * @property {Object} dom - jQuery объекты элементов шаблона "portfolio"
			 * @property {String} filter - фильтер по умолчанию.
			 *                             Default: * - отображать все записи.
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
					let cnt = 0,
							selector = '.isotope-item';

					if ( '*' != this.filter ) {
						selector += ':visible';
					}

					cnt = this.dom.grid.find( selector ).length;
					
					console.log( 'visible items', cnt );
					
					return cnt;
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
					cnt = ! Number.isNaN( cnt ) ? cnt : 0;

					console.log( 'max posts', cnt );

					return cnt;
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
						this.dom.more.show( 100 );
					} else {
						this.dom.more.hide( 100 );
					}
				},

				/**
				 * Показываем записи которые соответствуют фильтру.
				 * 
				 * @return {void}
				 * 
				 * @since 0.0.1
				 */
				async filterIsotopeItems() {
					await new Promise( ( resolve, reject ) => {
						const self = this;
						let ids = [];
						
						console.log( 2 ); // log

						const iso = this.dom.grid.isotope( {
							filter() {
								if ( '*' == self.filter ) {
									const postId = $( this ).data( 'post-id' );

									if ( -1 === ids.indexOf( postId ) ) {
										ids.push( postId );
										console.log( ids );
										return true;
									}
								} else if ( $( this ).hasClass( self.filter ) ) {
										return true;
								}
							}
						} );

						iso.on( 'arrangeComplete', resolve );
					} );				
				},

				/**
				 * Добавляем новые записи полученные методом Ajax.
				 * 
				 * @see "getMorePosts".
				 * 
				 * @return {void}
				 * 
				 * @since 0.0.1
				 */
				async addIsotopeItems( items ) {
					if ( ! items || ! items.length ) {
						return;
					}

					await new Promise( ( resolve, reject ) => {
						$( items ).css( {
							opacity: 0,
						} );

						this.dom.grid
							.append( items )
							.imagesLoaded()
								.done( instance => {
									console.log( 1 ); // log
									
									// После события "appended" вызывается "filter" подписанный в методе "filterIsotopeItems"
									this.dom.grid.isotope( 'appended', items );

									$( items ).css( {
										opacity: 1,
									} );

									// this.filterIsotopeItems()
									// 	.then( resolve );
									resolve();
								} );
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
						console.log( 'filter', this.filter ); // log

						this.filterIsotopeItems()
							.then( () => {
								console.log( 10 ); // log
								this.setMagnificPopup();
								
								this.moreTrigger();
							} );

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
				async setIsotope() {
					await new Promise( ( resolve, reject ) => {
						this.dom.grid.imagesLoaded()
							.done( () => {
								console.log( 10 ); // log
								this.filterIsotopeItems();
								this.setIsotopeTabs();
								resolve();
							} );
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
					console.log( 11 ); // log
					
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
							console.log( 'activeTermId:', 'undefined' ); // log
							activeTermId = '';
						}

						$.ajax( {
							type: 'GET',
							url: bri_tax_tmpl_ajax.url,
							dataType: 'json',
							data: {
								action:            'get_more_posts',
								nonce:             bri_tax_tmpl_ajax.nonce,
								shortcode_id:      shortcodeId,
								shortcode_term_id: shortcodeTermId,
								active_term_id:    activeTermId
							},

							beforeSend() {
								console.log( 'Loading...');
							},

							success( response ) {
								console.log( 'Success:' ); // log
								response = $.parseHTML( response.trim() );

								self.addIsotopeItems( response )
									.then( () => {
										console.log( 'filter', self.filter ); // log
										self.hoverHandler();
										self.setMagnificPopup();

										self.moreTrigger();
									} );
							},

							error( error ) {
								console.log( 'Error:' );
								console.log( error );
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
					this.dom[ 'more' ] = this.dom.tmpl.find( '.show-more' );
					this.dom[ 'filter' ] = this.dom.tmpl.find( '.filter' );
					console.log( 'dom', this.dom );
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
					this.setIsotope()
						.then( () => {
							this.setMagnificPopup();
							this.hoverHandler();
						} );

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
				$( '.bri-portfolio-tmpl' ).each( ( idx, el ) => {
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
