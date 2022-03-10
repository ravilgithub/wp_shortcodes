<?php
/**
 * Мета поля записей термина "features".
 */
$features_meta_fields = [
	'fields' => [

/* BEGIN для тестов */

		'option_112' => [
			'type'  => 'color',
			'title' => 'Option g_1_2_3',
			'desc'  => 'Описание option g_1_2_3',
			'value' => '#00cccc'
		],
		'number_insert_3' => [
			'type'  => 'number',
			'title' => 'Число',
			'desc'  => 'Число которое будет анимироваться',
			'value' => 4,
			'options' => [
				'step' => 1,
				'min'  => '',
				'max'  => ''
			]
		],
		'checbox_insert_3' => [
			'type'  => 'checkbox',
			'title' => 'Checbox',
			'desc'  => 'Описание checbox',
			'empty' => false,
			'value' => [
				'cat',
				'dog'
			],
			'options' => [
				'cat'   => 'Cat',
				'dog' => 'Dog',
				'mouse'  => 'mouse'
			]
		],
		'checbox_insert_4' => [
			'type'  => 'checkbox',
			'title' => 'Checbox',
			'desc'  => 'Описание checbox',
			'empty' => false,
			'value' => [],
			'options' => [
				'cat'   => 'Cat',
				'dog' => 'Dog',
				'mouse'  => 'mouse'
			]
		],
		'range' => [
			'type'  => 'range',
			'title' => 'Опция 7',
			'desc'  => 'Описание опции 7',
			'value' => '4',
			'options' => [
				'step' => 2,
				'min'  => 0,
				'max'  => 10
			]
		],
		'select' => [
			'type'  => 'select',
			'title' => 'Опция SELECT',
			'desc'  => 'Описание опции',
			'value' => 'blue',
			'options' => [
				'red'   => 'Red',
				'green' => 'Green',
				'blue'  => 'Blue'
			]
		],

/* END для тестов */

		'icon' => [
			'type'  => 'text',
			'title' => 'Имя иконки',
			'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
			// 'empty' => true,
			'value' => ''
		],
		'label' => [
			'type'  => 'text',
			'title' => 'Лейбл',
			'desc'  => 'Название табуляции',
			'empty' => true,
			'value' => ''
		],
	]
];
