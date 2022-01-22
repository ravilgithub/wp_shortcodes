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
 *   @type Array $term_name/$__to_all__ {
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
		'__to_all__' => [
			'fields' => [
				'option_tmp_1' => [
					'type'  => 'media_button',
					'title' => 'Опция TEMP_1',
					'desc'  => 'Описание опции TEMP_1',
					'empty' => true,
					'value' => '[876]',
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'image' ],
						'multiple' => 0,
						'button'   => [ 'text' => 'Insert' ]
					]
				],
				'option_tmp_2' => [
					'type'  => 'media_button',
					'title' => 'Опция TEMP_2',
					'desc'  => 'Описание опции TEMP_2',
					'empty' => true,
					'value' => '[]',
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'audio' ],
						'multiple' => 0,
						'button'   => [ 'text' => 'Insert' ]
					]
				],
				'option_tmp_3' => [
					'type'  => 'media_button',
					'title' => 'Опция TEMP_3',
					'desc'  => 'Описание опции TEMP_3',
					'empty' => true,
					'value' => '[690,691,694]',
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => [ 'audio', 'video' ] ],
						'multiple' => 0,
						'button'   => [ 'text' => 'Insert' ]
					]
				],
				'option_tmp_4' => [
					'type'  => 'media_button',
					'title' => 'Опция TEMP_4',
					'desc'  => 'Описание опции TEMP_4',
					'empty' => true,
					'value' => '[876,875,874,690,691,694,873,872,857]',
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => [ 'image', 'video', 'audio' ] ],
						'multiple' => 0,
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
					'type'  => 'number',
					'title' => 'Опция 3',
					'desc'  => 'Описание опции 3',
					'empty' => false,
					'value' => 2,
					'options' => [
						'step' => 2,
						'min'  => 0,
						'max'  => 10
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
			]
		],

		'facts' => [
			'fields' => [
				'bg_img' => [
					'type'  => 'media_button',
					'title' => 'Background image',
					'desc'  => '',
					'value' => '[857]',
					'empty' => false,
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'image' ],
						'multiple' => true,
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
			]
		],

		'about' => [
			'fields' => [
				'option_12' => [
					'type'  => 'media_button',
					'title' => 'Опция 12',
					'desc'  => 'Описание опции 12',
					'value' => '[378,377,291,289,292]',
					'empty' => true,
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'image' ],
						'multiple' => 1,
						'button'   => [ 'text' => 'Insert' ]
					]
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
			]
		],

		'solutions' => [
			'fields' => [
				'bg_img' => [
					'type'  => 'media_button',
					'title' => 'Background image',
					'desc'  => '',
					'value' => '[857]',
					'empty' => true,
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'image' ],
						'multiple' => true,
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
			]
		],

		'stickers' => [
			'fields' => [
				'bg_img' => [
					'type'  => 'media_button',
					'title' => 'Background image',
					'desc'  => '',
					'value' => '[802]',
					'empty' => false,
					'options' => [
						'title'    => 'Insert a media',
						'library'  => [ 'type' => 'image' ],
						'multiple' => true,
						'button'   => [ 'text' => 'Insert' ]
					],
				],
				'bg_attachment' => [
					'type'  => 'select',
					'title' => 'Background attachment',
					'desc'  => '',
					'value' => 'fixed',
					'options' => [
						'default'  => 'default',
						'fixed'    => 'Fixed',
						'parallax' => 'Parallax',
						'hidden'   => 'Hidden'
					]
				],
			]
		],


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
		'stickers_background' => [
			'type'  => 'select',
			'title' => 'Stickers back',
			'desc'  => 'Section background position',
			'value' => 'default',
			'options' => [
				'default'  => 'default',
				'fixed'    => 'Fixed',
				'parallax' => 'Parallax',
				'hidden'   => 'Hidden'
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
