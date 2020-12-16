<?php

$opts = [
	'category' => [
		'portfolio' => [
			'fields' => [
				'option_1' => [
					'type' => 'text',
					'title' => 'Опция 1',
					'desc' => 'Описание опции 1',
					'value' => 'Значение по умолчанию опции 1'
				],
				'option_2' => [
					'type' => 'textarea',
					'title' => 'Опция 2',
					'desc' => 'Описание опции 2',
					'value' => 'Значение по умолчанию опции 2'
				],
				'option_3' => [
					'type' => 'color',
					'title' => 'Опция 3',
					'desc' => 'Описание опции 3',
					'value' => '#00cccc'
				],
				'option_4' => [
					'type' => 'number',
					'title' => 'Опция 4',
					'desc' => 'Описание опции 4',
					'value' => 5,
					'options' => [
						'step' => 2,
						'min' => 0,
						'max' => 10
					]
				],
				'option_5' => [
					'type' => 'select',
					'title' => 'Опция 5',
					'desc' => 'Описание опции 5',
					'value' => 'red',
					'options' => [
						'red' => 'Red',
						'green' => 'Green',
						'blue' => 'Blue'
					]
				],
				'option_6' => [
					'type' => 'checkbox',
					'title' => 'Опция 6',
					'desc' => 'Описание опции 6',
					'value' => [
						'green',
						'red'
					],
					'options' => [
						'red' => 'Red',
						'green' => 'Green',
						'blue' => 'Blue'
					]
				],
				'option_7' => [
					'type' => 'range',
					'title' => 'Опция 7',
					'desc' => 'Описание опции 7',
					'value' => '5',
					'options' => [
						'step' => 2,
						'min' => 0,
						'max' => 10
					]
				],
				'option_8' => [
					'type' => 'radio',
					'title' => 'Опция 8',
					'desc' => 'Описание опции 8',
					'value' => 'green',
					'options' => [
						'red' => 'Red',
						'green' => 'Green',
						'blue' => 'Blue'
					]
				],
				'option_9' => [
					'type' => 'url',
					'title' => 'Опция 9',
					'desc' => 'Описание опции 9',
					'value' => 'https://yandex.ru',
					'pattern' => 'https://.*',
					'required' => true
				],
				'option_10' => [
					'type' => 'wp_editor',
					'title' => 'Опция 10',
					'desc' => 'Описание опции 10',
					'value' => '<h1>Title</h1>',
					'options' => [
						// 'textarea_name'    => $name, //нужно указывать!
						'editor_class'     => 'editor-class',
						// изменяемое
						'wpautop'          => 1,
						'textarea_rows'    => 5,
						'tabindex'         => null,
						'editor_css'       => '',
						'teeny'            => 0,
						'dfw'              => 0,
						'tinymce'          => 1,
						'quicktags'        => 1,
						'media_buttons'    => true,
						'drag_drop_upload' => false
					]
				],
			],
		],
		'about' => [
			'fields' => [
				'option_1' => [
					'type' => 'text',
					'title' => 'Опция 1',
					'desc' => 'Описание опции 1',
					'value' => 'Значение по умолчанию опции 1'
				],
				'option_2' => [
					'type' => 'textarea',
					'title' => 'Опция 2',
					'desc' => 'Описание опции 2',
					'value' => 'Значение по умолчанию опции 2'
				],
			],
		],
	],
];