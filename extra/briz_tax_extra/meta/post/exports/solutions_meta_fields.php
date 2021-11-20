<?php
/**
 * Мета поля записей термина "solutions".
 */
$solutions_meta_fields = [
	'fields' => [
		'position' => [
			'type'  => 'radio',
			'title' => 'Content position',
			'desc'  => 'Left or right content position',
			'value' => 'left',
			'options' => [
				'left'  => 'Left',
				'right'  => 'Right'
			]
		],
		'bg_attachment' => [
			'type'  => 'select',
			'title' => 'Background type',
			'desc'  => 'Background type',
			'value' => 'default',
			'options' => [
				'default'  => 'default',
				'fixed'    => 'Fixed',
				'parallax' => 'Parallax',
				'hidden'   => 'Hidden'
			]
		],
		'bg_color' => [
			'type'  => 'select',
			'title' => 'Background color',
			'desc'  => 'Background color',
			'value' => 'white',
			'options' => [
				'white'  => 'White',
				'black'    => 'Black'
			]
		],
		'glassy' => [
			'type'  => 'checkbox',
			'title' => 'Background glassy',
			'desc'  => 'Background glassy',
			'empty' => true,
			'value' => [ 'on' ],
			'options' => [
				'on'  => 'On'
			]
		],
		'accordeon' => [
			'type'  => 'group',
			'title' => 'Accordeon',
			'decs'  => 'Accordeon fields',
			'value' => [
				'enable' => [
					'type'  => 'checkbox',
					'title' => 'Enable?',
					'desc'  => '',
					'empty' => true,
					'value' => [ 'on' ],
					'options' => [
						'on'  => 'On'
					]
				],
				'order' => [
					'type'  => 'number',
					'title' => 'Позиция элемента',
					'desc'  => 'Число от 0 включительно. Элемент с меньшим числом выводится раньше остальных.',
					'value' => 0,
					'options' => [
						'step' => 1,
						'min'  => 0,
						'max'  => ''
					]
				],
				'sections' => [
					'type'  => 'group',
					'title' => 'Sections',
					'desc'  => '',
					'value' => [
						'section_1' => [
							'type'  => 'group',
							'title' => 'Section 1',
							'desc'  => 'Section 1 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Accordeon title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Accordeon content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
						'section_2' => [
							'type'  => 'group',
							'title' => 'Section 2',
							'desc'  => 'Section 2 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Accordeon title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Accordeon content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
						'section_3' => [
							'type'  => 'group',
							'title' => 'Section 3',
							'desc'  => 'Section 3 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Accordeon title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Accordeon content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
					],
				]
			],
		],
		'tabs' => [
			'type'  => 'group',
			'title' => 'Tabs',
			'decs'  => 'Tabs fields',
			'value' => [
				'enable' => [
					'type'  => 'checkbox',
					'title' => 'Enable?',
					'desc'  => '',
					'empty' => true,
					'value' => [ 'on' ],
					'options' => [
						'on'  => 'On'
					]
				],
				'order' => [
					'type'  => 'number',
					'title' => 'Позиция элемента',
					'desc'  => 'Число от 0 включительно. Элемент с меньшим числом выводится раньше остальных.',
					'value' => 0,
					'options' => [
						'step' => 1,
						'min'  => 0,
						'max'  => ''
					]
				],
				'sections' => [
					'type'  => 'group',
					'title' => 'Sections',
					'desc'  => '',
					'value' => [
						'section_1' => [
							'type'  => 'group',
							'title' => 'Section 1',
							'desc'  => 'Section 1 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'icon' => [
									'type'  => 'text',
									'title' => 'Tab icon',
									'desc'  => 'Tab font-awesome icon class after .fa .fa-',
									'value' => 'lightbulb-o'
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Tab content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
						'section_2' => [
							'type'  => 'group',
							'title' => 'Section 2',
							'desc'  => 'Section 2 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'icon' => [
									'type'  => 'text',
									'title' => 'Tab icon',
									'desc'  => 'Tab font-awesome icon class after .fa .fa-',
									'value' => 'lightbulb-o'
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Tab content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
						'section_3' => [
							'type'  => 'group',
							'title' => 'Section 3',
							'desc'  => 'Section 3 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'icon' => [
									'type'  => 'text',
									'title' => 'Tab icon',
									'desc'  => 'Tab font-awesome icon class after .fa .fa-',
									'value' => 'lightbulb-o'
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Tab content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
					]
				],
			]
		],
		'tabs_2' => [
			'type'  => 'group',
			'title' => 'Tabs 2',
			'decs'  => 'Tabs 2 fields',
			'value' => [
				'enable' => [
					'type'  => 'checkbox',
					'title' => 'Enable?',
					'desc'  => '',
					'empty' => true,
					'value' => [ 'on' ],
					'options' => [
						'on'  => 'On'
					]
				],
				'order' => [
					'type'  => 'number',
					'title' => 'Позиция элемента',
					'desc'  => 'Число от 0 включительно. Элемент с меньшим числом выводится раньше остальных.',
					'value' => 0,
					'options' => [
						'step' => 1,
						'min'  => 0,
						'max'  => ''
					]
				],
				'sections' => [
					'type'  => 'group',
					'title' => 'Sections',
					'desc'  => '',
					'value' => [
						'section_1' => [
							'type'  => 'group',
							'title' => 'Section 1',
							'desc'  => 'Section 1 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'icon' => [
									'type'  => 'text',
									'title' => 'Tab icon',
									'desc'  => 'Tab font-awesome icon class after .fa .fa-',
									'value' => 'lightbulb-o'
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Tab content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
						'section_2' => [
							'type'  => 'group',
							'title' => 'Section 2',
							'desc'  => 'Section 2 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'icon' => [
									'type'  => 'text',
									'title' => 'Tab icon',
									'desc'  => 'Tab font-awesome icon class after .fa .fa-',
									'value' => 'lightbulb-o'
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Tab content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
						'section_3' => [
							'type'  => 'group',
							'title' => 'Section 3',
							'desc'  => 'Section 3 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'icon' => [
									'type'  => 'text',
									'title' => 'Tab icon',
									'desc'  => 'Tab font-awesome icon class after .fa .fa-',
									'value' => 'lightbulb-o'
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'content' => [
									'type'  => 'textarea',
									'title' => 'Tab content',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								]
							]
						],
					]
				],
			]
		],
		'progress_bar' => [
			'type'  => 'group',
			'title' => 'Progress bar',
			'decs'  => 'Progress bar fields',
			'value' => [
				'enable' => [
					'type'  => 'checkbox',
					'title' => 'Enable?',
					'desc'  => '',
					'empty' => true,
					'value' => [ 'on' ],
					'options' => [
						'on'  => 'On'
					]
				],
				'order' => [
					'type'  => 'number',
					'title' => 'Позиция элемента',
					'desc'  => 'Число от 0 включительно. Элемент с меньшим числом выводится раньше остальных.',
					'value' => 0,
					'options' => [
						'step' => 1,
						'min'  => 0,
						'max'  => ''
					]
				],
				'sections' => [
					'type'  => 'group',
					'title' => 'Sections',
					'desc'  => '',
					'value' => [
						'section_1' => [
							'type'  => 'group',
							'title' => 'Section 1',
							'desc'  => 'Section 1 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'target_number' => [
									'type'  => 'number',
									'title' => 'Целевое число',
									'desc'  => 'Финальное значение числа',
									'value' => 0,
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
							]
						],
						'section_2' => [
							'type'  => 'group',
							'title' => 'Section 2',
							'desc'  => 'Section 2 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'target_number' => [
									'type'  => 'number',
									'title' => 'Целевое число',
									'desc'  => 'Финальное значение числа',
									'value' => 0,
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
							]
						],
						'section_3' => [
							'type'  => 'group',
							'title' => 'Section 3',
							'desc'  => 'Section 3 desc',
							'value' => [
								'enable' => [
									'type'  => 'checkbox',
									'title' => 'Enable section?',
									'desc'  => '',
									'empty' => true,
									'value' => [ 'on' ],
									'options' => [
										'on'  => 'On'
									]
								],
								'title' => [
									'type'  => 'text',
									'title' => 'Tab title',
									'desc'  => 'Some text',
									'value' => 'Placeholder'
								],
								'target_number' => [
									'type'  => 'number',
									'title' => 'Целевое число',
									'desc'  => 'Финальное значение числа',
									'value' => 0,
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
							]
						],
					]
				],
			]
		],
	]
];
