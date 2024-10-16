<?php
/**
 * Мета поля термина "pricing".
 */
$pricing_meta_fields = [
	'fields' => [
		'header' => [
			'type'  => 'checkbox',
			'title' => 'Заголовок',
			'desc'  => 'Показать/Спрятать заголовок.',
			'empty' => true,
			'value' => [ 'on' ],
			'options' => [
				'on' => 'On'
			]
		],
		'header_first' => [
			'type'  => 'text',
			'title' => 'Заголовок секции первая часть',
			'desc'  => 'Первая часть заголовка секции.',
			'empty' => true,
			'value' => 'Pricing'
		],
		'header_last' => [
			'type'  => 'text',
			'title' => 'Заголовок секции вторая часть',
			'desc'  => 'Вторая часть заголовка секции.',
			'empty' => true,
			'value' => 'info'
		],
		'header_spacer' => [
			'type'  => 'checkbox',
			'title' => 'Header spacer',
			'desc'  => 'Show/Hide header spacer.',
			'empty' => true,
			'value' => '',
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
				'multiple' => true,
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
		'trigger_bg_color_enable' => [
			'type'  => 'checkbox',
			'title' => 'Показать цвет фона "Переключатель цены"',
			'desc'  => 'Показать цвет фона "Переключатель цены".',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'trigger_bg_color' => [
			'type'  => 'color',
			'title' => 'Цвет фона элемента "Переключатель цены"',
			'desc'  => 'Цвет фона элемента "Переключатель цены"',
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
		'trigger' => [
			'type'  => 'checkbox',
			'title' => 'Trigger',
			'desc'  => 'Показать/Спрятать переключатель цены.',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'period_name_first' => [
			'type'  => 'text',
			'title' => 'Название минимального периода',
			'desc'  => 'EN название минимального периода, например: минута, день, месяц',
			'value' => 'Monthly'
		],
		'period_name_last' => [
			'type'  => 'text',
			'title' => 'Название максимального периода',
			'desc'  => 'EN название максимального периода, например: минута, день, месяц',
			'value' => 'Yearly'
		],
		'items_per_row' => [
			'type'  => 'number',
			'title' => 'Карточек в ряд',
			'desc'  => 'Количество карточек в ряд для ширины экрана >= 1200px.',
			'value' => '3',
			'options' => [
				'step' => 1,
				'min'  => 2,
				'max'  => 4
			] 
		],
	]
];
