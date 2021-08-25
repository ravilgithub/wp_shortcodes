<?php
/**
 * Array of parameters for creating meta fields for taxonomy terms.
 *
 * Массив параметров для создания мета полей терминов таксономии.
 *
 * @see ~/extra/briz_tax_extra/meta/term_meta_opts.php
 *      Term_Meta_Opts::__construct()
 *
 * @var Array $opts {
 *  @type Array $taxonomy_name {
 *   @type Array $option_name {
 *    @type String $type        - Тип мета поля.
 *                                Required.
 *    @type String $title       - Название мета поля.
 *    @type String $desc        - Описание мета поля.
 *    @type String/Array $value - Значение мета поля по умолчанию.
 *                                Required.
 *                                Default: ''
 *    @type Array $options      - Параметры мета поля.
 *   }
 *  }
 * }
 *
 */

$opts = [
	'category' => [
		'option_12' => [
			'type'  => 'media_button',
			'title' => 'Опция 12',
			'desc'  => 'Описание опции 12',
			'value' => '[378,377,291,289,292]',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => 1,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'option_12_1' => [
			'type'  => 'media_button',
			'title' => 'Опция 12_1',
			'desc'  => 'Описание опции 12_1',
			'value' => '',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => 1,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
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
			'value' => 2,
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
			'value' => '4',
			'options' => [
				'step' => 2,
				'min'  => 0,
				'max'  => 10
			]
		],
		'option_71' => [
			'type'  => 'range',
			'title' => 'Опция 71',
			'desc'  => 'Описание опции 71',
			'value' => '2',
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
			'type'  => 'image',
			'title' => 'Опция 11',
			'desc'  => 'Описание опции 11',
			'value' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAABjElEQVRoge2bWQ6DMAxEe/+z+RAICQ7Bz/SjStWFkM02IcNISFEJ9rwKhawPEcGyLBSXiOARCqNLRLCu6ws4/DCqAtsX8OeNkfTJ9Af8W+Hq+mXZBd6reEXtMUSBYw9cRTHvh8BHD/asI89J4FSA3pTymgWcE6gH5XjMBs4NeJZyvRUBlwT2VImnYuDSBNYq9VIFXJPIQjUeqoFrE2qpNncTcEviFrXkbAZuNeCdSwVYw4hXDjVgwBZaK7YqMGADrRlTHRjQNaj9B5oAAzpGLd4WM2CgzbBVe2AKDNQZt2z8zIGBMgDrz5sLMJAH4vEtdwMGjoG8emuuwMA+mGfX1B0Y+Ab0HnycAgy8QM8Yad3AHqJ6pakaLarPElXHg6prSTV4oBoeUk0AUE3xUE3iUU3TUk3EUy21UC2mUS2XUi2I9wAbZL7loSfYILNNLT3CBqlvW+oZNmiapmSde+thaYAeNc9z9N6w24dj0PcG8VjFqyp5BGAk2KBt295l3mM8I8MGvQ9qhQLDJSJ4AsaVfzhlR3kRAAAAAElFTkSuQmCC',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => 0,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'option_11_2' => [
			'type'  => 'image',
			'title' => 'Опция 11_2',
			'desc'  => 'Описание опции 11_2',
			'value' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAABjElEQVRoge2bWQ6DMAxEe/+z+RAICQ7Bz/SjStWFkM02IcNISFEJ9rwKhawPEcGyLBSXiOARCqNLRLCu6ws4/DCqAtsX8OeNkfTJ9Af8W+Hq+mXZBd6reEXtMUSBYw9cRTHvh8BHD/asI89J4FSA3pTymgWcE6gH5XjMBs4NeJZyvRUBlwT2VImnYuDSBNYq9VIFXJPIQjUeqoFrE2qpNncTcEviFrXkbAZuNeCdSwVYw4hXDjVgwBZaK7YqMGADrRlTHRjQNaj9B5oAAzpGLd4WM2CgzbBVe2AKDNQZt2z8zIGBMgDrz5sLMJAH4vEtdwMGjoG8emuuwMA+mGfX1B0Y+Ab0HnycAgy8QM8Yad3AHqJ6pakaLarPElXHg6prSTV4oBoeUk0AUE3xUE3iUU3TUk3EUy21UC2mUS2XUi2I9wAbZL7loSfYILNNLT3CBqlvW+oZNmiapmSde+thaYAeNc9z9N6w24dj0PcG8VjFqyp5BGAk2KBt295l3mM8I8MGvQ9qhQLDJSJ4AsaVfzhlR3kRAAAAAElFTkSuQmCC',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'image' ],
				'multiple' => 0,
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
				'library'  => [ 'type' => 'audio' ],
				'multiple' => 1,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'option_14' => [
			'type'  => 'media_button',
			'title' => 'Опция 14',
			'desc'  => 'Описание опции 14',
			'value' => '',
			'options' => [
				'title'    => 'Insert a media',
				'library'  => [ 'type' => 'video' ],
				'multiple' => 1,
				'button'   => [ 'text' => 'Insert' ]
			]
		],
		'sticker_fix_bg' => [
			'type'  => 'checkbox',
			'title' => 'sticker fix bg',
			'desc'  => 'sticker fixed background',
			'value' => [],
			'options' => [
				'yes'   => 'Yes'
			]
		]
	],

	'product_cat' => [
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
		]
	]
];
