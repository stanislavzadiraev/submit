<?php

return [
    'name' => 'root',
    'label' => 'Форма',
    'type' => 'form',
    'value' => [
        [
            'name' => 'option',
            'label' => 'Селект',
            'type' => 'select',
            'value' => [
                [
                    'name' => 'first',
                    'type' => 'value',
                    'label' => 'Опция Раз',
                    'value' => 100
                ],
                [
                    'name' => 'second',
                    'type' => 'value',
                    'label' => 'Опция Два',
                    'value' => 200
                ],
                [
                    'name' => 'third',
                    'type' => 'value',
                    'label' => 'Опция Три',
                    'value' => 300
                ]
            ],
            'state' => 'second'
        ],
        [
            'name' => 'first_name',
            'label' => 'Имя',
            'type' => 'text',
            'value' => 'Какое-то Имя',
            'placeholder' => 'Введите ваше имя',
            'required' => true
        ],
        [
            'name' => 'third_name',
            'label' => 'Фамилия',
            'type' => 'text',
            'value' => '',
            'placeholder' => 'Введите вашу фамилию',
            'required' => false
        ],        
        [
            'name' => 'check_one',
            'label' => 'Первый Чек',
            'type' => 'check',
            'value' => [
                [
                    'type' => 'value',
                    'value' => 0
                ],
                [
                    'type' => 'value',
                    'value' => 0
                ],
            ],
            'state' => 'false',
            'required' => true
        ],
        [
            'name' => 'check_two',
            'label' => 'Второй Чек',
            'type' => 'check',
            'value' => [
                [
                    'type' => 'value',
                    'value' => 0
                ],
                [
                    'type' => 'value',
                    'value' => 100
                ],
            ],
            'state' => 'true',
            'required' => false
        ]
    ],
    'state' => 'Отправить форму и перейти к оплате'
];

?>