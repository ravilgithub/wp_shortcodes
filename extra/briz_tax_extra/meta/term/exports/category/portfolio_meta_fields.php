<?php
/**
 * Мета поля термина "portfolio".
 */
$portfolio_meta_fields = [
	'fields' => [
		'header' => [
			'type'  => 'checkbox',
			'title' => 'Заголовок',
			'desc'  => 'Показать/Спрятать заголовок.',
			'empty' => true,
			'value' => 'on',
			'options' => [
				'on' => 'On'
			]
		],
		'header_first' => [
			'type'  => 'text',
			'title' => 'Заголовок секции первая часть',
			'desc'  => 'Первая часть заголовка секции.',
			'empty' => true,
			'value' => 'Our'
		],
		'header_last' => [
			'type'  => 'text',
			'title' => 'Заголовок секции вторая часть',
			'desc'  => 'Вторая часть заголовка секции.',
			'empty' => true,
			'value' => 'portfolio'
		],
		'header_spacer' => [
			'type'  => 'checkbox',
			'title' => 'Section spacer',
			'desc'  => 'Show/Hide section spacer.',
			'empty' => true,
			'value' => [ 'on' ],
			'options' => [
				'on' => 'On'
			]
		],
		'header_description' => [
			'type'  => 'checkbox',
			'title' => 'Описание',
			'desc'  => 'Показать/Спрятать описание.',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'header_description_text' => [
			'type'  => 'textarea',
			'title' => 'Текст описания',
			'desc'  => 'Текст описания секции',
			'empty' => true,
			'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt deserunt iste, veniam necessitatibus repellat quis.'
		],
		'bg_img' => [
			'type'  => 'media_button',
			'title' => 'Background image',
			'desc'  => '',
			'value' => '[]',
			'empty' => true,
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => false,
				'button'   => [ 'text' => 'Insert' ]
			],
		],
		'bg_attachment' => [
			'type'  => 'select',
			'title' => 'Background attachment',
			'desc'  => '',
			'value' => 'default',
			'options' => [
				'default'  => 'default',
				'fixed'    => 'Fixed',
				'parallax' => 'Parallax',
				'hidden'   => 'Hidden'
			]
		],
		'header_bg_color_enable' => [
			'type'  => 'checkbox',
			'title' => 'Показать цвет фона заголовка',
			'desc'  => 'Показать цвет фона заголовка.',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'header_bg_color' => [
			'type'  => 'color',
			'title' => 'Цвет фона заголовка',
			'desc'  => 'Цвет фона заголовка',
			'value' => '#d9ffd1'
		],
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
		'content_bg_color_enable' => [
			'type'  => 'checkbox',
			'title' => 'Показать цвет фона контента',
			'desc'  => 'Показать цвет фона контента.',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'content_bg_color' => [
			'type'  => 'color',
			'title' => 'Цвет фона контента',
			'desc'  => 'Цвет фона контента',
			'value' => '#b0c4de'
		],
		'content_wide' => [
			'type'  => 'checkbox',
			'title' => 'Широкий контент',
			'desc'  => 'Контент на всю ширину экрана.',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
	]
];
