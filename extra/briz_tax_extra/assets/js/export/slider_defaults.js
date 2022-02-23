/**
 * Значения по умолчанию для слайдера.
 */
const slider_defaults = {
	nextButton: {
		type: 'string',
		value: '.swiper-button-next',
	},

	prevButton: {
		type: 'string',
		value: '.swiper-button-prev',
	},

	pagination: {
		type: 'string',
		value: '.swiper-pagination',
	},

	paginationClickable: {
		type: 'boolean',
		value: true,
	},

	slidesPerView: {
		type: 'number',
		value: 1,
	},

	spaceBetween: {
		type: 'number',
		value: 0,
	},

	speed: {
		type: 'number',
		value: 2050,
	},

	autoplay: {
		type: 'number',
		value: 0,
	},

	loop: {
		type: 'boolean',
		value: false,
	},

	breakpoints: {
		250: {
			slidesPerView: {
				type: 'number',
				value: 1,
			},

			spaceBetween: {
				type: 'number',
				value: 0,
			},
		},

		320: {
			slidesPerView: {
				type: 'number',
				value: 1,
			},

			spaceBetween: {
				type: 'number',
				value: 0,
			},
		},

		480: {
			slidesPerView: {
				type: 'number',
				value: 1,
			},

			spaceBetween: {
				type: 'number',
				value: 0,
			},
		},

		567: {
			slidesPerView: {
				type: 'number',
				value: 1,
			},

			spaceBetween: {
				type: 'number',
				value: 0,
			},
		},

		640: {
			slidesPerView: {
				type: 'number',
				value: 1,
			},

			spaceBetween: {
				type: 'number',
				value: 0,
			},
		},

		768: {
			slidesPerView: {
				type: 'number',
				value: 1,
			},

			spaceBetween: {
				type: 'number',
				value: 0,
			},
		},

		991: {
			slidesPerView: {
				type: 'number',
				value: 1,
			},

			spaceBetween: {
				type: 'number',
				value: 0,
			},
		}
	},

	// Lazy loading
	preloadImages: {
		type: 'boolean',
		value: false,
	},

	lazyLoading: {
		type: 'boolean',
		value: true,
	},

	lazyLoadingOnTransitionStart: {
		type: 'boolean',
		value: true,
	},

	lazyLoadingInPrevNextAmount: {
		type: 'number',
		value: 1,
	},
};

export { slider_defaults };
