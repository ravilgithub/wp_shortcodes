<?php
/**
 * Мета поля термина "review".
 */
$review_meta_fields = [
	'fields' => [
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
					'value' => 2,
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

				'autoplay' => [
					'type'  => 'number',
					'title' => 'Автопрокрутка',
					'desc'  => 'Количество милисекунд до начала автопрокрутки. 0 - выкл.',
					'value' => '0',
					'options' => [
						'step' => 1,
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

						'567' => [
							'type'  => 'group',
							'title' => '567',
							'desc'  => 'Параметры 567',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 567px',
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
									'desc'  => 'Промежуток между слайдерами в px при разрешении 567px',
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

						'991' => [
							'type'  => 'group',
							'title' => '991',
							'desc'  => 'Параметры 991',
							// 'color' => '#0ff',
							'value' => [
								'slidesPerView' => [
									'type'  => 'number',
									'title' => 'Slider per view',
									'desc'  => 'Количество видимых слайдов при разрешении 991px',
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
									'desc'  => 'Промежуток между слайдерами в px при разрешении 991px',
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
