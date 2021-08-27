<?php
$assets = [
	'css' => [
		/************ TMPL CSS ************/
		'portfolio' => [
			'id'   => 'briz-portfolio-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_portfolio.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-magnific-popup-css', 'briz-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'services' => [
			'id'   => 'briz-services-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_services.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'features' => [
			'id'   => 'briz-features-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_features.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-fontawesome-css' ],
			'ver'  => '1.0.0'
		],
		'stickers' => [
			'id'   => 'briz-stickers-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_stickers.min.css',
			'deps' => [ 'briz-bootstrap-css' ],
			'ver'  => '1.0.0'
		],
		'facts' => [
			'id'   => 'briz-facts-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_facts.min.css',
			'deps' => [ 'briz-bootstrap-css' ],
			'ver'  => '1.0.0'
		],
	],

	'js' => [
		/************ TMPL SCRIPTS ************/
		'portfolio' => [
			'id'        => 'briz-portfolio-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_portfolio.js',
			'deps'      => [ 'jquery', 'imagesloaded', 'briz-bootstrap-js', 'briz-magnific-popup-js', 'briz-isotop-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'features' => [
			'id'        => 'briz-features-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_features.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-imagesloaded-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'stickers' => [
			'id'        => 'briz-stickers-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_stickers.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-masonry-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'facts' => [
			'id'        => 'briz-facts-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_facts.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-masonry-js', 'briz-animatenumber-js', 'briz-wow-js', 'briz-parallax-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
	]
];
