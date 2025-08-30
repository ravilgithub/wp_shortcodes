console.log('shortcode_briz_tax.js');

/**
 * Определяем "OS".
 * Присваиваем элементу "html" соответствующий класс.
 */
const osDetect = {
	reg: /(linux|windows)/,
	class: 'bri',

	setClass: function ($suffix) {
		let $html = document.querySelector('html'),
			$className = `${this.class}-${$suffix}`;

		if (-1 === [].indexOf.call($html.classList, $className)) {
			$html.classList.add($className);
		}
	},

	detect: function () {
		let $match = '',
			$userAgent = navigator.userAgent.toLowerCase();

		if ($match = $userAgent.match(this.reg)) {
			this.setClass($match[1]);
		}
	},

	init: function () {
		this.detect();
	}
};

osDetect.init();
