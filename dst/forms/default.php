<?php

return [
    'name' => 'root',
    'label' => 'Форма',
    'type' => 'form',
    'value' => [
        [
            'name' => 'first_name',
            'label' => 'Имя',
            'type' => 'text',
            'value' => 'Какое-то Имя',
            'required' => true
        ],
        [
            'name' => 'third_name',
            'label' => 'Фамилия',
            'type' => 'text',
            'value' => '',
            'placeholder' => 'Введите фамилию',
            'required' => false
        ],
        [
            'name' => 'mid_name',
            'label' => 'Отчество',
            'type' => 'check',
            'value' => [
                'name' => 'second_name',
                'label' => 'Отчество',
                'type' => 'text',
                'placeholder' => 'Введите отчество',
                'required' => true
            ],
            'state' => 'false',
        ],        
        [
            'name' => 'check_one',
            'label' => 'Необязательно и платно',
            'type' => 'check',
            'value' => 100,
            'state' => 'true',
        ],
        [
            'name' => 'check_two',
            'label' => 'Обязательно и бесплатно',
            'type' => 'check',
            'state' => 'false',
            'required' => true
        ],
        [
            'name' => 'option',
            'label' => 'Обязательно и платно и бесплатно',
            'type' => 'select',
            'value' => [
                [
                    'name' => 'first',
                    'label' => 'Платно',
                    'value' => 100
                ],
                [
                    'name' => 'second',
                    'label' => 'Бесплатно'
                ],
                [
                    'name' => 'third',
                    'value' => 100
                ]
            ],
            'state' => 'second'
        ],
        [
            'name' => 'hardandsoft',
            'label' => 'Разное',
            'type' => 'select',
            'value' => [
                [
                    'name' => 'first',
                ],
                [
                    'name' => 'hard',
                    'label' => 'Cложное',
                    'value' => [
                        'name' => 'hard',
                        'label' => 'Обязательно и бесплатно',
                        'type' => 'check',
                        'state' => 'false',
                        'required' => true
                    ]
                ],
                [
                    'name' => 'hardest',
                    'label' => 'Cложнейшее',
                    'value' => [
                        'name' => 'hardest',
                        'label' => 'Да, Cложнейшее',
                        'type' => 'node',
                        'value' => [
                            [
                                'name' => 'first_name',
                                'label' => 'Еще Имя',
                                'type' => 'text',
                                'value' => 'Какое-то Имя',
                                'required' => false
                            ],
                            [
                                'name' => 'third_name',
                                'label' => 'Еще Фамилия',
                                'type' => 'text',
                                'value' => '',
                                'placeholder' => 'Введите фамилию',
                                'required' => true
                            ],                            
                        ]
                    ]
                ]
            ],
            'state' => 'second'
        ],      
    ],
    'state' => 'Отправить форму и перейти к оплате'
];

?>