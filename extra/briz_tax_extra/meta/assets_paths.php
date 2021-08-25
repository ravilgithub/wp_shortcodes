<?php
$assets = [
	'css' => [
		/************ TMPL CSS ************/
		'portfolio' => [
			'id'   => 'portfolio-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/portfolio.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-magnific-popup-css', 'briz-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'services' => [
			'id'   => 'services-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/services.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'features' => [
			'id'   => 'features-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/features.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'stickers' => [
			'id'   => 'stickers-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/stickers.min.css',
			'deps' => [ 'briz-bootstrap-css' ],
			'ver'  => '1.0.0'
		],
		'facts' => [
			'id'   => 'facts-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/facts.min.css',
			'deps' => [ 'briz-bootstrap-css' ],
			'ver'  => '1.0.0'
		],
	],

	'js' => [
		/************ TMPL SCRIPTS ************/
		'portfolio' => [
			'id'        => 'portfolio-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/portfolio.js',
			'deps'      => [ 'jquery', 'imagesloaded', 'briz-bootstrap-js', 'briz-magnific-popup-js', 'briz-isotop-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'features' => [
			'id'        => 'features-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/features.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-imagesloaded-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'stickers' => [
			'id'        => 'stickers-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/stickers.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-masonry-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'facts' => [
			'id'        => 'facts-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/facts.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-masonry-js', 'briz-animatenumber-js', 'briz-wow-js', 'briz-parallax-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
	]
];
