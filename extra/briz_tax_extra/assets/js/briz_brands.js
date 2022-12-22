 /**
 * Brands functionality.
 */
import { slider } from './export/slider.js';

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
};

slider.init( '.briz-brands-tmpl', tmplSliderAtts );
