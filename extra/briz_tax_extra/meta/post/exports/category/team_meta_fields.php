<?php

/**
 * Мета поля записей термина "team".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */
$team_meta_fields = [
	[
		'title'  => 'Team member',
		'fields' => [
			'member_info' => [
				'type'  => 'text',
				'title' => 'Member info',
				'desc'  => 'Краткая информация о персоне, в двух словах',
				'value' => 'Business Developer'
			],
			'link_to_post' => [
				'type'  => 'checkbox',
				'title' => 'Link to post',
				'desc'  => 'Оформить заголов как ссылку на страницу записи',
				'value' => ['on'],
				'empty' => true,
				'options' => [
					'on' => 'Ссылку на страницу записи?'
				]
			],
		]
	],
	[
		'title'  => 'Member socials',
		'fields' => [
			'member_socials' => [
				'type'  => 'group',
				'title' => 'Social net',
				'desc'  => 'Ссылки на социальные сети',
				'color' => '#ca0',
				'value' => [
					'twitter' => [
						'type'  => 'group',
						'title' => 'twitter',
						'desc'  => '',
						'color' => '#5aa',
						'value' => [
							'social_icon' => [
								'type'  => 'text',
								'title' => 'Имя иконки',
								'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
								'value' => 'twitter'
							],
							'social_url' => [
								'type'     => 'url',
								'title'    => 'Social link',
								'desc'     => 'Ссылка на страницу в социальной сети',
								'value'    => 'https://yandex.ru',
								'pattern'  => 'https://.*',
								'required' => true
							],
						]
					],
					'facebook' => [
						'type'  => 'group',
						'title' => 'Facebook',
						'desc'  => '',
						'color' => '#5aa',
						'value' => [
							'social_icon' => [
								'type'  => 'text',
								'title' => 'Имя иконки',
								'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
								'value' => 'facebook'
							],
							'social_url' => [
								'type'     => 'url',
								'title'    => 'Social link',
								'desc'     => 'Ссылка на страницу в социальной сети',
								'value'    => 'https://yandex.ru',
								'pattern'  => 'https://.*',
								'required' => true
							],
						]
					],
					'vk' => [
						'type'  => 'group',
						'title' => 'VK',
						'desc'  => '',
						'color' => '#5aa',
						'value' => [
							'social_icon' => [
								'type'  => 'text',
								'title' => 'Имя иконки',
								'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
								'value' => 'vk'
							],
							'social_url' => [
								'type'     => 'url',
								'title'    => 'Social link',
								'desc'     => 'Ссылка на страницу в социальной сети',
								'value'    => 'https://yandex.ru',
								'pattern'  => 'https://.*',
								'required' => true
							],
						]
					],
					'google_plus' => [
						'type'  => 'group',
						'title' => 'Google Plus',
						'desc'  => '',
						'color' => '#5aa',
						'value' => [
							'social_icon' => [
								'type'  => 'text',
								'title' => 'Имя иконки',
								'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
								'value' => 'google-plus'
							],
							'social_url' => [
								'type'     => 'url',
								'title'    => 'Social link',
								'desc'     => 'Ссылка на страницу в социальной сети',
								'value'    => 'https://yandex.ru',
								'pattern'  => 'https://.*',
								'required' => true
							],
						]
					],
				]
			],
		]
	],
];
