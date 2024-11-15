<?php

return [
    'name' => 'root',
    'label' => 'Форма',
    'type' => 'form',
    'value' => [
        [
            'name' => 'text',
            'label' => 'Текст',
            'type' => 'text',
            'value' => 'Какй-то Текст',
            'required' => true
        ],
        [
            'name' => 'check_void',
            'label' => 'Чек Войд',
            'type' => 'check',
            'state' => 'false',
            'required' => true
        ],
        [
            'name' => 'check_cost',
            'label' => 'Чек Кост',
            'type' => 'check',
            'value' => 100,
            'state' => 'true',
        ],
        [
            'name' => 'ceck_parent_text',
            'label' => 'Чек Текст',
            'type' => 'check',
            'value' => [
                'name' => 'ceck_child_text',
                'label' => 'Чек Текст',
                'type' => 'text',
                'placeholder' => 'Введите Текст',
                'required' => true
            ],
            'state' => 'true',
        ],        
        [
            'name' => 'ceck_parent_select',
            'label' => 'Чек Селект',
            'type' => 'check',
            'value' => [
                'name' => 'ceck_child_select',
                'label' => 'Чек Селект',
                'type' => 'select',
                'value' => [
                    [
                        'name' => 'ceck_select_empty',
                    ],
                    [
                        'name' => 'ceck_select_label',
                        'label' => 'Метка'
                    ],
                    [
                        'name' => 'ceck_select_label_value',
                        'label' => 'Метка',
                        'value' => 100
                    ],
                    [
                        'name' => 'ceck_select_parent_text',
                        'value' => 100
                    ],
                    [                
                        'name' => 'ceck_select_child_text',
                        'label' => 'Чек Селект Текст',
                        'value' => [  
                            'name' => 'ceck_select_child_text',
                            'label' => 'Чек Селект Текст',
                            'type' => 'text',
                            'placeholder' => 'Введите Текст',
                            'required' => true
                        ]
                    ],
                    [
                        'name' => 'ceck_select_child_check_void',
                        'label' => 'Чек Селект Чек Войд',
                        'value' => [ 
                            'name' => 'ceck_select_child_check_void',
                            'label' => 'Чек Селект Чек Войд',
                            'type' => 'check',
                            'state' => 'false',
                            'required' => true
                        ]
                    ],
                    [
                        'name' => 'ceck_select_child_check_cost',
                        'label' => 'Чек Селект Чек Кост',
                        'value' => [ 
                            'name' => 'ceck_select_child_check_cost',
                            'label' => 'Чек Селект Кост',
                            'type' => 'check',
                            'value' => 100,
                            'state' => 'true'
                        ]
                    ],
                    [
                        'name' => 'ceck_select_child_div',
                        'label' => 'Чек Селект Див',
                        'value' => [
                            'name' => 'ceck_select_child_div',
                            'label' => 'Чек Селект Див',
                            'type' => 'node',
                            'value' => [
                                [
                                    'name' => 'ceck_select_div_ceck_parent_div',
                                    'label' => 'Чек Селект Див Чек Див',
                                    'type' => 'check',
                                    'value' => [
                                        'name' => 'ceck_select_div_ceck_child_div',
                                        'label' => 'Чек Селект Див Чек Див',
                                        'type' => 'node',
                                        'value' => [
                                            [
                                                'name' => 'other_first_name',
                                                'label' => 'Еще Имя',
                                                'type' => 'text',
                                                'value' => 'Какое-то Имя',
                                                'required' => false
                                            ],
                                            [
                                                'name' => 'other_third_name',
                                                'label' => 'Еще Фамилия',
                                                'type' => 'text',
                                                'value' => '',
                                                'placeholder' => 'Введите фамилию',
                                                'required' => true
                                            ]
                                        ],
                                        'required' => false
                                    ],
                                    'state' => 'true',
                                ], 
                                [
                                    'name' => 'check_last',
                                    'label' => 'Необязательно и платно',
                                    'type' => 'check',
                                    'value' => 100,
                                    'state' => 'true',
                                ]                                                 
                            ]
                        ]
                    ]
                ],
                'state' => 'eck_select_label_value'
            ],
            'state' => 'false',       
        ]     
    ],
    'state' => [
        'GET' => 'Проверить и Подтвердить',
        'POST' => 'Подтвердить и Опатить'
    ]
];

?>