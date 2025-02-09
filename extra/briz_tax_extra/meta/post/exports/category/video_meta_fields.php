<?php

/**
 * Мета поля записей термина "video".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */
$video_meta_fields = [
	[
		'title'  => 'Video',
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
