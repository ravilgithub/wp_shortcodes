<?php
/**
 * Cписок регистрируемых JS и CSS файлов,
 * необходимых для формирования отображения шаблонов терминов.
 *
 * @see Briz_Tax_Shortcode::register_assets()
 * @link ~/inc/shortcode_briz_tax.php
 */
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
		'solutions' => [
			'id'   => 'briz-solutions-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_solutions.min.css',
			'deps' => [ 'briz-bootstrap-css' ],
			'ver'  => '1.0.0'
		],
		'blog' => [
			'id'   => 'briz-blog-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_blog.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-swiper-css' ],
			'ver'  => '1.0.0'
		],
		'team' => [
			'id'   => 'briz-team-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_team.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-swiper-css' ],
			'ver'  => '1.0.0'
		],
		'review' => [
			'id'   => 'briz-review-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_review.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-swiper-css' ],
			'ver'  => '1.0.0'
		],
		'brands' => [
			'id'   => 'briz-brands-tmpl-css',
			'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/briz_brands.min.css',
			'deps' => [ 'briz-bootstrap-css', 'briz-swiper-css' ],
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
		'solutions' => [
			'id'        => 'briz-solutions-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_solutions.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-wow-js', 'briz-parallax-js', 'briz-easing-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'blog' => [
			'id'        => 'briz-blog-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_blog.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-swiper-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'team' => [
			'id'        => 'briz-team-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_team.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-swiper-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'review' => [
			'id'        => 'briz-review-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_review.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-swiper-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
		'brands' => [
			'id'        => 'briz-brands-tmpl-js',
			'src'       => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/briz_brands.js',
			'deps'      => [ 'jquery', 'briz-bootstrap-js', 'briz-swiper-js' ],
			'ver'       => '1.0.0',
			'in_footer' => true
		],
	]
];
