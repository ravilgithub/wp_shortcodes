<?php
/**
 * Мета поля записей термина "brands".
 */
$brands_meta_fields = [
	'fields' => [
		'media' => [
			'type'  => 'media_button',
			'title' => 'Опция brands media',
			'desc'  => 'Описание brands media',
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
