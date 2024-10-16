<?php
/**
 * Мета поля термина "team".
 */
$team_meta_fields = [
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
			'value' => 'Our'
		],
		'header_last' => [
			'type'  => 'text',
			'title' => 'Заголовок секции вторая часть',
			'desc'  => 'Вторая часть заголовка секции.',
			'empty' => true,
			'value' => 'team'
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
			'value' => '[857]',
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
		'slider_params' => [
			'type'  => 'group',
			'title' => 'Slider params',
			'desc'  => 'Параметры слайдера',
			'color' => '#88f',
			'value' => [
				'slidesPerView' => [
					'type'  => 'number',
					'title' => 'Количество слайдов',
					'desc'  => 'Количество видимых слайдов.',
					'value' => 1,
					'options' => [
						'step' => 1,
						'min'  => 1,
						'max'  => ''
					]
				],

				'spaceBetween' => [
					'type'  => 'number',
					'title' => 'Space between',
					'desc'  => 'Промежуток между слайдерами в px',
					'value' => 30,
					'empty' => true,
					'options' => [
						'step' => 1,
						'min'  => '0',
						'max'  => ''
					]
				],

				'speed' => [
					'type'  => 'number',
					'title' => 'Скорость анимации',
					'desc'  => 'Скорость анимации прокрутки слайдера.',
					'value' => 200,
					'options' => [
						'step' => 50,
						'min'  => 0,
						'max'  => ''
					]
				],

				// 'autoplay' => [
				// 	'type'  => 'number',
				// 	'title' => 'Автопрокрутка',
				// 	'desc'  => 'Количество милисекунд до начала автопрокрутки. 0 - выкл.',
				// 	'value' => '0',
				// 	'options' => [
				// 		'step' => 1,
				// 		'min'  => '0',
				// 		'max'  => ''
				// 	]
				// ],

				'autoplay' => [
					'type' => 'checkbox',
					'title' => 'Autoplay',
					'desc'  => 'Авто прокрутка',
					'empty' => true,
					'value' => [],
					'options' => [
						'on'  => 'On'
					]
				],

				'autoplay_delay' => [
					'type'  => 'number',
					'title' => 'Задержка',
					'desc'  => 'Количество милисекунд до начала автопрокрутки. default( 2000 )',
					'value' => '5000',
					'options' => [
						'step' => 10,
						'min'  => '0',
						'max'  => ''
					]
				],

				'loop' => [
					'type'  => 'checkbox',
					'title' => 'Loop?',
					'desc'  => 'Слайды будут прокручиваться по кругу.',
					'empty' => true,
					'value' => '',
					'options' => [
						'on'  => 'On'
					]
				],

				'breakpoints' => [
					'type'  => 'group',
					'title' => 'Breackpoints',
					'desc'  => 'Параметры слайдера',
					'color' => '#8ff',
					'value' => [
						'250' => [
							'type'  => 'group',
							'title' => '250',
							'desc'  => 'Параметры 250',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 250px',
									'value' => 1,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 250px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],

						'320' => [
							'type'  => 'group',
							'title' => '320',
							'desc'  => 'Параметры 320',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 320px',
									'value' => 1,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 320px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],

						'480' => [
							'type'  => 'group',
							'title' => '480',
							'desc'  => 'Параметры 480',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 480px',
									'value' => 2,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 480px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],

						'568' => [
							'type'  => 'group',
							'title' => '568',
							'desc'  => 'Параметры 568',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 568px',
									'value' => 2,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 568px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],

						'640' => [
							'type'  => 'group',
							'title' => '640',
							'desc'  => 'Параметры 640',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 640px',
									'value' => 2,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 640px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],

						'768' => [
							'type'  => 'group',
							'title' => '768',
							'desc'  => 'Параметры 768',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 768px',
									'value' => 2,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 768px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],

						'992' => [
							'type'  => 'group',
							'title' => '992',
							'desc'  => 'Параметры 992',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 992px',
									'value' => 3,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 992px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],

						'1200' => [
							'type'  => 'group',
							'title' => '1200',
							'desc'  => 'Параметры 1200',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 1200px',
									'value' => 3,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => 1,
										'max'  => ''
									]
								],
								'spaceBetween' => [
									'type'  => 'number',
									'title' => 'Space between',
									'desc'  => 'Промежуток между слайдерами в px при разрешении 1200px',
									'value' => 30,
									'empty' => true,
									'options' => [
										'step' => 1,
										'min'  => '0',
										'max'  => ''
									]
								],
							]
						],
					]
				]
			]
		]
	]
];
