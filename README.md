Laravel OneCApi
=============

Данный пакет автоматизирует загрузку прайса из 1С через стандартный интерфейс обмена данных.

Я реализую прямую загрузку в бд через модели.

на данном этапе это dev вариант и загружается только группы и каталог, буду признателен если ктото решит потестировать.

#Установка
````
composer require serokuz/laravel-one-c-api --dev
````

#Публикуем config/one-c.php
```
php artisan vendor:publish --provider "Serokuz\OneCApi\OneCApiServiceProvider" --tag="config"
```
