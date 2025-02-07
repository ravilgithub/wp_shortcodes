<?php

/**
 * Мета поля записей термина "facts".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */
$facts_meta_fields = [
	[
		'title'  => 'Card 1',
		'fields' => [
			'card_1' => [
				'type'  => 'group',
				'title' => 'Card 1',
				'desc'  => 'Описание card 1',
				'value' => [
					'icon' => [
						'type'  => 'text',
						'title' => 'Имя иконки',
						'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
						'value' => 'lightbulb-o'
					],
					'number' => [
						'type'  => 'number',
						'title' => 'Число',
						'desc'  => 'Число которое будет анимироваться',
						'value' => 99,
						'options' => [
							'step' => 1,
							'min'  => '',
							'max'  => ''
						]
					],
					'symbol' => [
						'type'  => 'text',
						'title' => 'Приставка',
						'desc'  => 'Приставки перед или после числа',
						'empty' => true,
						'value' => '%'
					],
					'symbol_position' => [
						'type'  => 'radio',
						'title' => 'Позиция приставки',
						'desc'  => 'Позиция приставки перед или после числа',
						'value' => 'after',
						'options' => [
							'none'   => 'None',
							'before' => 'Before',
							'after'  => 'After'
						]
					],
					'label' => [
						'type'  => 'text',
						'title' => 'Лейбл',
						'desc'  => 'Текст под числом',
						'value' => 'SATISFIED CUSTOMRES'
					]
				]
			],
		]
	],
	[
		'title'  => 'Card 2',
		'fields' => [
			'card_2' => [
				'type'  => 'group',
				'title' => 'Card 2',
				'desc'  => 'Описание card 2',
				'value' => [
					'icon' => [
						'type'  => 'text',
						'title' => 'Имя иконки',
						'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
						'value' => 'lightbulb-o'
					],
					'number' => [
						'type'  => 'number',
						'title' => 'Число',
						'desc'  => 'Число которое будет анимироваться',
						'value' => 18,
						'options' => [
							'step' => 1,
							'min'  => '',
							'max'  => ''
						]
					],
					'symbol' => [
						'type'  => 'text',
						'title' => 'Приставка',
						'desc'  => 'Приставки перед или после числа',
						'empty' => true,
						'value' => ''
					],
					'symbol_position' => [
						'type'  => 'radio',
						'title' => 'Позиция приставки',
						'desc'  => 'Позиция приставки перед или после числа',
						'value' => 'none',
						'options' => [
							'none'   => 'None',
							'before' => 'Before',
							'after'  => 'After'
						]
					],
					'label' => [
						'type'  => 'text',
						'title' => 'Лейбл',
						'desc'  => 'Текст под числом',
						'value' => 'WINNING AWARDS'
					]
				]
			],
		]
	],
	[
		'title'  => 'Card 3',
		'fields' => [
			'card_3' => [
				'type'  => 'group',
				'title' => 'Card 3',
				'desc'  => 'Описание card 3',
				'value' => [
					'icon' => [
						'type'  => 'text',
						'title' => 'Имя иконки',
						'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
						'value' => 'lightbulb-o'
					],
					'number' => [
						'type'  => 'number',
						'title' => 'Число',
						'desc'  => 'Число которое будет анимироваться',
						'value' => 1873,
						'options' => [
							'step' => 1,
							'min'  => '',
							'max'  => ''
						]
					],
					'symbol' => [
						'type'  => 'text',
						'title' => 'Приставка',
						'desc'  => 'Приставки перед или после числа',
						'empty' => true,
						'value' => ''
					],
					'symbol_position' => [
						'type'  => 'radio',
						'title' => 'Позиция приставки',
						'desc'  => 'Позиция приставки перед или после числа',
						'value' => 'none',
						'options' => [
							'none'   => 'None',
							'before' => 'Before',
							'after'  => 'After'
						]
					],
					'label' => [
						'type'  => 'text',
						'title' => 'Лейбл',
						'desc'  => 'Текст под числом',
						'value' => 'WORDPRESS INSTALLS'
					]
				]
			],
		]
	],
	[
		'title'  => 'Card 4',
		'fields' => [
			'card_4' => [
				'type'  => 'group',
				'title' => 'Card 4',
				'desc'  => 'Описание card 4',
				'value' => [
					'icon' => [
						'type'  => 'text',
						'title' => 'Имя иконки',
						'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
						'value' => 'lightbulb-o'
					],
					'number' => [
						'type'  => 'number',
						'title' => 'Число',
						'desc'  => 'Число которое будет анимироваться',
						'value' => 2730,
						'options' => [
							'step' => 1,
							'min'  => '',
							'max'  => ''
						]
					],
					'symbol' => [
						'type'  => 'text',
						'title' => 'Приставка',
						'desc'  => 'Приставки перед или после числа',
						'empty' => true,
						'value' => ''
					],
					'symbol_position' => [
						'type'  => 'radio',
						'title' => 'Позиция приставки',
						'desc'  => 'Позиция приставки перед или после числа',
						'value' => 'none',
						'options' => [
							'none'   => 'None',
							'before' => 'Before',
							'after'  => 'After'
						]
					],
					'label' => [
						'type'  => 'text',
						'title' => 'Лейбл',
						'desc'  => 'Текст под числом',
						'value' => 'REGISTERED DOMAINS'
					]
				]
			],
		]
	],
];
