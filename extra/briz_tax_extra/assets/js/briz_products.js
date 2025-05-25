/**
 * Products functionality.
 */
import { slider } from './export/slider.js';
import { tooltip } from './export/tooltip.js';
import { test } from './export/test.js';
test.init( document, 'mouseup', 'products' );

const products = {
  ctx: '.briz-products-tmpl',
  inAction: null,
  events: {
    click: [
      'tabs',
      'slideChange',
    ],
  },

  selectors: {
    tab: 'tab-item',
    anchor: 'tab-anchor',
    content: '.section-content-wrap',
    contentInner: '.tab-content-inner',
    itemSlider: '.bri-archive-product-item-gallery',
    buttons: [
      // '.button-group .add_to_cart_button',
      '.button-group .product_type_simple',
      '.button-group .product_type_variable',
      '.button-group .product_type_external',
      '.button-group .product_type_grouped',
      '.button-group .add_to_wishlist',
      '.button-group .yith-wcwl-wishlistaddedbrowse a',
      '.button-group .yith-wcwl-wishlistexistsbrowse a',
      '.button-group .compare',
      '.button-group .quickview',
    ],
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
      250: { slidesPerView: 3, spaceBetween: 15 },
      320: { slidesPerView: 3, spaceBetween: 15 },
      384: { slidesPerView: 4, spaceBetween: 15 },
      480: { slidesPerView: 4, spaceBetween: 15 },
      568: { slidesPerView: 3, spaceBetween: 15 },
      640: { slidesPerView: 3, spaceBetween: 15 },
      768: { slidesPerView: 3, spaceBetween: 15 },
      992: { slidesPerView: 3, spaceBetween: 15 },
      1200: { slidesPerView: 3, spaceBetween: 15 }
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
          this.buttons_preloader( el );
          el
            .querySelectorAll( this.selectors.itemSlider )
            .forEach( item => {
              slider.init( item, this.itemSliderAtts );
            } );
        } );
    } );
  },


  /**
   * Смена большой картинки карточки товара при нажатии на миниатюру товара.
   *
   * @param {Event Object} evt
   *
   * @return {void}
   * @since 0.0.1
   */
  slideChange( evt ) {
    const slide = evt.target.parentNode,
    lgImgSrc = slide.dataset.lgImgSrc,
    lgImgSrcSet = slide.dataset.lgImgSrcset;

    if ( ! lgImgSrc || ! lgImgSrcSet || this.inAction )
      return false;

    this.inAction = 1;
    this.toggleClass( slide );

    const thumb = slide.closest( '.product' ),
          lgImg = thumb.querySelector( '.product-image img' );

    thumb.classList.add( 'img-change-on-action' );

    const tmpImg = new Image();
    tmpImg.src = lgImgSrc;
    tmpImg.srcset = lgImgSrcSet;
    tmpImg
      .decode()
      .then( () => {
        lgImg.setAttribute( 'src', lgImgSrc );
        lgImg.setAttribute( 'srcset', lgImgSrcSet );
        thumb.classList.remove( 'img-change-on-action' );
        this.inAction = 0;
      } )
      .catch( err => console.log( err ) );
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

      // this.createToolTips( inst );
      tooltip( inst, this.selectors.buttons, 'span', 'product-button-tooltip-label' );
      this.setEvent( inst );
    } );
  },


  /**
   * Получаем коллекцию корневых элементов шаблона "Products".
   *
   * @return {Array} - коллекция корневых элементов шаблона.
   * @since 0.0.1
   */
  getInstance() {
    return document.querySelectorAll( this.ctx );
  },


  /**
   * Делегирование событий корневому элементу шаблона.
   *
   * @param {DOM Object} inst - корневой элемент шаблона "Products".
   * @return {void}
   * @since 0.0.1
   */
  setEvent( inst ) {
    for( let type in this.events ) {
      console.log(type);
      for( let handler of this.events[ type ] ) {
        inst.addEventListener( type, this[ handler ].bind( this ), false );
      }
    }
  },


  /**
   * Создание подсказок( tooltip label ) которые отображаются при наведении на кнопки:
   *  Добавить в корзину
   *  Добавить в список желаний
   *  Сравнить
   *  Быстрый просмотр
   *
   * @param {DOM Object} inst - корневой элемент шаблона "Products".
   * @return {void}
   * @since 0.0.1
   */
  /*createToolTips( inst ) {
    this.selectors.buttons.forEach( btnSelector => {
      inst.querySelectorAll( btnSelector ).forEach( btn => {
        const span = document.createElement( 'span' );
        span.setAttribute( 'class', 'product-button-tooltip-label' );
        span.innerHTML = btn.text;
        btn.after( span );
      } );
    } );
  },*/


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
   * Нахождение сестринских элементов.
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
   * @param {DOM Object} inst - корневой элемент шаблона "Products".
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
   * Иконка "preloader" для кнопок "Wishlist" и "Compare".
   *
   * @return {void}
   *
   * @since 0.0.1
   */
  buttons_preloader( slider ) {
    const btnSelectors = [
      '.button-group .add_to_wishlist',
      '.button-group .compare',
    ];

    btnSelectors.forEach( btnSelector => {
      slider
        .querySelectorAll( btnSelector )
        .forEach( btn => btn.addEventListener( 'click', evt => evt.target.classList.add( 'loading' ) ) );
    } );
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
