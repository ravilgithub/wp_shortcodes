<?php
/**
 * Мета поля термина "features".
 */
$features_meta_fields = [
	'fields' => [
		'tab_bg_color_enable' => [
			'type'  => 'checkbox',
			'title' => 'Показать цвет фона "Tab"',
			'desc'  => 'Показать цвет фона "Tab".',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'tab_bg_color' => [
			'type'  => 'color',
			'title' => 'Цвет фона элемента "Tab"',
			'desc'  => 'Цвет фона элемента "Tab"',
			'value' => '#fbffda'
		],
	]
];