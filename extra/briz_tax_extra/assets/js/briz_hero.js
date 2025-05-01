'use strict';

/**
 * Главный слайдер.
 *
 * @property {String} ctx       - селектор галереи.
 * @property {Null|Boolean} ctx - вкл/выкл автоматическая прокрутка слайдов.
 * @since 0.0.1
 * @author Ravil
 */
const hero = {
	ctx: [
		'.main-slider-gen-wrap',
		'.promo-slider'
	],

	swiperAutoplayStatus: null,


	/**
	 * Изменение размера текста элементов слайдера при изменении ширины слайдера.
	 *
	 * @param {jQuery Object} swiper - галерея.
	 * @return {void}
	 * @since 0.0.1
	 */
	setSlideTextSize( swiper ) { // Slider
		$( '[class^=container]', swiper.el ).flowtype( {
			minimum: 1,
			maximum: 1200,
			minFont: 1,
			maxFont: 48,
			fontRatio: 65,
		} );
	},


	/**
	 * Показываем анимируемые элементы активного слайда.
	 *
	 * @param {jQuery Object} swiper - галерея.
	 * @return {void|false}
	 * @since 0.0.1
	 */
	setAnim( swiper ) {
		if ( swiper.hasOwnProperty( 'animEls' ) && Object.keys( swiper.animEls ).length > 0 ) {
			// console.log( 'animEls already exists' );
			return false;
		} else {
			// console.log( 'setAnim' );
		}

		swiper.animEls = {};

		swiper.el.querySelectorAll( '.swiper-slide-active .animated' ).forEach( ( el, i ) => {
			const animName = el.dataset.animName;

			el.classList.add( animName )
			el.style.opacity = 1;
			el.style.animationDuration = el.dataset.animDuration;
			el.style.animationDelay = el.dataset.animDelay;
			swiper.animEls[ i ] = { el: el, animName: animName };
		} );
	},


	/**
	 * Прячем анимируемые элементы скрываемого слайда.
	 *
	 * @param {jQuery Object} swiper - галерея.
	 * @return {void|false}
	 * @since 0.0.1
	 */
	delAnim( swiper ) {
		if ( swiper[ 'animEls' ] === undefined ) {
			// console.log( 'animEls not exists' );
			return false;
		} else {
			// console.log( 'delAnim' );
		}

		for ( let i in swiper.animEls ) {
			const { el, animName } = swiper.animEls[ i ];
			el.classList.remove( animName );
			el.style.opacity = 0;
		};

		swiper.animEls = {};
	},


	/**
	 * Слайдер.
	 *
	 * @param {DOM Object} gallery - галерея.
	 * @return {void}
	 * @since 0.0.1
	 */
	makeSlider( gallery ) { // Slider
		const self = this;
		const swiper = gallery.querySelector( '.swiper' ),
			  prevBtn = gallery.querySelector( '.swiper-button-prev-custom' ),
			  nextBtn = gallery.querySelector( '.swiper-button-next-custom' ),
			  pagination = gallery.querySelector( '.swiper-pagination-custom' );

		const params = {
			navigation: {
				nextEl: nextBtn,
				prevEl: prevBtn,
			},
			pagination: {
				el: pagination,
				type: 'bullets',
				clickable: true,
			},

			// initialSlide: 2,

			speed: 600,
			// loop: true,

			/*autoplay: {
				delay: 5000,
			},*/

			// effect: 'slide',
			effect: 'fade',
			fade: {
				crossFade: true,
			},

			// preloadImages: false,
			lazy: {
				enabled: true,
				loadOnTransitionStart: true,
				preloaderClass: 'swiper-lazy-preloader-custom',
				// loadPrevNextAmount: 1,
				// loadPrevNext: true
			},

			on: {
				init() {
					// console.log( '----------------' );
					self.setAnim( this );
					self.setSlideTextSize( this );
					self.setVideoIframe( this );
				},

				resize() {
					self.setVideoIframe( this );
				},

				autoplayStop() {
					// console.log( '1', this.autoplay );
					console.log( 'autoplay stopped' );
					self.swiperAutoplayStatus = false;
				},

				autoplayStart() {
					// console.log( '2', this.autoplay );
					console.log( 'autoplay started' );
					self.swiperAutoplayStatus = true;
				},

				beforeTransitionStart() {
					// console.log( 'beforeTransitionStart' );
					self.delAnim( this );
					self.setAnim( this );
					// console.log( '----------------' );
				}
			}
		};

		const slider = new Swiper( swiper, params );
	},


	/**
	 * POPUP видео.
	 *
	 * @param {DOM Object} swiper - галерея.
	 * @return {void}
	 * @since 0.0.1
	 */
	setVideoIframe( swiper ) { // Slider
		const autoplayOn = null !== this.swiperAutoplayStatus ? this.swiperAutoplayStatus : swiper.autoplay.running;

		$( '.mfp-iframe', swiper.el ).magnificPopup( {
			type: 'iframe',
			mainClass: 'bri-mfp-video-iframe',

			callbacks: {
				open: function() {
					// console.log( $.magnificPopup.instance );
					// console.log( 'open before', swiper.autoplay );
					if ( swiper.autoplay.running ) {
						swiper.autoplay.stop();
						// console.log( 'open after', swiper.autoplay );
					}
				},

				close: function() {
					// console.log( 'close before', swiper.autoplay );

					// По умолчанию "autoplay" включен, но был выключен при открытии "mfp-video".
					if ( autoplayOn && ! swiper.autoplay.running ) {
						swiper.autoplay.start();
						// console.log( 'close after', swiper.autoplay );
					}
				}
			},
		} );
	},


	/**
	 * Выборка всех галерей на странице и назначение им функционала.
	 *
	 * @return {void}
	 * @since 0.0.1
	 */
	getGalleries() {
		let ctx = this.ctx;

		if ( Array.isArray( ctx ) ) {
			ctx = ctx.join( ', ' );
		}

		document.querySelectorAll( this.ctx )
			.forEach( gallery => {
				this.makeSlider( gallery );
			} );
	},


	/**
	 * Изменение CSS селектора шаблона.
	 *
	 * @param {String} ctx - селектор галереи.
	 * @return {void}
	 * @since 0.0.1
	 */
	setSelector( ctx ) {
		if ( ! ctx ) return;
		this.ctx = ctx;
	},


	/**
	 * Let's start.
	 *
	 * @param {String} ctx - селектор галереи.
	 * @return {void}
	 * @since 0.0.1
	 */
	init( ctx ) {
		this.setSelector( ctx );
		this.getGalleries();
	},
};

hero.init();
