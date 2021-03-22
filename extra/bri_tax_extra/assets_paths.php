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
	],

	'js' => [
		/************ TMPL SCRIPTS ************/
		'portfolio' => [
			'id'        => 'portfolio-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/portfolio.js',
			'deps'      => [ 'jquery', 'imagesloaded', 'bri-bootstrap-js', 'bri-magnific-popup-js', 'bri-isotop-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		]
	]
];
