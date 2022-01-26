<?php
/**
 * Мета поля записей термина "review".
 */
$review_meta_fields = [
	'fields' => [
		'member_info' => [
			'type'  => 'text',
			'title' => 'Member info',
			'desc'  => 'Краткая информация о персоне, в двух словах',
			'value' => 'Web Design'
		],
		'option_tmp_1' => [
			'type'  => 'media_button',
			'title' => 'Опция TEMP_1',
			'desc'  => 'Описание опции TEMP_1',
			'empty' => true,
			'value' => '[876]',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => 0,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'option_tmp_2' => [
			'type'  => 'media_button',
			'title' => 'Опция TEMP_2',
			'desc'  => 'Описание опции TEMP_2',
			'empty' => true,
			'value' => '[]',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'audio' ],
				'multiple' => 0,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'option_tmp_3' => [
			'type'  => 'media_button',
			'title' => 'Опция TEMP_3',
			'desc'  => 'Описание опции TEMP_3',
			'empty' => true,
			'value' => '[690,691,694]',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => [ 'video', 'audio' ] ],
				'multiple' => 0,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'option_tmp_4' => [
			'type'  => 'media_button',
			'title' => 'Опция TEMP_4',
			'desc'  => 'Описание опции TEMP_4',
			'empty' => true,
			'value' => '[876,875,874,690,691,694,873,872,857]',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => [ 'image', 'video', 'audio', 'application' ] ],
				'multiple' => 0,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
	]
];
