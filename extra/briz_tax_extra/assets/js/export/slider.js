/**
 * Функционал обеспечивающий работу слайдера в шаблонах.
 *
 * @property {String} ctx    - селектор шаблона в котором находится слайдер.
 * @property {Object} params - пользовательские параметры слайдера.
 * @since 0.0.1
 * @autor Ravil
 */
const slider = {
	ctx: '',
	params: {},

	getParams( params ) {
		let defaults = {
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
			pagination: '.swiper-pagination',
			paginationClickable: true,
			slidesPerView: 3,
			spaceBetween: 30,
			speed: 200,
			breakpoints: {
				/*250: { slidesPerView: 1 },
				320: { slidesPerView: 1 },*/
				//480: { slidesPerView: 1 },
				567: { slidesPerView: 1 },
				//640: { slidesPerView: 1 },
				//768: { slidesPerView: 1 },
				991: { slidesPerView: 2 },
			},

			// Lazy loading
			preloadImages: false,
			lazyLoading: true,
			lazyLoadingOnTransitionStart: true,
			lazyLoadingInPrevNextAmount: 1
		};

		for ( const i in this.params ) {
			defaults[ i ] = this.params[ i ];
		}

		return defaults;
	},

	setSlider() {
		new Swiper( `${this.ctx} .swiper-container`, this.getParams() );
	},

	init( ctx, params ) {
		if ( ! ctx )
			return false;
		this.ctx = ctx;
		this.params = params || {};
		this.setSlider( params );
	}
};

export { slider };
