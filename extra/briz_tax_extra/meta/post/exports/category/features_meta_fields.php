<?php
/**
 * Мета поля записей термина "features".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */

defined( 'ABSPATH' ) || exit;

$features_meta_fields = [
	[
		'title'  => 'Features',
		'fields' => [
			'icon' => [
				'type'  => 'text',
				'title' => 'Имя иконки',
				'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
				'empty' => true,
				'value' => 'picture-o'
			],
			'label' => [
				'type'  => 'text',
				'title' => 'Лейбл',
				'desc'  => 'Название табуляции',
				'empty' => true,
				'value' => ''
			],
		]
	],
];
