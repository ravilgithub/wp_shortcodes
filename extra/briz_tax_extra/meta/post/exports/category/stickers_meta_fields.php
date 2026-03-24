<?php
/**
 * Мета поля записей термина "stickers".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */

defined( 'ABSPATH' ) || exit;

$stickers_meta_fields = [
	[
		'title'  => 'Stickers',
		'fields' => [
			'bg_only' => [
				'type'  => 'checkbox',
				'title' => 'Background only',
				'desc'  => 'Показывать только миниатюру записи',
				'value' => [],
				'empty' => true,
				'options' => [
					'on' => 'On'
				]
			],
		]
	],
];
