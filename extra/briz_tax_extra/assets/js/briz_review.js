/**
 * Review functionality.
 */
import { slider } from './export/slider.js';

const params = {
	slidesPerView: 2,
	breakpoints: {
		991: { slidesPerView: 3 },
	},
};

slider.init( '.briz-review-tmpl', params );
