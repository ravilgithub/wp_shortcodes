/**
 * Создание подсказок( tooltip label ) которые отображаются при наведении на кнопки:
 *  Добавить в корзину
 *  Добавить в список желаний
 *  Сравнить
 *  Быстрый просмотр
 *
 * @param {DOM Object} inst    - корневой элемент шаблона в котором находятся кнопки
 *                               для которых необходимо создать подсказки.
 * @param {Array} btnSelectors - селекторы кнопок для которых необходимо создать подсказки.
 * @param {String} tagName     - тег элемента подсказки.
 * @param {String} classes     - классы элемента подсказки.
 * @return {void}
 * @since 0.0.1
 */
const tooltip = ( inst, btnSelectors, tagName, classes ) => {
  btnSelectors.forEach( btnSelector => {
    inst.querySelectorAll( btnSelector ).forEach( btn => {
      const el = document.createElement( tagName );
      el.setAttribute( 'class', classes );
      el.innerHTML = btn.text;
      btn.after( el );
    } );
  } );
};

export { tooltip };
