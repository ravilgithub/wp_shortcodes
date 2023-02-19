/**
 * Products functionality.
 */
import { slider } from './export/slider.js';

const products = {
  ctx: '.briz-products-tmpl',

  selectors: {
    tab: 'tab-item',
    anchor: 'tab-anchor',
    content: '.section-content-wrap',
    contentInner: '.tab-content-inner',
    itemSlider: '.bri-archive-product-item-gallery',
  },

  sliderAtts: {
    navigation: {
      nextEl: '.swiper-button-next-custom',
      prevEl: '.swiper-button-prev-custom'
    },

    pagination: {
      // el: '.swiper-pagination-custom'
    },

    lazy: {
      // enabled: true,
      // loadOnTransitionStart: true,
      // preloaderClass: 'swiper-lazy-preloader-custom'
    },
  },

  itemSliderAtts: {
    navigation: {
      nextEl: '.swiper-button-next-custom',
      prevEl: '.swiper-button-prev-custom'
    },

    pagination: {
      // el: '.swiper-pagination-custom'
    },

    lazy: {
      // enabled: true,
      // loadOnTransitionStart: true,
      // preloaderClass: 'swiper-lazy-preloader-custom'
    },

    slidesPerView: 3,
    spaceBetween: 15,

    breakpoints: {
      250: { slidesPerView: 3 },
      320: { slidesPerView: 3 },
      384: { slidesPerView: 4 },
      480: { slidesPerView: 4 },
      568: { slidesPerView: 3 },
      640: { slidesPerView: 3 },
      768: { slidesPerView: 3 },
      992: { slidesPerView: 3 },
      1200: { slidesPerView: 3 }
    },

    on: {}
  },


  /**
   * Слайдер.
   *
   * @return {void}
   * @since 0.0.1
   */
  makeSlider: function() {
    this.getInstance().forEach( inst => {
      inst
        .querySelectorAll( this.selectors.contentInner )
        .forEach( el => {
          slider.init( el, this.sliderAtts, true );

          el
            .querySelectorAll( this.selectors.itemSlider )
            .forEach( item => {
              slider.init( item, this.itemSliderAtts );
            } );
        } );
    } );
  },


  /**
   * Стартовый метод.
   *
   * @return {void}
   * @since 0.0.1
   */
  firstAction() {
    this.getInstance().forEach( inst => {
      const content = this.getActiveContent( inst );
      if ( content )
        this.setContentHeight( content );

      this.setEvent( inst );
    } );
  },


  /**
   * Получаем коллекцию корневых элементов шаблона "Features".
   *
   * @return {Array} - коллекция корневых элементов шаблона.
   * @since 0.0.1
   */
  getInstance() {
    return document.querySelectorAll( this.ctx );
  },


  /**
   * Делегирование корневому элементу шаблона, события клик на элементе табуляции.
   *
   * @param {DOM Object} inst - корневой элемент шаблона "Features".
   * @return {void}
   * @since 0.0.1
   */
  setEvent( inst ) {
    inst.addEventListener( 'click', this.tabs.bind( this ), false );
  },


  /**
   * Выбор активного элемента контента.
   *
   * @param {DOM Object} evt - объект события.
   * @return {void|false}
   * @since 0.0.1
   */
  tabs( evt ) {
    let trgt = evt.target;
    const inst = evt.currentTarget;

    let contentId = '';
    if ( trgt.classList.contains( this.selectors.anchor ) ) {
      evt.preventDefault();
      contentId = trgt.getAttribute( 'href' );
      trgt = trgt.parentNode;
    } else if ( trgt.classList.contains( this.selectors.tab ) ) {
      contentId = trgt.querySelector( 'a' ).getAttribute( 'href' );
    } else {
      return false;
    }

    const content = inst.querySelector( contentId );
    if ( ! content )
      return false;

    this.toggleClass( trgt );
    this.toggleClass( content );
    this.setContentHeight( content );
  },


  /**
   * Присваивание/Удаление классов.
   *
   * @param {DOM Object} el - активный элемент.
   * @return {void}
   * @since 0.0.1
   */
  toggleClass( el ) {
    el.classList.add( 'active' );

    this.getSiblings( el ).forEach( sibling => {
      sibling.classList.remove( 'active' );
    } );
  },


  /**
   * Нахождение сестренских элементов.
   *
   * @param {DOM Object} el - активный элемент.
   * @return {void}
   * @since 0.0.1
   */
  getSiblings( el ) {
    return Array.prototype.filter.call( el.parentNode.children, child => child != el );
  },


  /**
   * Получаем видимый элемент контента.
   *
   * @param {DOM Object} inst - корневой элемент шаблона "Features".
   * @return {DOM Object} - видимый элемент контента.
   * @since 0.0.1
   */
  getActiveContent( inst ) {
    const contentInner = inst.querySelectorAll( this.selectors.contentInner );

    if ( ! contentInner.length )
      return false;

    return Array.prototype.filter.call( contentInner, i => i.classList.contains( 'active' ) )[ 0 ];
  },


  /**
   * Определяем высоту контента.
   *
   * @param {DOM Object} content - активный элемент контента.
   * @return {void}
   * @since 0.0.1
   */
  setContentHeight( content ) {
    imagesLoaded( content, () => {
      content.parentNode.style.height = content.clientHeight + 'px';
    } );
  },


  /**
   * Обработчик события "resize".
   *
   * @return {void}
   *
   * @since 0.0.1
   */
  resizeHandler() {
    window.addEventListener( 'resize', evt => {
      this.getInstance().forEach( i => {
        const content = this.getActiveContent( i );
        if ( content )
          this.setContentHeight( content );
      } );
    }, false );
  },


  /**
   * Изменение CSS селектора корневого элемента шаблона.
   *
   * @param {String} ctx - селектор корневого элемента шаблона.
   *
   * @return {void}
   *
   * @since 0.0.1
   * @author Ravil
   */
  setCtx( ctx ) {
    if ( ! ctx ) return;
    this.ctx = ctx;
  },


  /**
   * Let's go.
   *
   * @param {String} ctx - селектор корневого элемента шаблона.
   *
   * @return {void}
   * @since 0.0.1
   */
  init( ctx ) {
    this.setCtx( ctx );
    this.firstAction();
    this.resizeHandler();
    this.makeSlider();
  }
}.init();
