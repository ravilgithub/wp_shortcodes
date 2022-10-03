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
		'bg_img' => [
			'type'  => 'media_button',
			'title' => 'Background image',
			'desc'  => '',
			'value' => '[857]',
			'empty' => false,
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => false,
				'button'   => [ 'text' => 'Insert' ]
			],
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
			'value' => '#fafafa'
		],
		'theme_color' => [
			'type'  => 'select',
			'title' => 'Theme color',
			'desc'  => 'Theme color',
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
		'solution_elements' => [
			'type'  => 'group',
			'title' => 'Solution elements',
			'decs'  => 'Solution elements fields',
			'value' => [
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
											'value' => 'We Create Awesome Websites For Your Business'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Accordeon content',
											'desc'  => 'Some text',
											'value' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui.'
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
											'value' => 'Only Creative Design and Development'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Accordeon content',
											'desc'  => 'Some text',
											'value' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.'
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
											'value' => 'Let’s Start Creating Websites Together Today'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Accordeon content',
											'desc'  => 'Some text',
											'value' => 'Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui.'
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
											'value' => 'Mission'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Tab content',
											'desc'  => 'Some text',
											'value' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem.'
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
											'value' => 'Vision'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Tab content',
											'desc'  => 'Some text',
											'value' => 'Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem.'
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
											'value' => 'Support'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Tab content',
											'desc'  => 'Some text',
											'value' => 'Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.'
										]
									]
								],
							]
						],
					]
				],
				'tabs_2' => [
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
											'value' => 'Mission'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Tab content',
											'desc'  => 'Some text',
											'value' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem.'
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
											'value' => 'Vision'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Tab content',
											'desc'  => 'Some text',
											'value' => 'Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem.'
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
											'value' => 'Support'
										],
										'content' => [
											'type'  => 'textarea',
											'title' => 'Tab content',
											'desc'  => 'Some text',
											'value' => 'Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.'
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
											'value' => 'Visual development'
										],
										'target_number' => [
											'type'  => 'number',
											'title' => 'Целевое число',
											'desc'  => 'Финальное значение числа',
											'value' => 30,
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
											'value' => 'Social marketing'
										],
										'target_number' => [
											'type'  => 'number',
											'title' => 'Целевое число',
											'desc'  => 'Финальное значение числа',
											'value' => 70,
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
											'value' => '$'
										],
										'symbol_position' => [
											'type'  => 'radio',
											'title' => 'Позиция приставки',
											'desc'  => 'Позиция приставки перед или после числа',
											'value' => 'before',
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
											'value' => 'Creative thinking'
										],
										'target_number' => [
											'type'  => 'number',
											'title' => 'Целевое число',
											'desc'  => 'Финальное значение числа',
											'value' => 100,
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
											'value' => 'none',
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
		],
	]
];
