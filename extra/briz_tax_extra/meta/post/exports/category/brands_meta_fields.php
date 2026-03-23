<?php
/**
 * Мета поля записей термина "brands".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */

defined( 'ABSPATH' ) || exit;

$brands_meta_fields = [
	[
		'title'  => 'Logo',
		'fields' => [
			'media' => [
				'type'  => 'media_button',
				'title' => 'Опция brands media',
				'desc'  => 'Описание brands media',
				'empty' => true,
				'value' => '[]',
				'options' => [
					'title'    => 'Insert a media',
					'library'  => [ 'type' => [ 'image', 'video', 'audio', 'application' ] ],
					'multiple' => false,
					'button'   => [ 'text' => 'Insert' ]
				]
			],
		]
	],
];
