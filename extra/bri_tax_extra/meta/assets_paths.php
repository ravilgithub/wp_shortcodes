<?php
$assets = [
	'css' => [
		/************ TMPL CSS ************/
		'portfolio' => [
			'id'   => 'portfolio-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/portfolio.min.css',
			'deps' => [ 'bri-bootstrap-css', 'bri-magnific-popup-css', 'bri-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'services' => [
			'id'   => 'services-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/services.min.css',
			'deps' => [ 'bri-bootstrap-css', 'bri-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'features' => [
			'id'   => 'features-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/features.min.css',
			'deps' => [ 'bri-bootstrap-css', 'bri-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'stickers' => [
			'id'   => 'stickers-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/stickers.min.css',
			'deps' => [ 'bri-bootstrap-css' ],
			'ver'  => '1.0.0'
		],
	],

	'js' => [
		/************ TMPL SCRIPTS ************/
		'portfolio' => [
			'id'        => 'portfolio-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/portfolio.js',
			'deps'      => [ 'jquery', 'imagesloaded', 'bri-bootstrap-js', 'bri-magnific-popup-js', 'bri-isotop-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'features' => [
			'id'        => 'features-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/features.js',
			'deps'      => [ 'jquery', 'bri-bootstrap-js', 'bri-imagesloaded-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'stickers' => [
			'id'        => 'stickers-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/stickers.js',
			'deps'      => [ 'jquery', 'bri-bootstrap-js', 'bri-masonry-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		]
	]
];
