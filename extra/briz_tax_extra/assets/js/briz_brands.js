 /**
 * Brands functionality.
 */
import { slider } from './export/slider.js';

const params = {
	slidesPerView: 6,
	speed: 600,
	loop: true,
	autoplay: 5000,
	breakpoints: {
		//250: { slidesPerView: 1 },
		320: { slidesPerView: 1 },
		480: { slidesPerView: 2 },
		567: { slidesPerView: 3 },
		//768: { slidesPerView: 3 },
		991: { slidesPerView: 4 },
	},
};

slider.init( '.briz-brands-tmpl', params );
