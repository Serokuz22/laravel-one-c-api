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
            'model'     => \Serokuz\OneCApi\Models\OnecapiGroup::class, // Класс модель для хранения групп
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'parent_id' => 'parent_sku', // Поле для родителя ди из 1с в моедли
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'name' => 'Наименование',
            ],
            // Класс реализации своей логики в ключевых событиях
            'observer'  => '',
        ],
        'product' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiProduct::class,
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'parent_id' => 'group_sku', // Поле для родителя ди из 1с в моедли
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'name' => 'Наименование',
                'barcode' => 'Штрихкод',
                'art' => 'Артикул',
            ],
            // Класс для парсинга загруженных изображений
            // Должен быть реализован интерфейс XmlImageParserInterface
            'images'    => \Serokuz\OneCApi\Parser\XmlImageParser::class,
            // Класс реализации своей логики в ключевых событиях
            'observer'  => '',
        ],
        'attribute_values' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiAttributeValue::class,
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'name' => 'Наименование',
                'value' => 'Значение',
                ]
        ],
        'property' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiProperty::class,
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'name' => 'Наименование',
            ]
        ],
        'property_variants' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiPropertyVariant::class,
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'parent_id' => 'property_sku',
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'property_sku' => 'ИдЗначения',
                'name' => 'Значение',
            ]
        ],
        'property_values' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiPropertyValue::class,
            'id'        => 'product_sku', // Поле ИД для ид из 1с в модели
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'property_sku' => 'Ид',
                'property_variant_sku' => 'Значение',
            ]
        ],

        'price_type' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiPriceType::class,
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'name' => 'Наименование',
                'currency' => 'Валюта',
            ],
            // Класс реализации своей логики в ключевых событиях
            'observer'  => '',
        ],

        // остатки
        'residue' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiProduct::class,
            'id'        => 'sku', // Поле ИД для ид из 1с в модели
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'residue' => 'Количество',
            ],
            'observer'  => '', // только updating и updated
        ],
        'prices' => [
            'model'     => \Serokuz\OneCApi\Models\OnecapiPrice::class,
            'id'        => 'product_sku', // Поле ИД для ид из 1с в модели
            'fillable' => [
                // Соответствие полей из 1с и модели
                // Model->field => 1C->field
                'type_sku' => 'ИдТипаЦены',
                'view' => 'Представление',
                'price_per_unit' => 'ЦенаЗаЕдиницу',
                'currency' => 'Валюта',
                'unit' => 'Единица',
                'ratio' => 'Коэффициент'
            ],
            'observer'  => '', // только updating и updated
        ]
    ],
];
