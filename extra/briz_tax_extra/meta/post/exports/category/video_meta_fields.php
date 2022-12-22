<?php
/**
 * Мета поля записей термина "video".
 */
$video_meta_fields = [
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
];
