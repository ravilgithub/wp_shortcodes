<?php
/**
 * Array of parameters for creating metaboxes with fields.
 *
 * Массив параметров для создания мета блоков с полями.
 *
 * @see ~/extra/briz_tax_extra/meta_boxes.php
 *      Meta_boxes::__construct()
 *
 * @var Array $opts {
 *  @type Array $taxonomy_name {
 *   @type Array $term_name {
 *    @type Array $fields {
 *     @type Array $option_name {
 *      @type String $type        - Тип мета поля.
 *                                  Required.
 *      @type String $title       - Название мета поля.
 *      @type String $desc        - Описание мета поля.
 *      @type Int/Boolean $empty  - Может ли значение поля быть пустым.
 *                                  Default: false
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
require 'exports/portfolio_meta_fields.php';
require 'exports/services_meta_fields.php';
require 'exports/features_meta_fields.php';
require 'exports/stickers_meta_fields.php';
require 'exports/about_meta_fields.php';
require 'exports/facts_meta_fields.php';
require 'exports/solutions_meta_fields.php';

$opts = [
	'category' => [
		'portfolio' => $portfolio_meta_fields,
		'services'  => $services_meta_fields,
		'features'  => $features_meta_fields,
		'stickers'  => $stickers_meta_fields,
		'about'     => $about_meta_fields,
		'facts'     => $facts_meta_fields,
		'solutions' => $solutions_meta_fields,
	],
];
