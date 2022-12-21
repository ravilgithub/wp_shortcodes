/**
 * Значения по умолчанию для слайдера.
 */
const slider_defaults = {
	navigation: {
		nextEl: {
			dataType: 'string',
			value: '.swiper-button-next'
		},

		prevEl: {
			dataType: 'string',
			value: '.swiper-button-prev'
		}
	},

	pagination: {
		el: {
			dataType: 'string',
			value: '.swiper-pagination'
		},

		type: {
			dataType: 'string',
			value: 'bullets'
		},

		clickable: {
			dataType: 'boolean',
			value: true
		}
	},

	slidesPerView: {
		dataType: 'number',
		value: 1
	},

	spaceBetween: {
		dataType: 'number',
		value: 0
	},

	speed: {
		dataType: 'number',
		value: 200
	},

	autoplay: {
		dataType: 'boolean',
		value: false
	},

	/*autoplay: {
		delay: {
			dataType: 'number',
			value: 2000
		}
	},*/

	loop: {
		dataType: 'boolean',
		value: false
	},

	/*preloadImages: {
		dataType: 'boolean',
		value: true
	},*/

	lazy: {
		enabled: {
			dataType: 'boolean',
			value: false
		},

		loadOnTransitionStart: {
			dataType: 'boolean',
			value: false
		},

		preloaderClass: {
			dataType: 'string',
			value: 'swiper-lazy-preloader'
		},

		loadPrevNext: {
			dataType: 'boolean',
			value: false
		},

		lazyLoadingInPrevNextAmount: {
			dataType: 'number',
			value: 1
		}
	},

	breakpoints: {
		250: {
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		},

		320: {
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		},

		480: {
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		},

		568: { // ?? 567
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		},

		640: {
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		},

		768: {
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		},

		992: {
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		},

		1200: {
			slidesPerView: {
				dataType: 'number',
				value: 1,
			},

			spaceBetween: {
				dataType: 'number',
				value: 30,
			},
		}
	},

	on: {
		dataType: 'events',
		/*init: {
			dataType: 'function',
			value: null
		},
		beforeTransitionStart: {
			dataType: 'function',
			value: null
		},*/
	}

// ------------------------------------------------------

	// nextButton: { // +
	// 	dataType: 'string',
	// 	value: '.swiper-button-next'
	// },

	// prevButton: { // +
	// 	dataType: 'string',
	// 	value: '.swiper-button-prev'
	// },

	// pagination: { // +
	// 	dataType: 'string',
	// 	value: '.swiper-pagination'
	// },

	// paginationClickable: { // +
	// 	dataType: 'boolean',
	// 	value: true
	// },

	// slidesPerView: { // +
	// 	dataType: 'number',
	// 	value: 1
	// },

	// spaceBetween: { // +
	// 	dataType: 'number',
	// 	value: 0
	// },

	// speed: { // +
	// 	dataType: 'number',
	// 	value: 2050
	// },

	// autoplay: { // +
	// 	dataType: 'number',
	// 	value: 0
	// },

	// loop: { // +
	// 	dataType: 'boolean',
	// 	value: false
	// },

	// // Lazy loading
	// preloadImages: { // +
	// 	dataType: 'boolean',
	// 	value: false
	// },

	// lazyLoading: { // +
	// 	dataType: 'boolean',
	// 	value: true
	// },

	// lazyLoadingOnTransitionStart: { // +
	// 	dataType: 'boolean',
	// 	value: true
	// },

	// lazyLoadingInPrevNextAmount: { // +
	// 	dataType: 'number',
	// 	value: 1
	// }
};

export { slider_defaults };
