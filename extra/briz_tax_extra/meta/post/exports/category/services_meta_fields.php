<?php
/**
 * Мета поля записей термина "services".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */

defined( 'ABSPATH' ) || exit;

$services_meta_fields = [
	[
		'title'  => 'Services',
		'fields' => [
			'icon' => [
				'type'  => 'text',
				'title' => 'Имя иконки',
				'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
				'value' => 'star-o'
			],
		]
	],
];
