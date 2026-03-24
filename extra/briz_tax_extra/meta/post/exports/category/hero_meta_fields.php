<?php
/**
 * Мета поля записей термина "hero".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */

defined( 'ABSPATH' ) || exit;

$hero_meta_fields = [
	[
		'title'  => 'Позиция контента',
		'fields' => [
			'screen' => [
				'type'    => 'select',
				'title'   => 'Позиция контента',
				'desc'    => 'Тип позиционирования контента слайда',
				'value'   => 'right',
				'options' => [
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				]
			],
		]
	],
	[
		'title'  => 'Изображение контента',
		'fields' => [
			'content_image' => [
				'type'  => 'group',
				'title' => 'Параметры изображения контента',
				'desc'  => 'Параметры изображения контента',
				'color' => 'skyblue',
				'value' => [
					'image' => [
						'type'    => 'media_button',
						'title'   => 'Изображение контента',
						'desc'    => 'Изображение записи контента (только для "Позиция контента = right")',
						'value'   => '',
						'options' => [
							'title'    => 'Выбрать изображение',
							'library'  => [ 'type' => 'image' ],
							'multiple' => false,
							'button'   => [ 'text' => 'Insert' ]
						]
					],
					'animation' => [
						'type'  => 'select',
						'title' => 'Анимация появления изображения',
						'desc'  => 'Выберите анимацию',
						'value'   => 'fadeInUpBig',
						'options' => [
							'bounce' => 'bounce',
							'flash' => 'flash',
							'pulse' => 'pulse',
							'rubberBand' => 'rubberBand',
							'shake' => 'shake',
							'swing' => 'swing',
							'tada' => 'tada',
							'wobble' => 'wobble',
							'bounceIn' => 'bounceIn',
							'bounceInDown' => 'bounceInDown',
							'bounceInLeft' => 'bounceInLeft',
							'bounceInRight' => 'bounceInRight',
							'bounceInUp' => 'bounceInUp',
							'bounceOut' => 'bounceOut',
							'bounceOutDown' => 'bounceOutDown',
							'bounceOutLeft' => 'bounceOutLeft',
							'bounceOutRight' => 'bounceOutRight',
							'bounceOutUp' => 'bounceOutUp',
							'fadeIn' => 'fadeIn',
							'fadeInDown' => 'fadeInDown',
							'fadeInDownBig' => 'fadeInDownBig',
							'fadeInLeft' => 'fadeInLeft',
							'fadeInLeftBig' => 'fadeInLeftBig',
							'fadeInRight' => 'fadeInRight',
							'fadeInRightBig' => 'fadeInRightBig',
							'fadeInUp' => 'fadeInUp',
							'fadeInUpBig' => 'fadeInUpBig',
							'fadeOut' => 'fadeOut',
							'fadeOutDown' => 'fadeOutDown',
							'fadeOutDownBig' => 'fadeOutDownBig',
							'fadeOutLeft' => 'fadeOutLeft',
							'fadeOutLeftBig' => 'fadeOutLeftBig',
							'fadeOutRight' => 'fadeOutRight',
							'fadeOutRightBig' => 'fadeOutRightBig',
							'fadeOutUp' => 'fadeOutUp',
							'fadeOutUpBig' => 'fadeOutUpBig',
							'flip' => 'flip',
							'flipInX' => 'flipInX',
							'flipInY' => 'flipInY',
							'flipOutX' => 'flipOutX',
							'flipOutY' => 'flipOutY',
							'lightSpeedIn' => 'lightSpeedIn',
							'lightSpeedOut' => 'lightSpeedOut',
							'rotateIn' => 'rotateIn',
							'rotateInDownLeft' => 'rotateInDownLeft',
							'rotateInDownRight' => 'rotateInDownRight',
							'rotateInUpLeft' => 'rotateInUpLeft',
							'rotateInUpRight' => 'rotateInUpRight',
							'rotateOut' => 'rotateOut',
							'rotateOutDownLeft' => 'rotateOutDownLeft',
							'rotateOutDownRight' => 'rotateOutDownRight',
							'rotateOutUpLeft' => 'rotateOutUpLeft',
							'rotateOutUpRight' => 'rotateOutUpRight',
							'hinge' => 'hinge',
							'rollIn' => 'rollIn',
							'rollOut' => 'rollOut',
							'zoomIn' => 'zoomIn',
							'zoomInDown' => 'zoomInDown',
							'zoomInLeft' => 'zoomInLeft',
							'zoomInRight' => 'zoomInRight',
							'zoomInUp' => 'zoomInUp',
							'zoomOut' => 'zoomOut',
							'zoomOutDown' => 'zoomOutDown',
							'zoomOutLeft' => 'zoomOutLeft',
							'zoomOutRight' => 'zoomOutRight',
							'zoomOutUp' => 'zoomOutUp',
							'slideInDown' => 'slideInDown',
							'slideInLeft' => 'slideInLeft',
							'slideInRight' => 'slideInRight',
							'slideInUp' => 'slideInUp',
							'slideOutDown' => 'slideOutDown',
							'slideOutLeft' => 'slideOutLeft',
							'slideOutRight' => 'slideOutRight',
							'slideOutUp' => 'slideOutUp',
						]
					],
					'delay' => [
						'type'  => 'number',
						'title' => 'Задержка анимации',
						'desc'  => 'Задержка анимации',
						'value' => 0,
						'options' => [
							'step' => 0.01,
							'min'  => 0,
							'max'  => ''
						]
					],
					'duration' => [
						'type'  => 'number',
						'title' => 'Длительность анимации',
						'desc'  => 'Длительность анимации',
						'value' => 0,
						'options' => [
							'step' => 0.01,
							'min'  => 0,
							'max'  => ''
						]
					],
				]
			],
		]
	],
	[
		'title'  => 'Текст контента',
		'fields' => [
			'content' => [
				'type'  => 'wp_editor',
				'title' => 'Контент слайда',
				'desc'  => 'Контент слайда',
				'value' => '<p>Вставить HTML</p>',
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
		]
	],
	[
		'title'  => 'Свободные изображения',
		'fields' => [
			'free_images' => [
				'type'  => 'group',
				'title' => 'Свободно позиционируемые изображения',
				'desc'  => 'Свободно позиционируемые изображения',
				'color' => 'green',
				'value' => [
					'pencil_1' => [
						'type'  => 'group',
						'title' => 'Pencil 1',
						'desc'  => 'Свободно позиционируемое изображение',
						'color' => 'yellow',
						'value' => [
							'image' => [
								'type'    => 'media_button',
								'title'   => 'Изображение',
								'desc'    => 'Изображение',
								'value'   => '',
								'options' => [
									'title'    => 'Выбрать изображение',
									'library'  => [ 'type' => 'image' ],
									'multiple' => false,
									'button'   => [ 'text' => 'Insert' ]
								]
							],
							'unit' => [
								'type'    => 'select',
								'title'   => 'Единица измерения',
								'desc'    => 'Единица измерения',
								'value'   => '%',
								'options' => [
									'%' => '%',
									'px'      => 'px',
								]
							],
							'width' => [
								'type'  => 'number',
								'title' => 'Ширина',
								'desc'  => 'Ширина изображения',
								'value' => 10,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'height' => [
								'type'  => 'number',
								'title' => 'Высота',
								'desc'  => 'Высота изображения',
								'value' => 37,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'top' => [
								'type'  => 'number',
								'title' => 'Позиция по вертикали',
								'desc'  => 'Позиция по вертикали',
								'value' => 61,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'left' => [
								'type'  => 'number',
								'title' => 'Позиция по горизонтали',
								'desc'  => 'Позиция по горизонтали',
								'value' => 1,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'animation' => [
								'type'  => 'select',
								'title' => 'Анимация появления изображения',
								'desc'  => 'Выберите анимацию',
								'value'   => 'fadeInUpBig',
								'options' => [
									'bounce' => 'bounce',
									'flash' => 'flash',
									'pulse' => 'pulse',
									'rubberBand' => 'rubberBand',
									'shake' => 'shake',
									'swing' => 'swing',
									'tada' => 'tada',
									'wobble' => 'wobble',
									'bounceIn' => 'bounceIn',
									'bounceInDown' => 'bounceInDown',
									'bounceInLeft' => 'bounceInLeft',
									'bounceInRight' => 'bounceInRight',
									'bounceInUp' => 'bounceInUp',
									'bounceOut' => 'bounceOut',
									'bounceOutDown' => 'bounceOutDown',
									'bounceOutLeft' => 'bounceOutLeft',
									'bounceOutRight' => 'bounceOutRight',
									'bounceOutUp' => 'bounceOutUp',
									'fadeIn' => 'fadeIn',
									'fadeInDown' => 'fadeInDown',
									'fadeInDownBig' => 'fadeInDownBig',
									'fadeInLeft' => 'fadeInLeft',
									'fadeInLeftBig' => 'fadeInLeftBig',
									'fadeInRight' => 'fadeInRight',
									'fadeInRightBig' => 'fadeInRightBig',
									'fadeInUp' => 'fadeInUp',
									'fadeInUpBig' => 'fadeInUpBig',
									'fadeOut' => 'fadeOut',
									'fadeOutDown' => 'fadeOutDown',
									'fadeOutDownBig' => 'fadeOutDownBig',
									'fadeOutLeft' => 'fadeOutLeft',
									'fadeOutLeftBig' => 'fadeOutLeftBig',
									'fadeOutRight' => 'fadeOutRight',
									'fadeOutRightBig' => 'fadeOutRightBig',
									'fadeOutUp' => 'fadeOutUp',
									'fadeOutUpBig' => 'fadeOutUpBig',
									'flip' => 'flip',
									'flipInX' => 'flipInX',
									'flipInY' => 'flipInY',
									'flipOutX' => 'flipOutX',
									'flipOutY' => 'flipOutY',
									'lightSpeedIn' => 'lightSpeedIn',
									'lightSpeedOut' => 'lightSpeedOut',
									'rotateIn' => 'rotateIn',
									'rotateInDownLeft' => 'rotateInDownLeft',
									'rotateInDownRight' => 'rotateInDownRight',
									'rotateInUpLeft' => 'rotateInUpLeft',
									'rotateInUpRight' => 'rotateInUpRight',
									'rotateOut' => 'rotateOut',
									'rotateOutDownLeft' => 'rotateOutDownLeft',
									'rotateOutDownRight' => 'rotateOutDownRight',
									'rotateOutUpLeft' => 'rotateOutUpLeft',
									'rotateOutUpRight' => 'rotateOutUpRight',
									'hinge' => 'hinge',
									'rollIn' => 'rollIn',
									'rollOut' => 'rollOut',
									'zoomIn' => 'zoomIn',
									'zoomInDown' => 'zoomInDown',
									'zoomInLeft' => 'zoomInLeft',
									'zoomInRight' => 'zoomInRight',
									'zoomInUp' => 'zoomInUp',
									'zoomOut' => 'zoomOut',
									'zoomOutDown' => 'zoomOutDown',
									'zoomOutLeft' => 'zoomOutLeft',
									'zoomOutRight' => 'zoomOutRight',
									'zoomOutUp' => 'zoomOutUp',
									'slideInDown' => 'slideInDown',
									'slideInLeft' => 'slideInLeft',
									'slideInRight' => 'slideInRight',
									'slideInUp' => 'slideInUp',
									'slideOutDown' => 'slideOutDown',
									'slideOutLeft' => 'slideOutLeft',
									'slideOutRight' => 'slideOutRight',
									'slideOutUp' => 'slideOutUp',
								]
							],
							'delay' => [
								'type'  => 'number',
								'title' => 'Задержка анимации',
								'desc'  => 'Задержка анимации',
								'value' => 1.8,
								'options' => [
									'step' => 0.01,
									'min'  => 0,
									'max'  => ''
								]
							],
							'duration' => [
								'type'  => 'number',
								'title' => 'Длительность анимации',
								'desc'  => 'Длительность анимации',
								'value' => 1.2,
								'options' => [
									'step' => 0.01,
									'min'  => 0,
									'max'  => ''
								]
							],
						]
					],

					'pencil_2' => [
						'type'  => 'group',
						'title' => 'Pencil 2',
						'desc'  => 'Свободно позиционируемое изображение',
						'color' => 'red',
						'value' => [
							'image' => [
								'type'    => 'media_button',
								'title'   => 'Изображение',
								'desc'    => 'Изображение',
								'value'   => '',
								'options' => [
									'title'    => 'Выбрать изображение',
									'library'  => [ 'type' => 'image' ],
									'multiple' => false,
									'button'   => [ 'text' => 'Insert' ]
								]
							],
							'unit' => [
								'type'    => 'select',
								'title'   => 'Единица измерения',
								'desc'    => 'Единица измерения',
								'value'   => '%',
								'options' => [
									'%' => '%',
									'px'      => 'px',
								]
							],
							'width' => [
								'type'  => 'number',
								'title' => 'Ширина',
								'desc'  => 'Ширина изображения',
								'value' => 10,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'height' => [
								'type'  => 'number',
								'title' => 'Высота',
								'desc'  => 'Высота изображения',
								'value' => 37,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'top' => [
								'type'  => 'number',
								'title' => 'Позиция по вертикали',
								'desc'  => 'Позиция по вертикали',
								'value' => 50,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'left' => [
								'type'  => 'number',
								'title' => 'Позиция по горизонтали',
								'desc'  => 'Позиция по горизонтали',
								'value' => 3,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'animation' => [
								'type'  => 'select',
								'title' => 'Анимация появления изображения',
								'desc'  => 'Выберите анимацию',
								'value'   => 'fadeInUpBig',
								'options' => [
									'bounce' => 'bounce',
									'flash' => 'flash',
									'pulse' => 'pulse',
									'rubberBand' => 'rubberBand',
									'shake' => 'shake',
									'swing' => 'swing',
									'tada' => 'tada',
									'wobble' => 'wobble',
									'bounceIn' => 'bounceIn',
									'bounceInDown' => 'bounceInDown',
									'bounceInLeft' => 'bounceInLeft',
									'bounceInRight' => 'bounceInRight',
									'bounceInUp' => 'bounceInUp',
									'bounceOut' => 'bounceOut',
									'bounceOutDown' => 'bounceOutDown',
									'bounceOutLeft' => 'bounceOutLeft',
									'bounceOutRight' => 'bounceOutRight',
									'bounceOutUp' => 'bounceOutUp',
									'fadeIn' => 'fadeIn',
									'fadeInDown' => 'fadeInDown',
									'fadeInDownBig' => 'fadeInDownBig',
									'fadeInLeft' => 'fadeInLeft',
									'fadeInLeftBig' => 'fadeInLeftBig',
									'fadeInRight' => 'fadeInRight',
									'fadeInRightBig' => 'fadeInRightBig',
									'fadeInUp' => 'fadeInUp',
									'fadeInUpBig' => 'fadeInUpBig',
									'fadeOut' => 'fadeOut',
									'fadeOutDown' => 'fadeOutDown',
									'fadeOutDownBig' => 'fadeOutDownBig',
									'fadeOutLeft' => 'fadeOutLeft',
									'fadeOutLeftBig' => 'fadeOutLeftBig',
									'fadeOutRight' => 'fadeOutRight',
									'fadeOutRightBig' => 'fadeOutRightBig',
									'fadeOutUp' => 'fadeOutUp',
									'fadeOutUpBig' => 'fadeOutUpBig',
									'flip' => 'flip',
									'flipInX' => 'flipInX',
									'flipInY' => 'flipInY',
									'flipOutX' => 'flipOutX',
									'flipOutY' => 'flipOutY',
									'lightSpeedIn' => 'lightSpeedIn',
									'lightSpeedOut' => 'lightSpeedOut',
									'rotateIn' => 'rotateIn',
									'rotateInDownLeft' => 'rotateInDownLeft',
									'rotateInDownRight' => 'rotateInDownRight',
									'rotateInUpLeft' => 'rotateInUpLeft',
									'rotateInUpRight' => 'rotateInUpRight',
									'rotateOut' => 'rotateOut',
									'rotateOutDownLeft' => 'rotateOutDownLeft',
									'rotateOutDownRight' => 'rotateOutDownRight',
									'rotateOutUpLeft' => 'rotateOutUpLeft',
									'rotateOutUpRight' => 'rotateOutUpRight',
									'hinge' => 'hinge',
									'rollIn' => 'rollIn',
									'rollOut' => 'rollOut',
									'zoomIn' => 'zoomIn',
									'zoomInDown' => 'zoomInDown',
									'zoomInLeft' => 'zoomInLeft',
									'zoomInRight' => 'zoomInRight',
									'zoomInUp' => 'zoomInUp',
									'zoomOut' => 'zoomOut',
									'zoomOutDown' => 'zoomOutDown',
									'zoomOutLeft' => 'zoomOutLeft',
									'zoomOutRight' => 'zoomOutRight',
									'zoomOutUp' => 'zoomOutUp',
									'slideInDown' => 'slideInDown',
									'slideInLeft' => 'slideInLeft',
									'slideInRight' => 'slideInRight',
									'slideInUp' => 'slideInUp',
									'slideOutDown' => 'slideOutDown',
									'slideOutLeft' => 'slideOutLeft',
									'slideOutRight' => 'slideOutRight',
									'slideOutUp' => 'slideOutUp',
								]
							],
							'delay' => [
								'type'  => 'number',
								'title' => 'Задержка анимации',
								'desc'  => 'Задержка анимации',
								'value' => 1.5,
								'options' => [
									'step' => 0.01,
									'min'  => 0,
									'max'  => ''
								]
							],
							'duration' => [
								'type'  => 'number',
								'title' => 'Длительность анимации',
								'desc'  => 'Длительность анимации',
								'value' => 1.2,
								'options' => [
									'step' => 0.01,
									'min'  => 0,
									'max'  => ''
								]
							],
						]
					],

					'mouse' => [
						'type'  => 'group',
						'title' => 'Mouse',
						'desc'  => 'Свободно позиционируемое изображение',
						'color' => 'pink',
						'value' => [
							'image' => [
								'type'    => 'media_button',
								'title'   => 'Изображение',
								'desc'    => 'Изображение',
								'value'   => '',
								'options' => [
									'title'    => 'Выбрать изображение',
									'library'  => [ 'type' => 'image' ],
									'multiple' => false,
									'button'   => [ 'text' => 'Insert' ]
								]
							],
							'unit' => [
								'type'    => 'select',
								'title'   => 'Единица измерения',
								'desc'    => 'Единица измерения',
								'value'   => '%',
								'options' => [
									'%' => '%',
									'px'      => 'px',
								]
							],
							'width' => [
								'type'  => 'number',
								'title' => 'Ширина',
								'desc'  => 'Ширина изображения',
								'value' => 10,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'height' => [
								'type'  => 'number',
								'title' => 'Высота',
								'desc'  => 'Высота изображения',
								'value' => 37,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'top' => [
								'type'  => 'number',
								'title' => 'Позиция по вертикали',
								'desc'  => 'Позиция по вертикали',
								'value' => 68,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'left' => [
								'type'  => 'number',
								'title' => 'Позиция по горизонтали',
								'desc'  => 'Позиция по горизонтали',
								'value' => 88,
								'options' => [
									'step' => 1,
									'min'  => 0,
									'max'  => ''
								]
							],
							'animation' => [
								'type'  => 'select',
								'title' => 'Анимация появления изображения',
								'desc'  => 'Выберите анимацию',
								'value'   => 'fadeInUpBig',
								'options' => [
									'bounce' => 'bounce',
									'flash' => 'flash',
									'pulse' => 'pulse',
									'rubberBand' => 'rubberBand',
									'shake' => 'shake',
									'swing' => 'swing',
									'tada' => 'tada',
									'wobble' => 'wobble',
									'bounceIn' => 'bounceIn',
									'bounceInDown' => 'bounceInDown',
									'bounceInLeft' => 'bounceInLeft',
									'bounceInRight' => 'bounceInRight',
									'bounceInUp' => 'bounceInUp',
									'bounceOut' => 'bounceOut',
									'bounceOutDown' => 'bounceOutDown',
									'bounceOutLeft' => 'bounceOutLeft',
									'bounceOutRight' => 'bounceOutRight',
									'bounceOutUp' => 'bounceOutUp',
									'fadeIn' => 'fadeIn',
									'fadeInDown' => 'fadeInDown',
									'fadeInDownBig' => 'fadeInDownBig',
									'fadeInLeft' => 'fadeInLeft',
									'fadeInLeftBig' => 'fadeInLeftBig',
									'fadeInRight' => 'fadeInRight',
									'fadeInRightBig' => 'fadeInRightBig',
									'fadeInUp' => 'fadeInUp',
									'fadeInUpBig' => 'fadeInUpBig',
									'fadeOut' => 'fadeOut',
									'fadeOutDown' => 'fadeOutDown',
									'fadeOutDownBig' => 'fadeOutDownBig',
									'fadeOutLeft' => 'fadeOutLeft',
									'fadeOutLeftBig' => 'fadeOutLeftBig',
									'fadeOutRight' => 'fadeOutRight',
									'fadeOutRightBig' => 'fadeOutRightBig',
									'fadeOutUp' => 'fadeOutUp',
									'fadeOutUpBig' => 'fadeOutUpBig',
									'flip' => 'flip',
									'flipInX' => 'flipInX',
									'flipInY' => 'flipInY',
									'flipOutX' => 'flipOutX',
									'flipOutY' => 'flipOutY',
									'lightSpeedIn' => 'lightSpeedIn',
									'lightSpeedOut' => 'lightSpeedOut',
									'rotateIn' => 'rotateIn',
									'rotateInDownLeft' => 'rotateInDownLeft',
									'rotateInDownRight' => 'rotateInDownRight',
									'rotateInUpLeft' => 'rotateInUpLeft',
									'rotateInUpRight' => 'rotateInUpRight',
									'rotateOut' => 'rotateOut',
									'rotateOutDownLeft' => 'rotateOutDownLeft',
									'rotateOutDownRight' => 'rotateOutDownRight',
									'rotateOutUpLeft' => 'rotateOutUpLeft',
									'rotateOutUpRight' => 'rotateOutUpRight',
									'hinge' => 'hinge',
									'rollIn' => 'rollIn',
									'rollOut' => 'rollOut',
									'zoomIn' => 'zoomIn',
									'zoomInDown' => 'zoomInDown',
									'zoomInLeft' => 'zoomInLeft',
									'zoomInRight' => 'zoomInRight',
									'zoomInUp' => 'zoomInUp',
									'zoomOut' => 'zoomOut',
									'zoomOutDown' => 'zoomOutDown',
									'zoomOutLeft' => 'zoomOutLeft',
									'zoomOutRight' => 'zoomOutRight',
									'zoomOutUp' => 'zoomOutUp',
									'slideInDown' => 'slideInDown',
									'slideInLeft' => 'slideInLeft',
									'slideInRight' => 'slideInRight',
									'slideInUp' => 'slideInUp',
									'slideOutDown' => 'slideOutDown',
									'slideOutLeft' => 'slideOutLeft',
									'slideOutRight' => 'slideOutRight',
									'slideOutUp' => 'slideOutUp',
								]
							],
							'delay' => [
								'type'  => 'number',
								'title' => 'Задержка анимации',
								'desc'  => 'Задержка анимации',
								'value' => 1.9,
								'options' => [
									'step' => 0.01,
									'min'  => 0,
									'max'  => ''
								]
							],
							'duration' => [
								'type'  => 'number',
								'title' => 'Длительность анимации',
								'desc'  => 'Длительность анимации',
								'value' => 1.3,
								'options' => [
									'step' => 0.01,
									'min'  => 0,
									'max'  => ''
								]
							],
						]
					],
				]
			],
		]
	],
];
