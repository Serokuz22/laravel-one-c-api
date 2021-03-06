<?php
return [
    'auth' => [
        'login'         => 'admin',
        'password'      => 'admin',
        'session'       => 'onec_session',
    ],
    // Путь для 1С <домен>/exchange_path
    'exchange_path' => 'onec_exchange',
    'setup' => [
        'import_dir'    => storage_path('app/onec'),
        'use_zip'       => true,
        'file_limit'    => 1024 * 1024 * 20,
    ],
    'models' => [
        'group' => [
            'model'     => \App\Models\Group::class, // Класс модель для хранения групп
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'parent_id' => 'parent_sku', // Поле для родителя ди из 1с в моедли
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'name' => 'Наименование',
            ]
        ],
        'product' => [
            'model'     => \App\Models\Product::class, // Класс модель для хранения групп
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'parent_id' => 'group_sku', // Поле для родителя ди из 1с в моедли
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'name' => 'Наименование',
                'barcode' => 'Штрихкод',
                'art' => 'Артикул',
            ]
        ],
    ],
];
