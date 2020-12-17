<?php
	$plugin_path = plugin_dir_path( __FILE__ );

	$assets = [
		'styles' => [

			'portfolio' => [
				'id'  => 'portfolio-tmpl-style',
				'src' => $plugin_path . 'extra/bri_tax_extra/assets_paths.php',
				'deps' => [ 'bri-bootstrap', 'bri-magnific-popup' ],
				'ver'  => '1.0.0'
			]
		],
		'scripts' => [ ... ]
	];
