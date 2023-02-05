<?php
/**
 * Cписок регистрируемых JS и CSS библиотек.
 *
 * @see Helper::register_shortcodes_vendors()
 * @link ~/common/helpers.php
 */
$assets = [
	'css' => [
		/************ CSS ************/
		'bootstrap' => [
			'id'   => 'briz-bootstrap-css',
			'src'  => PLUGIN_URL . 'assets/vendors/bootstrap/css/bootstrap.min.css',
			'deps' => [],
			'ver'  => '3.3.5'
		],

		'mfp' => [
			'id'   => 'briz-magnific-popup-css',
			'src'  => PLUGIN_URL . 'assets/vendors/magnific-popup/magnific-popup.min.css',
			'deps' => [],
			'ver'  => '1.1.0'
		],

		'fontawesome' => [
			'id'   => 'briz-fontawesome-css',
			'src'  => PLUGIN_URL . 'assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css',
			'deps' => [],
			'ver'  => '4.7.0'
		],

		/*'swiper' => [
			'id'   => 'briz-swiper-css',
			'src'  => PLUGIN_URL . 'assets/vendors/swiper/swiper.min.css',
			'deps' => [],
			'ver'  => '3.3.1'
		],*/

		'swiper' => [
			'id'   => 'briz-swiper-css',
			'src'  => PLUGIN_URL . 'assets/vendors/swiper@8.2.6/swiper-bundle.min.css',
			'deps' => [],
			'ver'  => '8.2.6'
		],

		'fontello' => [
			'id'   => 'briz-fontello-css',
			'src'  => PLUGIN_URL . 'assets/vendors/fontello/css/fontello.min.css',
			'deps' => [],
			'ver'  => '1.0.0'
		],

		'extra' => [
			'id'   => 'briz-tax-extra-css',
			'src'  => PLUGIN_URL . 'assets/vendors/briz-tax-extra/css/extra.min.css',
			'deps' => [],
			'ver'  => '1.0.0'
		],

		'photoswipe' => [
			'id'   => 'briz-photoswipe-css',
			'src'  => PLUGIN_URL . 'assets/vendors/photoswipe/photoswipe.min.css',
			'deps' => [],
			'ver'  => '4.1.1'
		],
	],

	'js' => [
		/************ SCRIPTS ************/
		'bootstrap' => [
			'id'   => 'briz-bootstrap-js',
			'src'  => PLUGIN_URL . 'assets/vendors/bootstrap/js/bootstrap.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '3.3.5',
			'in_footer' => true
		],

		'mfp' => [
			'id'   => 'briz-magnific-popup-js',
			'src'  => PLUGIN_URL . 'assets/vendors/magnific-popup/jquery.magnific-popup.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '1.1.0',
			'in_footer' => true
		],

		'isotop' => [
			'id'   => 'briz-isotop-js',
			'src'  => PLUGIN_URL . 'assets/vendors/isotope/isotope.pkgd.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '3.0.1',
			'in_footer' => true
		],

		'masonry' => [
			'id'   => 'briz-masonry-js',
			'src'  => PLUGIN_URL . 'assets/vendors/masonry/masonry.pkgd.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '3.3.2',
			'in_footer' => true
		],

		'imagesloaded' => [
			'id'   => 'briz-imagesloaded-js',
			'src'  => PLUGIN_URL . 'assets/vendors/imagesloaded/imagesloaded.pkgd.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '3.3.2',
			'in_footer' => true
		],

		'animatenumber' => [
			'id'   => 'briz-animatenumber-js',
			'src'  => PLUGIN_URL . 'assets/vendors/animateNumber/jquery.animateNumber.js',
			'deps' => [ 'jquery' ],
			'ver'  => '0.0.12',
			'in_footer' => true
		],

		'wow' => [
			'id'   => 'briz-wow-js',
			'src'  => PLUGIN_URL . 'assets/vendors/wow/wow.min.js',
			'deps' => [],
			'ver'  => '1.1.2',
			'in_footer' => true
		],

		'parallax' => [
			'id'   => 'briz-parallax-js',
			'src'  => PLUGIN_URL . 'assets/vendors/parallax/parallax.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '1.4.2',
			'in_footer' => true
		],

		'brizEasing' => [
			'id'   => 'briz-easing-js',
			'src'  => PLUGIN_URL . 'assets/vendors/briz-easing/briz.easing.js',
			'deps' => [],
			'ver'  => '1.0.0',
			'in_footer' => true
		],

		/*'swiper' => [
			'id'   => 'briz-swiper-js',
			'src'  => PLUGIN_URL . 'assets/vendors/swiper/swiper.jquery.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '3.3.1',
			'in_footer' => true
		],*/

		'swiper' => [
			'id'   => 'briz-swiper-js',
			'src'  => PLUGIN_URL . 'assets/vendors/swiper@8.2.6/swiper-bundle.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '8.2.6',
			'in_footer' => true
		],

		'photoswipe' => [
			'id'   => 'briz-photoswipe-js',
			'src'  => PLUGIN_URL . 'assets/vendors/photoswipe/photoswipe.min.js',
			'deps' => [],
			'ver'  => '4.1.1',
			'in_footer' => true
		],

		'threesixty' => [
			'id'   => 'briz-threesixty-js',
			'src'  => PLUGIN_URL . 'assets/vendors/threesixty/threesixty.min.js',
			'deps' => [ 'jquery' ],
			'ver'  => '2.0.5'
		],
	]
];
