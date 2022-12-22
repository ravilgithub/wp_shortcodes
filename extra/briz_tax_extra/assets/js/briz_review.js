/**
 * Review functionality.
 */
import { slider } from './export/slider.js';

const foo = num => num * 2;


/**
 * Значения по умолчанию для слайдера.
 */
const tmplSliderAtts = {
	navigation: {
		nextEl: '.swiper-button-next-custom',
		prevEl: '.swiper-button-prev-custom'
	},

	pagination: {
		// el: '.swiper-pagination-custom'
	},

  lazy: {
    enabled: true,
    loadOnTransitionStart: true,
    preloaderClass: 'swiper-lazy-preloader-custom'
  },

	on: {
		beforeTransitionStart() {
			// console.log( foo( 2 ) );
		},

		init( swiper ) {
			// console.log( 'i\'m inited' );
			// console.log( swiper );
		}
	}
};

slider.init( '.briz-review-tmpl', tmplSliderAtts );
