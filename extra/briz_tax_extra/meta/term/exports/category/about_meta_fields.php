<?php
/**
 * Мета поля термина "about".
 */
$about_meta_fields = [
	'fields' => [
		'option_12' => [
			'type'  => 'media_button',
			'title' => 'Опция 12',
			'desc'  => 'Описание опции 12',
			'value' => '[378,377,291,289,292]',
			'empty' => true,
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => 1,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'option_4' => [
			'type'  => 'number',
			'title' => 'Опция 4',
			'desc'  => 'Описание опции 4',
			'value' => 2,
			'options' => [
				'step' => 2,
				'min'  => 0,
				'max'  => 10
			]
		],
	]
];
