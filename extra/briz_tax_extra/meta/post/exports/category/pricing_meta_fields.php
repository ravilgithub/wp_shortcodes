<?php
/**
 * Мета поля записей термина "pricing".
 */
$pricing_meta_fields = [
	'fields' => [
		/*'best_price' => [
			'type'  => 'checkbox',
			'title' => 'Best price?',
			'desc'  => 'Отметьте, если это лучшая цена.',
			'empty' => true,
			'value' => [],
			'options' => [
				'on'  => 'On'
			]
		],
		'best_price_text' => [
			'type'  => 'text',
			'title' => 'Текст лейбла "Best price"',
			'desc'  => 'Текст лейбла "Best price"',
			'value' => 'Best price'
		],
		'best_price_text_color' => [
			'type'  => 'color',
			'title' => 'Цвет текста',
			'desc'  => 'Цвет текста лейбла "Best price"',
			'value' => '#ffffff'
		],
		'best_price_bg_color' => [
			'type'  => 'color',
			'title' => 'Цвет фона',
			'desc'  => 'Цвет фона лейбла "Best price"',
			'value' => '#cc0000'
		],*/

		'header' => [
			'type'  => 'text',
			'title' => 'Заголовок',
			'desc'  => 'Заголовок',
			'value' => 'Startup'
		],
		'description' => [
			'type'  => 'textarea',
			'title' => 'Краткое описание',
			'desc'  => 'Краткое описание',
			'value' => 'Lorem Ipsum'
		],
		'currency' => [
			'type'  => 'text',
			'title' => 'Символ валюты',
			'desc'  => 'Символ валюты',
			'value' => '$'
		],
		'price_first' => [
			'type'  => 'number',
			'title' => 'Первая цена',
			'desc'  => 'Первая цена',
			'value' => 23,
			'options' => [
				'step' => 1,
				'min'  => '',
				'max'  => ''
			]
		],
		'price_last' => [
			'type'  => 'number',
			'title' => 'Вторая цена',
			'desc'  => 'Вторая цена',
			'value' => 229,
			'options' => [
				'step' => 1,
				'min'  => '',
				'max'  => ''
			]
		],
		'period_first' => [
			'type'  => 'text',
			'title' => 'Первый период',
			'desc'  => 'Первый период',
			'value' => '/mo'
		],
		'period_last' => [
			'type'  => 'text',
			'title' => 'Второй период',
			'desc'  => 'Второй период',
			'value' => '/yr'
		],
		'content' => [
			'type'  => 'wp_editor',
			'title' => 'Контент карточки',
			'desc'  => 'Контент карточки',
			'value' => '
				<ul>
					<li>Lorem Ipsum Denim Set</li>
					<li><span>10GB</span> Disk Space</li>
					<li><span>100</span> Downloads/month</li>
					<li><span>1</span> Sub Account</li>
					<li><span>Basic</span> Support</li>
				</ul>
			',
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
];
