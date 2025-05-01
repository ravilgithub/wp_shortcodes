<?php
/**
 * Мета поля записей термина "hero".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */
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
			'image' => [
				'type'    => 'media_button',
				'title'   => 'Позиция контента',
				'desc'    => 'Тип позиционирования контента слайда',
				'value'   => '',
				'options' => [
					'title'    => 'Выбрать изображение',
					'library'  => [ 'type' => 'image' ],
					'multiple' => 0,
					'button'   => [ 'text' => 'Insert' ]
				]
			],
		]
	],
	[
		'title'  => 'Изображение контента',
		'fields' => [
			'editor' => [
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
		'title'  => 'Свободный элемент',
		'fields' => [
			'free' => [
				'type'  => 'group',
				'title' => 'Свободно позиционируемый элемент',
				'desc'  => 'Свободно позиционируемый элемент',
				'color' => 'yellow',
				'value' => [
					'image' => [
						'type'    => 'media_button',
						'title'   => 'Изображение элемента',
						'desc'    => 'Изображение элемента',
						'value'   => '',
						'options' => [
							'title'    => 'Выбрать изображение',
							'library'  => [ 'type' => 'image' ],
							'multiple' => 0,
							'button'   => [ 'text' => 'Insert' ]
						]
					],
					'width' => [
						'type'  => 'number',
						'title' => 'Ширина',
						'desc'  => 'Ширина элемента',
						'value' => 50,
						'options' => [
							'step' => 10,
							'min'  => 0,
							'max'  => ''
						]
					],
					'height' => [
						'type'  => 'number',
						'title' => 'Высота',
						'desc'  => 'Высота элемента',
						'value' => 50,
						'options' => [
							'step' => 10,
							'min'  => 0,
							'max'  => ''
						]
					],
					'top' => [
						'type'  => 'number',
						'title' => 'Позиция по вертикали',
						'desc'  => 'Позиция по вертикали',
						'value' => 0,
						'options' => [
							'step' => 10,
							'min'  => 0,
							'max'  => ''
						]
					],
					'left' => [
						'type'  => 'number',
						'title' => 'Позиция по горизонтали',
						'desc'  => 'Позиция по горизонтали',
						'value' => 0,
						'options' => [
							'step' => 10,
							'min'  => 0,
							'max'  => ''
						]
					],
					'animation' => [
						'type'  => 'select',
						'title' => 'Анимация',
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
				],
			]
		]
	],
];
