<?php
/**
 * Array of parameters for creating metaboxes with fields.
 *
 * Массив параметров для создания мета блоков с полями.
 *
 * @see ~/extra/bri_tax_extra/meta_boxes.php
 *      Meta_boxes::__construct()
 *
 * @var Array $opts {
 *  @type Array $taxonomy_name {
 *   @type Array $term_name {
 *    @type Array $fields {
 *     @type Array $option_name {
 *      @type String $type        - Тип мета поля.
 *                                  Required.
 *      @type String $title       - Название мета поля.
 *      @type String $desc        - Описание мета поля.
 *      @type String/Array $value - Значение мета поля по умолчанию.
 *                                  Required.
 *                                  Default: ''
 *      @type Array $options      - Параметры мета поля.
 *     }
 *    }
 *   }
 *  }
 * }
 *
 */

$opts = [
	'category' => [
		'portfolio' => [
			'fields' => [
				'option_1' => [
					'type'  => 'text',
					'title' => 'Опция 1',
					'desc'  => 'Описание опции 1',
					'value' => 'Значение по умолчанию опции 1'
				],
				'option_x' => [
					'type'  => 'text',
					'title' => 'Опция x',
					'desc'  => 'Описание опции x',
					'value' => 'Значение по умолчанию опции x'
				],

				'group_insert' => [
					'type'  => 'group',
					'title' => 'Group insert',
					'desc'  => 'Описание group insert',
					'color' => 'red',
					'value' => [
						'group_insert_1' => [
							'type'  => 'group',
							'title' => 'Group insert 1',
							'desc'  => 'Описание group insert 1',
							'color' => '#ca0',
							'value' => [
								'icon_insert' => [
									'type'  => 'text',
									'title' => 'Имя иконки',
									'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
									'value' => 'Иконка :)'
								],
								'checbox' => [
									'type'  => 'checkbox',
									'title' => 'Checbox',
									'desc'  => 'Описание checbox',
									'value' => [
										'cat',
										'mouse'
									],
									'options' => [
										'cat'   => 'Cat',
										'dog' => 'Dog',
										'mouse'  => 'mouse'
									]
								],
								'number_insert' => [
									'type'  => 'number',
									'title' => 'Число',
									'desc'  => 'Число которое будет анимироваться',
									'value' => 4,
									'options' => [
										'step' => 1,
										'min'  => '',
										'max'  => ''
									]
								]
							]
						]
					]
				],

				'group_1' => [
					'type'  => 'group',
					'title' => 'Group 1',
					'desc'  => 'Описание group 1',
					'value' => [
						'option_g_1_1' => [
							'type'  => 'text',
							'title' => 'Option 1_1',
							'desc'  => 'Описание option 1_1',
							'color' => '#FFE0DA',
							'value' => 'Значение по умолчанию option 1_1'
						],
						'media_1' => [
							'type'  => 'media_button',
							'title' => 'Опция media 1',
							'desc'  => 'Описание опции media 1',
							'value' => '',
							'options' => [
								'title'    => 'Insert a media',
								'library'  => [ 'type' => 'image' ],
								'multiple' => 0,
								'button'   => [ 'text' => 'Insert' ]
							]
						],
						'option_9' => [
							'type'     => 'url',
							'title'    => 'Опция 9',
							'desc'     => 'Описание опции 9',
							'value'    => 'https://yandex.ru',
							'pattern'  => 'https://.*',
							'required' => true
						],
						'option_6' => [
							'type'  => 'checkbox',
							'title' => 'Опция 6',
							'desc'  => 'Описание опции 6',
							'value' => [
								'green',
								'blue'
							],
							'options' => [
								'red'   => 'Red',
								'green' => 'Green',
								'blue'  => 'Blue'
							]
						],
						'group_1_1' => [
							'type'  => 'group',
							'title' => 'Group 1_1',
							'desc'  => 'Описание group 1_1',
							'value' => [
								'group_1_1_1' => [
									'type'  => 'group',
									'title' => 'Group 1_1_1',
									'desc'  => 'Описание group 1_1_1',
									'value' => [
										'icon' => [
											'type'  => 'text',
											'title' => 'Имя иконки',
											'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
											'value' => 'Иконка 1_1_1 -'
										],
										'insert' => [
											'type'  => 'checkbox',
											'title' => 'Insert',
											'desc'  => 'Описание inset',
											'value' => [
												// 'green',
												'red'
											],
											'options' => [
												'red'   => 'Red',
												'green' => 'Green',
												'blue'  => 'Blue'
											]
										],
										'number' => [
											'type'  => 'number',
											'title' => 'Число',
											'desc'  => 'Число которое будет анимироваться',
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
											'value' => ''
										]
									]
								],
								'icon' => [
									'type'  => 'text',
									'title' => 'Имя иконки',
									'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
									'value' => 'Иконка 1_1'
								],
								'group_1_1_2' => [
									'type'  => 'group',
									'title' => 'Group 1_1_2',
									'desc'  => 'Описание group 1_1_2',
									'value' => [
										'icon' => [
											'type'  => 'text',
											'title' => 'Имя иконки',
											'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
											'value' => 'Иконка 1_1_2'
										],
										'number' => [
											'type'  => 'number',
											'title' => 'Число',
											'desc'  => 'Число которое будет анимироваться',
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
											'value' => ''
										],
										'select' => [
											'type'  => 'select',
											'title' => 'Опция SELECT ++',
											'desc'  => 'Описание опции',
											'value' => 'blue',
											'options' => [
												'red'   => 'Red',
												'green' => 'Green',
												'blue'  => 'Blue'
											]
										],
										'range' => [
											'type'  => 'range',
											'title' => 'Опция 7',
											'desc'  => 'Описание опции 7',
											'value' => '3',
											'options' => [
												'step' => 2,
												'min'  => 0,
												'max'  => 10
											]
										],
										'radio' => [
											'type'  => 'radio',
											'title' => 'Опция 8',
											'desc'  => 'Описание опции 8',
											'value' => 'green',
											'options' => [
												'red'   => 'Red',
												'green' => 'Green',
												'blue'  => 'Blue'
											]
										],
										'url' => [
											'type'     => 'url',
											'title'    => 'Опция 9',
											'desc'     => 'Описание опции 9',
											'value'    => 'https://bink.ru',
											'pattern'  => 'https://.*',
											'required' => true
										],
										'editor' => [
											'type'  => 'wp_editor',
											'title' => 'Опция 10',
											'desc'  => 'Описание опции 10',
											'value' => '<p>Lorem</p>',
											'options' => [
												'editor_class'     => 'editor-class',
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
										'media_2' => [
											'type'  => 'media_button',
											'title' => 'Опция 11',
											'desc'  => 'Описание опции 11',
											'value' => '',
											'options' => [
												'title'    => 'Insert a media',
												'library'  => [ 'type' => 'image' ],
												'multiple' => 0,
												'button'   => [ 'text' => 'Insert' ]
											]
										],
									]
								],
								'number' => [
									'type'  => 'number',
									'title' => 'Число',
									'desc'  => 'Число которое будет анимироваться',
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
									'value' => ''
								]
							]
						],
						'group_1_2' => [
							'type'  => 'group',
							'title' => 'Group 1_2',
							'desc'  => 'Описание group 1_2',
							'value' => [
								'option_g_1_2_1' => [
									'type'  => 'text',
									'title' => 'Option g_1_2_1',
									'desc'  => 'Описание option g_1_2_1',
									'value' => 'Значение по умолчанию option g_1_2_1'
								],
								'option_g_1_2_2' => [
									'type'  => 'textarea',
									'title' => 'Option g_1_2_2',
									'desc'  => 'Описание option g_1_2_2',
									'value' => 'Значение по умолчанию option g_1_2_2'
								],
								'option_g_1_2_3' => [
									'type'  => 'color',
									'title' => 'Option g_1_2_3',
									'desc'  => 'Описание option g_1_2_3',
									'value' => '#00cccc'
								],
								'option_g_1_2_4' => [
									'type'  => 'text',
									'title' => 'Option g_1_2_4',
									'desc'  => 'Описание option g_1_2_4',
									'value' => false
								],
								'option_g_1_2_5' => [
									'type'  => 'radio',
									'title' => 'Option g_1_2_5',
									'desc'  => 'Описание option g_1_2_5',
									'value' => 'no',
									'options' => [
										'no'  => false,
										'yes' => true
									]
								],
							]
						],
						'group_1_3' => [
							'type'  => 'group',
							'title' => 'Group 1_3',
							'desc'  => 'Описание group 1_3',
							'value' => [
								'option_g_1_3_1' => [
									'type'  => 'text',
									'title' => 'Option 1_3_1',
									'desc'  => 'Описание option 1_3_1',
									'value' => 'Значение по умолчанию option 1_3_1'
								],
								'option_g_1_3_2' => [
									'type'  => 'textarea',
									'title' => 'Option 1_3_2',
									'desc'  => 'Описание option 1_3_2',
									'value' => 'Значение по умолчанию option 1_3_2'
								],
								'option_g_1_3_3' => [
									'type'  => 'color',
									'title' => 'Group 1_3_3',
									'desc'  => 'Описание group 1_3_3',
									'value' => '#00cccc'
								],
							]
						],
						'option_g_1_4' => [
							'type'  => 'color',
							'title' => 'Option g_1_4',
							'desc'  => 'Описание option g_1_4',
							'value' => '#00cccc'
						],
						'option_g_1_5' => [
							'type'  => 'checkbox',
							'title' => 'Option g_1_5',
							'desc'  => 'Описание option g_1_5',
							'value' => [
								'green',
								'red'
							],
							'options' => [
								'red'   => 'Red',
								'green' => 'Green',
								'blue'  => 'Blue'
							]
						],
					]
				],



				'option_2' => [
					'type'  => 'textarea',
					'title' => 'Опция 2',
					'desc'  => 'Описание опции 2',
					'value' => 'Значение по умолчанию опции 2'
				],
				'option_3' => [
					'type'  => 'color',
					'title' => 'Опция 3',
					'desc'  => 'Описание опции 3',
					'value' => '#00cccc'
				],
				'option_4' => [
					'type'  => 'number',
					'title' => 'Опция 4',
					'desc'  => 'Описание опции 4',
					'value' => 5,
					'options' => [
						'step' => 2,
						'min'  => 0,
						'max'  => 10
					]
				],
				'option_5' => [
					'type'  => 'select',
					'title' => 'Опция 5',
					'desc'  => 'Описание опции 5',
					'value' => 'red',
					'options' => [
						'red'   => 'Red',
						'green' => 'Green',
						'blue'  => 'Blue'
					]
				],
				'option_6' => [
					'type'  => 'checkbox',
					'title' => 'Опция 6',
					'desc'  => 'Описание опции 6',
					'value' => [
						'green',
						'red'
					],
					'options' => [
						'red'   => 'Red',
						'green' => 'Green',
						'blue'  => 'Blue'
					]
				],
				'option_7' => [
					'type'  => 'range',
					'title' => 'Опция 7',
					'desc'  => 'Описание опции 7',
					'value' => '5',
					'options' => [
						'step' => 2,
						'min'  => 0,
						'max'  => 10
					]
				],
				'option_8' => [
					'type'  => 'radio',
					'title' => 'Опция 8',
					'desc'  => 'Описание опции 8',
					'value' => 'green',
					'options' => [
						'red'   => 'Red',
						'green' => 'Green',
						'blue'  => 'Blue'
					]
				],
				'option_9' => [
					'type'     => 'url',
					'title'    => 'Опция 9',
					'desc'     => 'Описание опции 9',
					'value'    => 'https://yandex.ru',
					'pattern'  => 'https://.*',
					'required' => true
				],
				'option_10' => [
					'type'  => 'wp_editor',
					'title' => 'Опция 10',
					'desc'  => 'Описание опции 10',
					'value' => '<h1>Title</h1>',
					'options' => [
						'editor_class'     => 'editor-class',
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
				'option_11' => [
					'type'  => 'media_button',
					'title' => 'Опция 11',
					'desc'  => 'Описание опции 11',
					'value' => '',
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'image' ],
						'multiple' => 0,
						'button'   => [ 'text' => 'Insert' ]
					]
				],
				'option_12' => [
					'type'  => 'media_button',
					'title' => 'Опция 12',
					'desc'  => 'Описание опции 12',
					'value' => '',
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'audio' ],
						'multiple' => 1,
						'button'   => [ 'text' => 'Insert' ]
					]
				],
				'option_13' => [
					'type'  => 'media_button',
					'title' => 'Опция 13',
					'desc'  => 'Описание опции 13',
					'value' => '',
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'video' ],
						'multiple' => 1,
						'button'   => [ 'text' => 'Insert' ]
					]
				],
			],
		],
		'services' => [
			'fields' => [
				'icon' => [
					'type'  => 'text',
					'title' => 'Имя иконки',
					'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
					'value' => ''
				],
			],
		],
		'features' => [
			'fields' => [
				'icon' => [
					'type'  => 'text',
					'title' => 'Имя иконки',
					'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
					'value' => ''
				],
				'label' => [
					'type'  => 'text',
					'title' => 'Лейбл',
					'desc'  => 'Название табуляции',
					'value' => ''
				],
			],
		],
		'about' => [
			'fields' => [
				'option_1' => [
					'type'  => 'text',
					'title' => 'Опция 1',
					'desc'  => 'Описание опции 1',
					'value' => 'Значение по умолчанию опции 1'
				],
				'option_2' => [
					'type'  => 'textarea',
					'title' => 'Опция 2',
					'desc'  => 'Описание опции 2',
					'value' => 'Значение по умолчанию опции 2'
				],
			],
		],
		'facts' => [
			'fields' => [
				'group_1' => [
					'type'  => 'group',
					'title' => 'Group 1',
					'desc'  => 'Описание group 1',
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
				'group_2' => [
					'type'  => 'group',
					'title' => 'Group 1',
					'desc'  => 'Описание group 1',
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
				'group_3' => [
					'type'  => 'group',
					'title' => 'Group 1',
					'desc'  => 'Описание group 1',
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
				'group_4' => [
					'type'  => 'group',
					'title' => 'Group 1',
					'desc'  => 'Описание group 1',
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
				]
			]
		],
	],
];
