<?php
/**
 * Мета поля термина "pricing".
 */

defined( 'ABSPATH' ) || exit;

$pricing_meta_fields = [
	'fields' => [
		'trigger_bg_color_enable' => [
			'type'  => 'checkbox',
			'title' => 'Показать цвет фона "Переключатель цены"',
			'desc'  => 'Показать цвет фона "Переключатель цены".',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'trigger_bg_color' => [
			'type'  => 'color',
			'title' => 'Цвет фона элемента "Переключатель цены"',
			'desc'  => 'Цвет фона элемента "Переключатель цены"',
			'value' => '#fbffda'
		],
		'trigger' => [
			'type'  => 'checkbox',
			'title' => 'Trigger',
			'desc'  => 'Показать/Спрятать переключатель цены.',
			'empty' => true,
			'value' => '',
			'options' => [
				'on' => 'On'
			]
		],
		'period_name_first' => [
			'type'  => 'text',
			'title' => 'Название минимального периода',
			'desc'  => 'EN название минимального периода, например: минута, день, месяц',
			'value' => 'Monthly'
		],
		'period_name_last' => [
			'type'  => 'text',
			'title' => 'Название максимального периода',
			'desc'  => 'EN название максимального периода, например: минута, день, месяц',
			'value' => 'Yearly'
		],
		'items_per_row' => [
			'type'  => 'number',
			'title' => 'Карточек в ряд',
			'desc'  => 'Количество карточек в ряд для ширины экрана >= 1200px.',
			'value' => '3',
			'options' => [
				'step' => 1,
				'min'  => 2,
				'max'  => 4
			] 
		],
	]
];
