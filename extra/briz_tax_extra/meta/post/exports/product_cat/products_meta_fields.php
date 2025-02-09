<?php
/**
 * Мета поля термина "products".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */
$products_meta_fields = [
	[
		'title'  => 'Product video',
		'fields' => [
			'video_url' => [
				'type'     => 'url',
				'title'    => 'URL Video',
				'desc'     => 'Ссылка на видео.',
				'value'    => 'https://www.youtube.com/watch?v=nBYZpsbu9ds',
				'pattern'  => 'https://.*',
				'required' => true
			],
		]
	],
];
