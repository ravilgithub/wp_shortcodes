<?php

/**
 * Мета поля записей термина "experience".
 *
 * Ключи дочерних элементов массивов "fields"
 * должны быть уникальным.
 */

defined( 'ABSPATH' ) || exit;

$experience_meta_fields = [
    [
        'title'  => 'Событие 1',
        'fields' => [
            'card_1' => [
                'type'  => 'group',
                'title' => 'Card 1',
                'desc'  => 'Описание card 1',
                'value' => [
                    'enable' => [
                        'type'  => 'checkbox',
                        'title' => 'Enable card?',
                        'desc'  => '',
                        'empty' => true,
                        'value' => ['on'],
                        'options' => [
                            'on'  => 'On'
                        ]
                    ],
                    'icon' => [
                        'type'  => 'text',
                        'title' => 'Имя иконки',
                        'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
                        'empty' => false,
                        'value' => 'diamond'
                    ],
                    'icon_color' => [
                        'type'  => 'color',
                        'title' => 'Цвет фона иконки',
                        'desc'  => 'Цвет фона иконки',
                        'empty' => true,
                        'value' => ''
                    ],
                    'year' => [
                        'type'  => 'number',
                        'title' => 'Дата',
                        'desc'  => 'Год события',
                        'empty' => false,
                        'value' => 2000,
                        'options' => [
                            'step' => 1,
                            'min'  => '',
                            'max'  => ''
                        ]
                    ],
                    'title' => [
                        'type'  => 'text',
                        'title' => 'Заголовок',
                        'desc'  => 'Имя события',
                        'empty' => false,
                        'value' => 'Freelancer'
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'title' => 'Описание',
                        'desc'  => 'Краткое описание события',
                        'empty' => false,
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
                    ]
                ]
            ],
        ]
    ],

    [
        'title'  => 'Событие 2',
        'fields' => [
            'card_2' => [
                'type'  => 'group',
                'title' => 'Card 2',
                'desc'  => 'Описание card 2',
                'value' => [
                    'enable' => [
                        'type'  => 'checkbox',
                        'title' => 'Enable card?',
                        'desc'  => '',
                        'empty' => true,
                        'value' => ['on'],
                        'options' => [
                            'on'  => 'On'
                        ]
                    ],
                    'icon' => [
                        'type'  => 'text',
                        'title' => 'Имя иконки',
                        'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
                        'empty' => false,
                        'value' => 'diamond'
                    ],
                    'icon_color' => [
                        'type'  => 'color',
                        'title' => 'Цвет фона иконки',
                        'desc'  => 'Цвет фона иконки',
                        'empty' => true,
                        'value' => ''
                    ],
                    'year' => [
                        'type'  => 'number',
                        'title' => 'Дата',
                        'desc'  => 'Год события',
                        'empty' => false,
                        'value' => 2000,
                        'options' => [
                            'step' => 1,
                            'min'  => '',
                            'max'  => ''
                        ]
                    ],
                    'title' => [
                        'type'  => 'text',
                        'title' => 'Заголовок',
                        'desc'  => 'Имя события',
                        'empty' => false,
                        'value' => 'Freelancer'
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'title' => 'Описание',
                        'desc'  => 'Краткое описание события',
                        'empty' => false,
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
                    ]
                ]
            ],
        ]
    ],

    [
        'title'  => 'Событие 3',
        'fields' => [
            'card_3' => [
                'type'  => 'group',
                'title' => 'Card 3',
                'desc'  => 'Описание card 3',
                'value' => [
                    'enable' => [
                        'type'  => 'checkbox',
                        'title' => 'Enable card?',
                        'desc'  => '',
                        'empty' => true,
                        'value' => ['on'],
                        'options' => [
                            'on'  => 'On'
                        ]
                    ],
                    'icon' => [
                        'type'  => 'text',
                        'title' => 'Имя иконки',
                        'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
                        'empty' => false,
                        'value' => 'diamond'
                    ],
                    'icon_color' => [
                        'type'  => 'color',
                        'title' => 'Цвет фона иконки',
                        'desc'  => 'Цвет фона иконки',
                        'empty' => true,
                        'value' => ''
                    ],
                    'year' => [
                        'type'  => 'number',
                        'title' => 'Дата',
                        'desc'  => 'Год события',
                        'empty' => false,
                        'value' => 2000,
                        'options' => [
                            'step' => 1,
                            'min'  => '',
                            'max'  => ''
                        ]
                    ],
                    'title' => [
                        'type'  => 'text',
                        'title' => 'Заголовок',
                        'desc'  => 'Имя события',
                        'empty' => false,
                        'value' => 'Freelancer'
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'title' => 'Описание',
                        'desc'  => 'Краткое описание события',
                        'empty' => false,
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
                    ]
                ]
            ],
        ]
    ],

    [
        'title'  => 'Событие 4',
        'fields' => [
            'card_4' => [
                'type'  => 'group',
                'title' => 'Card 4',
                'desc'  => 'Описание card 4',
                'value' => [
                    'enable' => [
                        'type'  => 'checkbox',
                        'title' => 'Enable card?',
                        'desc'  => '',
                        'empty' => true,
                        'value' => ['on'],
                        'options' => [
                            'on'  => 'On'
                        ]
                    ],
                    'icon' => [
                        'type'  => 'text',
                        'title' => 'Имя иконки',
                        'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
                        'empty' => false,
                        'value' => 'diamond'
                    ],
                    'icon_color' => [
                        'type'  => 'color',
                        'title' => 'Цвет фона иконки',
                        'desc'  => 'Цвет фона иконки',
                        'empty' => true,
                        'value' => ''
                    ],
                    'year' => [
                        'type'  => 'number',
                        'title' => 'Дата',
                        'desc'  => 'Год события',
                        'empty' => false,
                        'value' => 2000,
                        'options' => [
                            'step' => 1,
                            'min'  => '',
                            'max'  => ''
                        ]
                    ],
                    'title' => [
                        'type'  => 'text',
                        'title' => 'Заголовок',
                        'desc'  => 'Имя события',
                        'empty' => false,
                        'value' => 'Freelancer'
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'title' => 'Описание',
                        'desc'  => 'Краткое описание события',
                        'empty' => false,
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
                    ]
                ]
            ],
        ]
    ],

    [
        'title'  => 'Событие 5',
        'fields' => [
            'card_5' => [
                'type'  => 'group',
                'title' => 'Card 5',
                'desc'  => 'Описание card 5',
                'value' => [
                    'enable' => [
                        'type'  => 'checkbox',
                        'title' => 'Enable card?',
                        'desc'  => '',
                        'empty' => true,
                        'value' => ['on'],
                        'options' => [
                            'on'  => 'On'
                        ]
                    ],
                    'icon' => [
                        'type'  => 'text',
                        'title' => 'Имя иконки',
                        'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
                        'empty' => false,
                        'value' => 'diamond'
                    ],
                    'icon_color' => [
                        'type'  => 'color',
                        'title' => 'Цвет фона иконки',
                        'desc'  => 'Цвет фона иконки',
                        'empty' => true,
                        'value' => ''
                    ],
                    'year' => [
                        'type'  => 'number',
                        'title' => 'Дата',
                        'desc'  => 'Год события',
                        'empty' => false,
                        'value' => 2000,
                        'options' => [
                            'step' => 1,
                            'min'  => '',
                            'max'  => ''
                        ]
                    ],
                    'title' => [
                        'type'  => 'text',
                        'title' => 'Заголовок',
                        'desc'  => 'Имя события',
                        'empty' => false,
                        'value' => 'Freelancer'
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'title' => 'Описание',
                        'desc'  => 'Краткое описание события',
                        'empty' => false,
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
                    ]
                ]
            ],
        ]
    ],

    [
        'title'  => 'Событие 6',
        'fields' => [
            'card_6' => [
                'type'  => 'group',
                'title' => 'Card 6',
                'desc'  => 'Описание card 6',
                'value' => [
                    'enable' => [
                        'type'  => 'checkbox',
                        'title' => 'Enable card?',
                        'desc'  => '',
                        'empty' => true,
                        'value' => ['on'],
                        'options' => [
                            'on'  => 'On'
                        ]
                    ],
                    'icon' => [
                        'type'  => 'text',
                        'title' => 'Имя иконки',
                        'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
                        'empty' => false,
                        'value' => 'diamond'
                    ],
                    'icon_color' => [
                        'type'  => 'color',
                        'title' => 'Цвет фона иконки',
                        'desc'  => 'Цвет фона иконки',
                        'empty' => true,
                        'value' => ''
                    ],
                    'year' => [
                        'type'  => 'number',
                        'title' => 'Дата',
                        'desc'  => 'Год события',
                        'empty' => false,
                        'value' => 2000,
                        'options' => [
                            'step' => 1,
                            'min'  => '',
                            'max'  => ''
                        ]
                    ],
                    'title' => [
                        'type'  => 'text',
                        'title' => 'Заголовок',
                        'desc'  => 'Имя события',
                        'empty' => false,
                        'value' => 'Freelancer'
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'title' => 'Описание',
                        'desc'  => 'Краткое описание события',
                        'empty' => false,
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
                    ]
                ]
            ],
        ]
    ],

    [
        'title'  => 'Событие 7',
        'fields' => [
            'card_7' => [
                'type'  => 'group',
                'title' => 'Card 7',
                'desc'  => 'Описание card 7',
                'value' => [
                    'enable' => [
                        'type'  => 'checkbox',
                        'title' => 'Enable card?',
                        'desc'  => '',
                        'empty' => true,
                        'value' => ['on'],
                        'options' => [
                            'on'  => 'On'
                        ]
                    ],
                    'icon' => [
                        'type'  => 'text',
                        'title' => 'Имя иконки',
                        'desc'  => 'Часть класса иконки "Font Awesome".<br /> Пример: fa fa-<имя иконки>',
                        'empty' => false,
                        'value' => 'diamond'
                    ],
                    'icon_color' => [
                        'type'  => 'color',
                        'title' => 'Цвет фона иконки',
                        'desc'  => 'Цвет фона иконки',
                        'empty' => true,
                        'value' => ''
                    ],
                    'year' => [
                        'type'  => 'number',
                        'title' => 'Дата',
                        'desc'  => 'Год события',
                        'empty' => false,
                        'value' => 2000,
                        'options' => [
                            'step' => 1,
                            'min'  => '',
                            'max'  => ''
                        ]
                    ],
                    'title' => [
                        'type'  => 'text',
                        'title' => 'Заголовок',
                        'desc'  => 'Имя события',
                        'empty' => false,
                        'value' => 'Freelancer'
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'title' => 'Описание',
                        'desc'  => 'Краткое описание события',
                        'empty' => false,
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
                    ]
                ]
            ],
        ]
    ],
];
