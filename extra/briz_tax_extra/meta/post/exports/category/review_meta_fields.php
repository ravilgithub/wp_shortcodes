<?php

/**
 * Мета поля записей термина "review".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */
$review_meta_fields = [
	[
		'title'  => 'Review',
		'fields' => [
			'member_info' => [
				'type'  => 'text',
				'title' => 'Member info',
				'desc'  => 'Краткая информация о персоне, в двух словах',
				'value' => 'Web Design'
			],
		]
	],
];
