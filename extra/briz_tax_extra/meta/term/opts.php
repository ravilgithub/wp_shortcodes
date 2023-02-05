<?php
/**
 * Array of parameters for creating meta fields for taxonomy terms.
 *
 * Массив параметров для создания мета полей терминов таксономии.
 *
 * @see ~/extra/briz_tax_extra/meta/term_meta_opts.php
 *      Term_Meta_Opts::__construct()
 *
 * @var Array $opts {
 *  @type Array $taxonomy_name {
 *   @type Array $term_name/$__to_all__ {
 *    @type Array $fields {
 *     @type Array $option_name {
 *      @type String $type        - Тип мета поля.
 *                                  Required.
 *      @type String $title       - Название мета поля.
 *      @type String $desc        - Описание мета поля.
 *      @type String/Array $value - Значение мета поля по умолчанию.
 *                                  Required.
 *                                  Default: ''
 *      @type Array $options      - Параметры мета поля.
 *     }
 *    }
 *   }
 *  }
 * }
 *
 */

/* Category */
require 'exports/category/__to_all__meta_fields.php';
require 'exports/category/facts_meta_fields.php';
require 'exports/category/about_meta_fields.php';
require 'exports/category/solutions_meta_fields.php';
require 'exports/category/stickers_meta_fields.php';
require 'exports/category/review_meta_fields.php';
require 'exports/category/team_meta_fields.php';
require 'exports/category/brands_meta_fields.php';
require 'exports/category/blog_meta_fields.php';
require 'exports/category/features_meta_fields.php';
require 'exports/category/portfolio_meta_fields.php';
require 'exports/category/pricing_meta_fields.php';
require 'exports/category/services_meta_fields.php';
require 'exports/category/video_meta_fields.php';
require 'exports/category/subscribe_meta_fields.php';

/* Product category */
require 'exports/product_cat/__to_all__products_meta_fields.php';
require 'exports/product_cat/products_meta_fields.php';

$opts = [
	'category' => [
		'__to_all__' => $__to_all__meta_fields,
		'facts'      => $facts_meta_fields,
		'about'      => $about_meta_fields,
		'solutions'  => $solutions_meta_fields,
		'stickers'   => $stickers_meta_fields,
		'review'     => $review_meta_fields,
    'team'       => $team_meta_fields,
    'brands'     => $brands_meta_fields,
    'blog'       => $blog_meta_fields,
    'features'   => $features_meta_fields,
    'portfolio'  => $portfolio_meta_fields,
    'pricing'    => $pricing_meta_fields,
    'services'   => $services_meta_fields,
    'video'      => $video_meta_fields,
    'subscribe'  => $subscribe_meta_fields,
	],

	'product_cat' => [
		'__to_all__' => $__to_all__products_meta_fields,
    'products'   => $products_meta_fields,
	]
];
