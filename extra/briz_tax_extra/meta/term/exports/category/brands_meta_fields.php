<?php
/**
 * Мета поля термина "brands".
 */
$brands_meta_fields = [
	'fields' => [
		'slider_params' => [
			'type'  => 'group',
			'title' => 'Slider params',
			'desc'  => 'Параметры слайдера',
			'color' => '#88f',
			'value' => [

				/* BEGIN для тестов */

				/*'option_11' => [
					'type'  => 'image',
					'title' => 'Опция 11',
					'desc'  => 'Описание опции 11',
					'value' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAABjElEQVRoge2bWQ6DMAxEe/+z+RAICQ7Bz/SjStWFkM02IcNISFEJ9rwKhawPEcGyLBSXiOARCqNLRLCu6ws4/DCqAtsX8OeNkfTJ9Af8W+Hq+mXZBd6reEXtMUSBYw9cRTHvh8BHD/asI89J4FSA3pTymgWcE6gH5XjMBs4NeJZyvRUBlwT2VImnYuDSBNYq9VIFXJPIQjUeqoFrE2qpNncTcEviFrXkbAZuNeCdSwVYw4hXDjVgwBZaK7YqMGADrRlTHRjQNaj9B5oAAzpGLd4WM2CgzbBVe2AKDNQZt2z8zIGBMgDrz5sLMJAH4vEtdwMGjoG8emuuwMA+mGfX1B0Y+Ab0HnycAgy8QM8Yad3AHqJ6pakaLarPElXHg6prSTV4oBoeUk0AUE3xUE3iUU3TUk3EUy21UC2mUS2XUi2I9wAbZL7loSfYILNNLT3CBqlvW+oZNmiapmSde+thaYAeNc9z9N6w24dj0PcG8VjFqyp5BGAk2KBt295l3mM8I8MGvQ9qhQLDJSJ4AsaVfzhlR3kRAAAAAElFTkSuQmCC'
				],
				'option_11_2' => [
					'type'  => 'image',
					'title' => 'Опция 11_2',
					'desc'  => 'Описание опции 11_2',
					'value' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAABjElEQVRoge2bWQ6DMAxEe/+z+RAICQ7Bz/SjStWFkM02IcNISFEJ9rwKhawPEcGyLBSXiOARCqNLRLCu6ws4/DCqAtsX8OeNkfTJ9Af8W+Hq+mXZBd6reEXtMUSBYw9cRTHvh8BHD/asI89J4FSA3pTymgWcE6gH5XjMBs4NeJZyvRUBlwT2VImnYuDSBNYq9VIFXJPIQjUeqoFrE2qpNncTcEviFrXkbAZuNeCdSwVYw4hXDjVgwBZaK7YqMGADrRlTHRjQNaj9B5oAAzpGLd4WM2CgzbBVe2AKDNQZt2z8zIGBMgDrz5sLMJAH4vEtdwMGjoG8emuuwMA+mGfX1B0Y+Ab0HnycAgy8QM8Yad3AHqJ6pakaLarPElXHg6prSTV4oBoeUk0AUE3xUE3iUU3TUk3EUy21UC2mUS2XUi2I9wAbZL7loSfYILNNLT3CBqlvW+oZNmiapmSde+thaYAeNc9z9N6w24dj0PcG8VjFqyp5BGAk2KBt295l3mM8I8MGvQ9qhQLDJSJ4AsaVfzhlR3kRAAAAAElFTkSuQmCC'
				],*/
				'icon' => [
					'type'  => 'text',
					'title' => 'Имя иконки',
					'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
					// 'empty' => true,
					'value' => ''
				],
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

				'slidesPerView' => [
					'type'  => 'number',
					'title' => 'Количество слайдов',
					'desc'  => 'Количество видимых слайдов.',
					'value' => 6,
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
					'value' => 600,
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
					'value' => 5000,
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
					'value' => [ 'on' ],
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
									'value' => 4,
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
									'value' => 4,
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
									'value' => 4,
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
