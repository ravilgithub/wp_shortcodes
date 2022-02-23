/**
 * Blog functionality.
 */
import { slider } from './export/slider.js';

/**
 * Значения по умолчанию для слайдера.
 */
const tmplSliderAtts = {
  nextButton: '.swiper-button-next',
  prevButton: '.swiper-button-prev',
  pagination: '.swiper-pagination',
  paginationClickable: true,
  slidesPerView: 3,
  spaceBetween: 30,
  speed: 200,
  breakpoints: {
     250: {
      slidesPerView: 1,
      spaceBetween: 30,
    },
    320: {
      slidesPerView: 1,
      spaceBetween: 30,
    },
    480: {
      slidesPerView: 1,
      spaceBetween: 30,
    },
    567: {
      slidesPerView: 1,
      spaceBetween: 30,
    },
    640: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    991: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
  },

  // Lazy loading
  preloadImages: false,
  lazyLoading: true,
  lazyLoadingOnTransitionStart: true,
  lazyLoadingInPrevNextAmount: 1
};

slider.init( '.briz-blog-tmpl', tmplSliderAtts );
